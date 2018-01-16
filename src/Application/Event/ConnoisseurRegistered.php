<?php

declare(strict_types=1);

namespace App\Application\Event;

use App\Domain\Connoisseur\Model\Email;
use App\Domain\Connoisseur\Model\Id;
use App\Domain\Connoisseur\Model\Name;
use App\Domain\Connoisseur\Model\Password;
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

    public static function occur(Id $id, Name $name, Email $email, Password $password)
    {
        return new self([
            'id' => $id->value(),
            'name' => $name->value(),
            'email' => $email->value(),
            'password' => $password->value(),
        ]);
    }

    public function id(): Id
    {
        return new Id($this->payload()['id']);
    }

    public function name(): Name
    {
        return new Name($this->payload()['name']);
    }

    public function email(): Email
    {
        return new Email($this->payload()['email']);
    }

    public function password(): Password
    {
        return new Password($this->payload()['password']);
    }
}
