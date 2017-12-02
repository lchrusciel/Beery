<?php

declare(strict_types=1);

namespace Tests\Behat\Context\Application;

use App\Application\Command\AddBeer;
use App\Application\Event\BeerAdded;
use App\Domain\Model\Beer;
use Behat\Behat\Context\Context;
use Prooph\ServiceBus\CommandBus;
use Tests\Service\Prooph\Plugin\EventsRecorder;
use Webmozart\Assert\Assert;

final class BeerContext implements Context
{
    /** @var CommandBus */
    private $commandBus;

    /** @var EventsRecorder */
    private $eventsRecorder;

    public function __construct(CommandBus $commandBus, EventsRecorder $eventsRecorder)
    {
        $this->commandBus = $commandBus;
        $this->eventsRecorder = $eventsRecorder;
    }

    /**
     * @When I add a new :beerName beer which has :abv% ABV
     */
    public function iAddANewBeerWhichHasAbv(string $beerName, int $abv): void
    {
        $this->commandBus->dispatch(AddBeer::create($beerName, $abv));
    }

    /**
     * @Then the :beerName beer should be available in the catalogue
     */
    public function theBeerShouldBeAvailableInTheCatalogue(string $beerName): void
    {
        $message = $this->eventsRecorder->getLastMessage();

        $event = $message->event();
        \assert($event instanceof BeerAdded, sprintf(
            'Event has to be of class %s, but %s given',
            BeerAdded::class,
            get_class($event)
        ));
        Assert::same($event->name(), $beerName);
    }
}
