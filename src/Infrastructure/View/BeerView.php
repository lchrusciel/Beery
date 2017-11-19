<?php

declare(strict_types=1);

namespace App\Infrastructure\View;

class BeerView
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var int */
    private $abv;

    public function __construct(string $name, int $abv)
    {
        $this->name = $name;
        $this->abv = $abv;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function abv(): int
    {
        return $this->abv;
    }
}
