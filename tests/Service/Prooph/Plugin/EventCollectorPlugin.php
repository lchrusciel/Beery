<?php

declare(strict_types=1);

namespace Tests\Service\Prooph\Plugin;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Prooph\Bundle\ServiceBus\NamedMessageBus;
use Prooph\Common\Event\ActionEvent;
use Prooph\ServiceBus\Exception\RuntimeException;
use Prooph\ServiceBus\MessageBus;
use Prooph\ServiceBus\Plugin\Plugin;
use Prooph\ServiceBus\QueryBus;

final class EventCollectorPlugin implements Plugin, EventsRecorder
{
    /** @var array */
    private $listenerHandlers = [];

    /** @var array */
    private $buses = [];

    /** @var Collection */
    private $messages;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
    }

    public function attachToMessageBus(MessageBus $messageBus): void
    {
        if ($messageBus instanceof QueryBus) {
            return;
        }

        $this->buses[] = $messageBus;
        if (!$messageBus instanceof NamedMessageBus) {
            throw new RuntimeException(sprintf(
                'To use the EventCollector, the Bus "%s" needs to implement "%s"',
                $messageBus,
                NamedMessageBus::class
            ));
        }

        $this->listenerHandlers[] = $messageBus->attach(
            MessageBus::EVENT_FINALIZE,
            function (ActionEvent $actionEvent) {
                $this->messages->add($this->createContextFromActionEvent($actionEvent));
            },
            MessageBus::PRIORITY_INVOKE_HANDLER - 50
        );
    }

    public function detachFromMessageBus(MessageBus $messageBus): void
    {
        foreach ($this->listenerHandlers as $listenerHandler) {
            $messageBus->detach($listenerHandler);
        }

        $this->listenerHandlers = [];
    }

    public function getLastMessage(): CollectedMessage
    {
        return $this->messages->last();
    }

    /**
     * {@inheritdoc}
     */
    public function getAllMessages(): Collection
    {
        return $this->messages;
    }

    private function createContextFromActionEvent(ActionEvent $event): CollectedMessage
    {
        return new CollectedMessage(
            $event->getParam('message'),
            $event->getParam('message-handled')
        );
    }
}
