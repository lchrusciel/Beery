<?php

declare(strict_types=1);

namespace App\Application\Event;

use App\Domain\Model\Email;
use App\Domain\Model\Name;
use App\Domain\Model\Password;
use Prooph\Common\Messaging\DomainEvent;
use Prooph\Common\Messaging\PayloadTrait;

final class ConnoisseurRegistered extends DomainEvent
{
    use PayloadTrait;

    private function __construct(array $payload)
    {
        $this->init();
        $this->setPayload($payload);
    }

    public static function occur(Name $name, Email $email, Password $password)
    {
        return new self([
            'name' => $name->value(),
            'email' => $email->value(),
            'password' => $password->value(),
        ]);
    }

    public function name(): Name
    {
        return new Name($this->payload()['name']);
    }

    public function email(): Email
    {
        return new Email($this->payload()['email']);
    }

    public function password(): password
    {
        return new Password($this->payload()['password']);
    }
}
