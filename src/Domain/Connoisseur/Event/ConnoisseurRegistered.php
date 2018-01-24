<?php

declare(strict_types=1);

namespace App\Domain\Connoisseur\Event;

use App\Domain\Connoisseur\Model\Email;
use App\Domain\Connoisseur\Model\Id;
use App\Domain\Connoisseur\Model\Name;
use App\Domain\Connoisseur\Model\Password;
use Prooph\EventSourcing\AggregateChanged;

final class ConnoisseurRegistered extends AggregateChanged
{
    public static function withData(Id $id, Name $name, Email $email, Password $password)
    {
        return self::occur($id->value(), [
            'name' => $name->value(),
            'email' => $email->value(),
            'password' => $password->value(),
        ]);
    }

    public function id(): Id
    {
        return new Id($this->aggregateId());
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
