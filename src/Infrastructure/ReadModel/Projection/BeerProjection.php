<?php

declare(strict_types=1);

namespace App\Infrastructure\ReadModel\Projection;

use App\Application\Event\BeerAdded;
use App\Infrastructure\ReadModel\View\BeerView;
use App\Infrastructure\Repository\BeerViews;

final class BeerProjection
{
    /** @var BeerViews */
    private $beerViews;

    public function __construct(BeerViews $beerViews)
    {
        $this->beerViews = $beerViews;
    }

    public function __invoke(BeerAdded $beerAdded): void
    {
        $id = $beerAdded->id();
        $name = $beerAdded->name();
        $abv = $beerAdded->abv();

        $this->beerViews->add(new BeerView($id->value(), $name->value(), $abv->value()));
    }
}
