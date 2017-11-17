<?php

declare(strict_types=1);

namespace spec\App\Infrastructure\View;

use App\Infrastructure\View\BeerView;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

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

    function it_has_title()
    {
        $this->title()->shouldReturn('King of Hop');
    }

    function it_has_abv()
    {
        $this->abv()->shouldReturn(5);
    }
}
