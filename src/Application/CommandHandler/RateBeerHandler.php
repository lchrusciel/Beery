<?php

declare(strict_types=1);

namespace App\Application\CommandHandler;

use App\Application\Command\RateBeer;
use App\Application\Event\BeerRated;
use App\Application\Repository\Beers;
use Prooph\ServiceBus\EventBus;

final class RateBeerHandler
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

    public function __invoke(RateBeer $rateBeer): void
    {
        $beer = $this->beers->get($rateBeer->beerId());

        $beer->rate($rateBeer->rate());

        $this->eventBus->dispatch(BeerRated::occur(
            $rateBeer->connoisseurId(),
            $rateBeer->beerId(),
            $rateBeer->rate()
        ));
    }
}
