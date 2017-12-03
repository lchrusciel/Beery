<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\Exception\InvalidAbvValueException;

final class Abv
{
    /** @var float */
    private $value;

    public function __construct(float $value)
    {
        if ($value < 0 || $value > 100) {
            throw new InvalidAbvValueException();
        }

        $this->value = $value;
    }

    public function value(): float
    {
        return $this->value;
    }
}
