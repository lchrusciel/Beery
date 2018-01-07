<?php

declare(strict_types=1);

namespace Tests\Behat\Context\Setup;

use App\Application\Command\RateBeer;
use App\Domain\Model\Beer;
use App\Domain\Model\Connoisseur;
use App\Domain\Model\Rate;
use Behat\Behat\Context\Context;
use Prooph\ServiceBus\CommandBus;

final class RateContext implements Context
{
    /** @var CommandBus */
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @Given the :connoisseur connoisseur rated the :beer beer :rate
     */
    public function theBeerWithAbvHasBeenAdded(Connoisseur $connoisseur, Beer $beer, float $rate): void
    {
        $this->commandBus->dispatch(RateBeer::create($connoisseur->email(), $beer->id(), new Rate($rate)));
    }
}
