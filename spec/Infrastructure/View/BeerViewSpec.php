<?php

declare(strict_types=1);

namespace spec\App\Infrastructure\View;

use App\Infrastructure\View\BeerView;
use PhpSpec\ObjectBehavior;

final class BeerViewSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('King of Hop', 5);
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
        $this->abv()->shouldReturn(5);
    }
}
