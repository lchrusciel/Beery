<?php

declare(strict_types=1);

namespace Tests\Service\Prooph\Spec;

use Prooph\Common\Messaging\Message;

final class MessagePrototype
{
    /** @var callable */
    private $assertion;

    public function __construct(callable $assertion)
    {
        $this->assertion = $assertion;
    }

    public static function withName(string $name): self
    {
        return new self(function (Message $message) use ($name): bool {
            return $message->messageName() === $name;
        });
    }

    public function matches(Message $message): bool
    {
        return ($this->assertion)($message);
    }
}
