<?php

declare(strict_types=1);

namespace App\Application\CommandHandler;

use App\Application\Command\RateBeer;
use App\Application\Repository\Beers;

final class RateBeerHandler
{
    /** @var Beers */
    private $beers;

    public function __construct(Beers $beers)
    {
        $this->beers = $beers;
    }

    public function __invoke(RateBeer $rateBeer): void
    {
        $beer = $this->beers->get($rateBeer->beerId());

        $beer->rate($rateBeer->connoisseurEmail(), $rateBeer->rate());
    }
}
