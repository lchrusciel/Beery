<?php

declare(strict_types=1);

namespace App\Infrastructure\ReadModel\Projection;

use App\Domain\ApplyMethodDispatcherTrait;
use App\Domain\Beer\Event\BeerAdded;
use App\Domain\Beer\Event\BeerRated;
use App\Infrastructure\ReadModel\View\BeerView;
use App\Infrastructure\Repository\BeerViews;

final class BeerProjection
{
    use ApplyMethodDispatcherTrait {
        applyMessage as public __invoke;
    }

    /** @var BeerViews */
    private $beerViews;

    public function __construct(BeerViews $beerViews)
    {
        $this->beerViews = $beerViews;
    }

    public function applyBeerAdded(BeerAdded $beerAdded): void
    {
        $id = $beerAdded->id();
        $name = $beerAdded->name();
        $abv = $beerAdded->abv();

        $this->beerViews->add(new BeerView($id->value(), $name->value(), $abv->value()));
    }

    public function applyBeerRated(BeerRated $beerRated): void
    {
        $rate = $beerRated->rate();

        $beerView = $this->beerViews->get($beerRated->beerId());

        $beerView->rate($rate->value());

        $this->beerViews->save();
    }
}
