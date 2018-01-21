<?php

declare(strict_types=1);

namespace App\Application\Repository;

use App\Domain\Beer\Model\Beer;
use App\Domain\Beer\Model\Id;

interface Beers
{
    public function add(Beer $beer): void;

    public function getByName(string $beerName): Beer;

    public function get(Id $id): Beer;

    public function save(Beer $beer): void;
}
