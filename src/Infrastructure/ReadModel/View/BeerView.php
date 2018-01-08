<?php

declare(strict_types=1);

namespace App\Infrastructure\ReadModel\View;

class BeerView
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $abv;

    /** @var int */
    private $amountOfRates = 0;

    /** @var string */
    private $rate = '0.00';

    public function __construct(string $id, string $name, float $abv)
    {
        $this->id = $id;
        $this->name = $name;
        $this->abv = number_format($abv, 2);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function abv(): string
    {
        return $this->abv;
    }
}
