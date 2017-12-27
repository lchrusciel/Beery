<?php

declare(strict_types=1);

namespace Tests\Behat\Context\Setup;

use App\Application\Command\AddBeer;
use App\Domain\Model\Abv;
use App\Domain\Model\Id;
use App\Domain\Model\Name;
use App\Infrastructure\Generator\UuidGeneratorInterface;
use Behat\Behat\Context\Context;
use Prooph\ServiceBus\CommandBus;

final class BeerContext implements Context
{
    /** @var CommandBus */
    private $commandBus;

    /** @var UuidGeneratorInterface */
    private $generator;

    public function __construct(CommandBus $commandBus, UuidGeneratorInterface $generator)
    {
        $this->commandBus = $commandBus;
        $this->generator = $generator;
    }

    /**
     * @Given the :name beer with :abv% ABV has been added
     */
    public function theBeerWithAbvHasBeenAdded(string $name, int $abv): void
    {
        $this->commandBus->dispatch(AddBeer::create(new Id($this->generator->generate()), new Name($name), new Abv($abv)));
    }
}
