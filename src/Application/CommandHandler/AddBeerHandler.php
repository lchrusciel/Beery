<?php

declare(strict_types=1);

namespace App\Application\CommandHandler;

use App\Application\Command\AddBeer;
use App\Application\Repository\Beers;
use App\Domain\Beer\Model\Beer;

final class AddBeerHandler
{
    /** @var Beers */
    private $beers;

    public function __construct(Beers $beers)
    {
        $this->beers = $beers;
    }

    public function __invoke(AddBeer $addBeer): void
    {
        $beer = Beer::add(
            $addBeer->id(),
            $addBeer->name(),
            $addBeer->abv()
        );

        $this->beers->add($beer);
    }
}
