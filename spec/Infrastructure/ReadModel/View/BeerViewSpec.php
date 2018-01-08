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

    function it_is_simplified_beer_view()
    {
        $this->getId()->shouldReturn('e8a68535-3e17-468f-acc3-8a3e0fa04a59');
        $this->getName()->shouldReturn('King of Hop');
        $this->getAbv()->shouldReturn('5.00');
        $this->getAmountOfRates()->shouldReturn(0);
        $this->getAverageRate()->shouldReturn('0.00');
    }

    function it_can_be_rated()
    {
        $this->rate(5);
        $this->rate(3);

        $this->getAmountOfRates()->shouldReturn(2);
        $this->getAverageRate()->shouldReturn('4.00');
    }
}
