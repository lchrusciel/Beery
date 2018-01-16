<?php

declare(strict_types=1);

namespace App\Domain\Connoisseur\Model;

class Connoisseur
{
    /** @var Id */
    private $id;

    /** @var Name */
    private $name;

    /** @var Email */
    private $email;

    /** @var Password */
    private $password;

    private function __construct(Id $id, Name $name, Email $email, Password $password)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public static function register(Id $id, Name $name, Email $email, Password $password): self
    {
        return new self($id, $name, $email, $password);
    }

    public function id(): Id
    {
        return $this->id;
    }

    public function email(): Email
    {
        return $this->email;
    }
}
