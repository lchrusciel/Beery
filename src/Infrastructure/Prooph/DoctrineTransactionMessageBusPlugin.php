<?php

declare(strict_types=1);

namespace App\Infrastructure\Prooph;

use Doctrine\Common\Persistence\ObjectManager;
use Prooph\Common\Event\ListenerHandler;
use Prooph\ServiceBus\MessageBus;
use Prooph\ServiceBus\Plugin\Plugin;

final class DoctrineTransactionMessageBusPlugin implements Plugin
{
    /** @var ObjectManager */
    private $objectManager;

    /** @var ListenerHandler|null */
    private $listenerHandler;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function attachToMessageBus(MessageBus $messageBus): void
    {
        $this->listenerHandler = $messageBus->attach(
            MessageBus::EVENT_FINALIZE,
            function (): void {
                $this->objectManager->flush();
            },
            -100
        );
    }

    public function detachFromMessageBus(MessageBus $messageBus): void
    {
        if ($this->listenerHandler === null) {
            return;
        }

        $messageBus->detach($this->listenerHandler);
    }
}
