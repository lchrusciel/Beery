<?php

declare(strict_types=1);

namespace spec\App\Application\Event;

use App\Domain\Model\Abv;
use App\Domain\Model\Name;
use PhpSpec\ObjectBehavior;
use Prooph\Common\Messaging\DomainEvent;

final class BeerAddedSpec extends ObjectBehavior
{
    function it_represents_beer_added_event_occurrence()
    {
        $this->beConstructedThrough('occur', [
            new Name('King of Hop'),
            new Abv(5),
        ]);

        $this->name()->shouldBeLike(new Name('King of Hop'));
        $this->abv()->shouldBeLike(new Abv(5));
    }

    function it_is_a_domain_event(): void
    {
        $this->shouldHaveType(DomainEvent::class);
    }
}
