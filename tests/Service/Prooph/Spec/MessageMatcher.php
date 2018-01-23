<?php

declare(strict_types=1);

namespace Tests\Service\Prooph\Spec;

use Prooph\Common\Messaging\Message;

final class MessageMatcher
{
    public function isOneOf($message, array $producedMessages): bool
    {
        if ($message instanceof MessagePrototype) {
            return $this->matchesPartialMessage($message, $producedMessages);
        }

        if ($message instanceof Message) {
            return in_array($this->normalizeMessage($message), $this->normalizeMessages($producedMessages), true);
        }

        throw new \InvalidArgumentException(sprintf(
            'Passed message must either implement "%s" or "%s"!',
            MessagePrototype::class,
            Message::class
        ));
    }

    private function matchesPartialMessage(MessagePrototype $messagePrototype, array $producedMessages): bool
    {
        foreach ($producedMessages as $producedMessage) {
            if ($messagePrototype->matches($producedMessage)) {
                return true;
            }
        }

        return false;
    }

    private function normalizeMessage(Message $message): array
    {
        return [
            $message->messageType(),
            $message->payload(),
        ];
    }

    private function normalizeMessages(array $messages): array
    {
        return array_map([$this, 'normalizeMessage'], $messages);
    }
}
