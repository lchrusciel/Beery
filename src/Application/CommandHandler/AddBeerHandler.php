<?php

declare(strict_types=1);

namespace App\Application\CommandHandler;

use App\Application\Command\AddBeer;
use App\Application\Repository\Beers;
use App\Domain\Event\BeerAdded;
use App\Domain\Model\Beer;
use Doctrine\Common\Persistence\ObjectManager;
use Prooph\ServiceBus\EventBus;

final class AddBeerHandler
{
    /** @var EventBus */
    private $eventBus;

    /** @var Beers */
    private $beers;

    public function __construct(EventBus $eventBus, Beers $beers)
    {
        $this->eventBus = $eventBus;
        $this->beers = $beers;
    }

    public function __invoke(AddBeer $addBeer)
    {
        $beer = Beer::add(
            $addBeer->beerName(),
            $addBeer->abv()
        );

        $this->beers->add($beer);

        $this->eventBus->dispatch(BeerAdded::occur(
            $addBeer->beerName(),
            $addBeer->abv()
        ));
    }
}
