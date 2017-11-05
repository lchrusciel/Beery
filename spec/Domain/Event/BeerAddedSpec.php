<?php

declare(strict_types=1);

namespace spec\App\Domain\Event;

use App\Domain\Event\BeerAdded;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class BeerAddedSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('occur', [
            'King of Hop',
            5,
        ]);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(BeerAdded::class);
    }

    function it_has_name()
    {
        $this->name()->shouldReturn('King of Hop');
    }

    function it_has_abv()
    {
        $this->abv()->shouldReturn(5);
    }
}
