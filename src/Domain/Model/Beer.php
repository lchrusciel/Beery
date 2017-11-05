<?php

declare(strict_types=1);

namespace App\Domain\Model;

use Ramsey\Uuid\UuidInterface;

class Beer
{
    /** @var UuidInterface */
    private $id;

    /** @var string */
    private $name;

    /** @var int */
    private $abv;

    private function __construct(string $name, int $abv)
    {
        $this->name = $name;
        $this->abv = $abv;
    }

    public static function add(string $name, int $abv): self
    {
        return new self($name, $abv);
    }
}
