<?php

declare(strict_types=1);

namespace App\Infrastructure\Prooph;

use Prooph\Common\Messaging\Message;
use Prooph\EventSourcing\AggregateChanged;

trait ApplyMethodDispatcherTrait
{
    protected function apply(AggregateChanged $event): void
    {
        $this->applyMessage($event);
    }

    protected function applyMessage(Message $event): void
    {
        $eventClass = get_class($event);
        $applyMethodName = strtolower('apply' . substr($eventClass, strrpos($eventClass, '\\') + 1));
        $applyMethodNames = array_map(
            function (string $class): string {
                return strtolower($class);
            },
            get_class_methods(static::class)
        );

        if (!in_array($applyMethodName, $applyMethodNames, true)) {
            return;
        }

        $this->$applyMethodName($event);
    }
}
