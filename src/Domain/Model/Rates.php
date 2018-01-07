<?php

declare(strict_types=1);

namespace App\Domain\Model;

final class Rates
{
    private $rates = [];

    public function add(Rate $rates): void
    {
        $this->rates[] = $rates;
    }
}
