<?php

declare(strict_types=1);

namespace App\Infrastructure\ReadModel\View;

class BeerView
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var float */
    private $abv;

    /** @var int */
    private $amountOfRates = 0;

    /** @var float */
    private $averageRate = 0.;

    public function __construct(string $id, string $name, float $abv)
    {
        $this->id = $id;
        $this->name = $name;
        $this->abv = $abv;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAbv(): string
    {
        return number_format($this->abv, 2);
    }

    public function getAmountOfRates(): int
    {
        return $this->amountOfRates;
    }

    public function getAverageRate(): string
    {
        return number_format($this->averageRate, 2);
    }

    public function rate(float $rate): void
    {
        $this->averageRate = ($this->averageRate * $this->amountOfRates + $rate) / ($this->amountOfRates + 1);
        ++$this->amountOfRates;
    }
}
