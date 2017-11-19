<?php

declare(strict_types=1);

namespace Tests\Behat\Context;

use App\Application\Command\AddBeer;
use Behat\Behat\Context\Context;
use Prooph\ServiceBus\CommandBus;

final class SetupContext implements Context
{
    /** @var CommandBus */
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @Given the :name beer with :abv% ABV has been added
     */
    public function theBeerWithAbvHasBeenAdded(string $name, int $abv): void
    {
        $this->commandBus->dispatch(AddBeer::create($name, $abv));
    }
}
