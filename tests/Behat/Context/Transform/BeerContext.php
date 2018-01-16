<?php

declare(strict_types=1);

namespace Tests\Behat\Context\Transform;

use App\Application\Repository\Beers;
use App\Domain\Beer\Model\Beer;
use Behat\Behat\Context\Context;

final class BeerContext implements Context
{
    /** @var Beers */
    private $beers;

    public function __construct(Beers $beers)
    {
        $this->beers = $beers;
    }

    /**
     * @Transform /^"([^"]+)" beer$/
     * @Transform :beer
     */
    public function getBeerByName(string $beerName): Beer
    {
        return $this->beers->getByName($beerName);
    }
}
