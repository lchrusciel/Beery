<?php

declare(strict_types=1);

namespace Tests\Behat\Context;

use App\Application\Command\AddBeer;
use App\Domain\Model\Beer;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Doctrine\Common\Persistence\ObjectManager;
use Prooph\ServiceBus\CommandBus;
use Webmozart\Assert\Assert;

final class ApplicationContext implements Context
{
    /** @var CommandBus */
    private $commandBus;

    /** @var ObjectManager */
    private $objectManager;

    public function __construct(CommandBus $commandBus, ObjectManager $objectManager)
    {
        $this->commandBus = $commandBus;
        $this->objectManager = $objectManager;
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
        Assert::notNull(
            $this->objectManager->getRepository(Beer::class)->findOneBy(['name' => $beerName]),
            'The beer has not been found!'
        );
    }
}
