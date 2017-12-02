<?php

declare(strict_types=1);

namespace Tests\Service\Prooph\Plugin;

use Prooph\Common\Messaging\DomainEvent;

final class CollectedMessage
{
    /** @var DomainEvent */
    private $event;

    /** @var bool */
    private $handled;

    public function __construct(DomainEvent $event, bool $handled)
    {
        $this->event = $event;
        $this->handled = $handled;
    }

    public function event(): DomainEvent
    {
        return $this->event;
    }

    public function isHandled(): bool
    {
        return $this->handled;
    }
}
