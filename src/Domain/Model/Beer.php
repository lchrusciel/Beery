<?php

declare(strict_types=1);

namespace App\Domain\Model;

use Ramsey\Uuid\UuidInterface;

class Beer
{
    /** @var UuidInterface */
    private $id;

    /** @var Name */
    private $name;

    /** @var Abv */
    private $abv;

    private function __construct(Name $name, Abv $abv)
    {
        $this->name = $name;
        $this->abv = $abv;
    }

    public static function add(Name $name, Abv $abv): self
    {
        return new self($name, $abv);
    }
}
