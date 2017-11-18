<?php

declare(strict_types=1);

namespace spec\App\Application\Command;

use PhpSpec\ObjectBehavior;
use Prooph\Common\Messaging\Command;

final class AddBeerSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedThrough('create', ['King of Hop', 5]);
    }

    function it_is_command(): void
    {
        $this->shouldHaveType(Command::class);
    }

    function it_returns_beer_name(): void
    {
        $this->beerName()->shouldReturn('King of Hop');
    }

    function it_returns_abv(): void
    {
        $this->abv()->shouldReturn(5);
    }
}
