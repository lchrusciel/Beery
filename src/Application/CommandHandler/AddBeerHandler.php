<?php

declare(strict_types=1);

namespace App\Application\CommandHandler;

use App\Application\Command\AddBeer;
use App\Application\Event\BeerAdded;
use App\Application\Repository\Beers;
use App\Domain\Model\Beer;
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

    public function __invoke(AddBeer $addBeer): void
    {
        $this->beers->add(Beer::add(
            $addBeer->id(),
            $addBeer->name(),
            $addBeer->abv()
        ));

        $this->eventBus->dispatch(BeerAdded::occur(
            $addBeer->id(),
            $addBeer->name(),
            $addBeer->abv()
        ));
    }
}
