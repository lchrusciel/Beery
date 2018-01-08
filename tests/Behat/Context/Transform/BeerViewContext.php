<?php

declare(strict_types=1);

namespace Tests\Behat\Context\Transform;

use App\Infrastructure\ReadModel\View\BeerView;
use App\Infrastructure\Repository\BeerViews;
use Behat\Behat\Context\Context;

final class BeerViewContext implements Context
{
    /** @var BeerViews */
    private $beerViews;

    public function __construct(BeerViews $beerViews)
    {
        $this->beerViews = $beerViews;
    }

    /**
     * @Transform :beerView
     */
    public function getBeerByName(string $beerName): BeerView
    {
        return $this->beerViews->getByName($beerName);
    }
}
