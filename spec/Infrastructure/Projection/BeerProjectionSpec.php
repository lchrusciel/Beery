<?php

declare(strict_types=1);

namespace spec\App\Infrastructure\Projection;

use App\Domain\Event\BeerAdded;
use App\Infrastructure\Projection\BeerProjection;
use App\Infrastructure\View\BeerView;
use Doctrine\Common\Persistence\ObjectManager;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class BeerProjectionSpec extends ObjectBehavior
{
    function let(ObjectManager $objectManager)
    {
        $this->beConstructedWith($objectManager);
    }

    function it_is_a_beer_projection(): void
    {
        $this->shouldHaveType(BeerProjection::class);
    }

    function it_creates_a_beer_view(
        ObjectManager $objectManager
    ) {
        $objectManager
            ->persist(Argument::that(function (BeerView $beerView) {
                return $beerView == new BeerView('King of Hop', 5);
            }))
            ->shouldBeCalled()
        ;

        $objectManager->flush()->shouldBeCalled();

        $this(BeerAdded::occur('King of Hop', 5));
    }
}
