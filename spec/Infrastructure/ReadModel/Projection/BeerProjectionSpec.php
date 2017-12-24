<?php

declare(strict_types=1);

namespace spec\App\Infrastructure\ReadModel\Projection;

use App\Application\Event\BeerAdded;
use App\Domain\Model\Abv;
use App\Domain\Model\Name;
use App\Infrastructure\ReadModel\Projection\BeerProjection;
use App\Infrastructure\ReadModel\View\BeerView;
use App\Infrastructure\Repository\BeerViews;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class BeerProjectionSpec extends ObjectBehavior
{
    function let(BeerViews $beerViews)
    {
        $this->beConstructedWith($beerViews);
    }

    function it_is_a_beer_projection(): void
    {
        $this->shouldHaveType(BeerProjection::class);
    }

    function it_creates_a_beer_view(BeerViews $beerViews)
    {
        $beerViews->add(Argument::exact(new BeerView('King of Hop', 5)))->shouldBeCalled();

        $this(BeerAdded::occur(new Name('King of Hop'), new Abv(5)));
    }
}
