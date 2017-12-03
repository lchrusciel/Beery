<?php

declare(strict_types=1);

namespace App\Domain\Model;

use Ramsey\Uuid\UuidInterface;

class Connoisseur
{
    /** @var UuidInterface */
    private $id;

    /** @var Name */
    private $name;

    /** @var Email */
    private $email;

    /** @var Password */
    private $password;

    private function __construct(Name $name, Email $email, Password $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public static function register(Name $name, Email $email, Password $password): self
    {
        return new self($name, $email, $password);
    }
}
