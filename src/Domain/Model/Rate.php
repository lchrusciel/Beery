<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\Exception\InvalidRateValueException;

final class Rate
{
    /** @var float */
    private $rate;

    public function __construct(float $rate)
    {
        $this->validateRate($rate);
        $this->rate = $rate;
    }

    public function value(): float
    {
        return $this->rate;
    }

    private function validateRate($rate): void
    {
        if ($rate < 1 || $rate > 5) {
            throw new InvalidRateValueException();
        }
    }
}
