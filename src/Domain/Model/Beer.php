<?php

declare(strict_types=1);

namespace App\Domain\Model;

class Beer
{
    /** @var Id */
    private $id;

    /** @var Name */
    private $name;

    /** @var Abv */
    private $abv;

    private function __construct(Id $id, Name $name, Abv $abv)
    {
        $this->id = $id;
        $this->name = $name;
        $this->abv = $abv;
    }

    public static function add(Id $id, Name $name, Abv $abv): self
    {
        return new self($id, $name, $abv);
    }
}
