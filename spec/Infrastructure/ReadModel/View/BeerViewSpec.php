<?php

declare(strict_types=1);

namespace spec\App\Infrastructure\ReadModel\View;

use App\Infrastructure\ReadModel\View\BeerView;
use PhpSpec\ObjectBehavior;

final class BeerViewSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('e8a68535-3e17-468f-acc3-8a3e0fa04a59', 'King of Hop', 5);
    }

    function it_is_a_beer_view(): void
    {
        $this->shouldHaveType(BeerView::class);
    }

    function it_has_a_name()
    {
        $this->name()->shouldReturn('King of Hop');
    }

    function it_has_an_abv()
    {
        $this->abv()->shouldReturn('5.00');
    }
}
