<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Connoisseur\Model\Email;
use App\Domain\Connoisseur\Model\Id;
use App\Domain\Connoisseur\Model\Name;
use App\Domain\Connoisseur\Model\Password;
use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadTrait;

final class RegisterConnoisseur extends Command
{
    use PayloadTrait;

    private function __construct(array $payload)
    {
        $this->init();
        $this->setPayload($payload);
    }

    public static function create(Id $id, Name $name, Email $email, Password $password)
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

    public function password(): password
    {
        return new Password($this->payload()['password']);
    }
}
