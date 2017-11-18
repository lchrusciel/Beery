<?php

declare(strict_types=1);

namespace App\Application\Repository;

use App\Domain\Model\Beer;

interface Beers
{
    public function add(Beer $beer): void;
}
