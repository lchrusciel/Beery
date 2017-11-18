<?php

declare(strict_types=1);

namespace spec\App\Application\Event;

use PhpSpec\ObjectBehavior;
use Prooph\Common\Messaging\DomainEvent;

final class BeerAddedSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('occur', [
            'King of Hop',
            5,
        ]);
    }

    function it_is_a_domain_event(): void
    {
        $this->shouldHaveType(DomainEvent::class);
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
