<?php

declare(strict_types=1);

namespace App\Application\CommandHandler;

use App\Application\Command\AddBeer;
use App\Domain\Event\BeerAdded;
use App\Domain\Model\Beer;
use Doctrine\Common\Persistence\ObjectManager;
use Prooph\ServiceBus\EventBus;

final class AddBeerHandler
{
    /** @var ObjectManager */
    private $objectManager;

    /** @var EventBus */
    private $eventBus;

    public function __construct(ObjectManager $objectManager, EventBus $eventBus)
    {
        $this->objectManager = $objectManager;
        $this->eventBus = $eventBus;
    }

    public function __invoke(AddBeer $addBeer)
    {
        $beer = Beer::add(
            $addBeer->beerName(),
            $addBeer->abv()
        );

        $this->objectManager->persist($beer);

        $this->objectManager->flush();

        $this->eventBus->dispatch(BeerAdded::occur(
            $addBeer->beerName(),
            $addBeer->abv()
        ));
    }
}
