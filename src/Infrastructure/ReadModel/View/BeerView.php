<?php

declare(strict_types=1);

namespace App\Infrastructure\ReadModel\View;

class BeerView
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var float */
    private $abv;

    public function __construct(string $name, float $abv)
    {
        $this->name = $name;
        $this->abv = $abv;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function abv(): float
    {
        return $this->abv;
    }
}
