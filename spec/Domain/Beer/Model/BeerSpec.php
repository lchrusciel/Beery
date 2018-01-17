<?php

declare(strict_types=1);

namespace spec\App\Domain\Beer\Model;

use App\Domain\Beer\Model\Abv;
use App\Domain\Beer\Model\Beer;
use App\Domain\Beer\Model\Id;
use App\Domain\Beer\Model\Name;
use App\Domain\Beer\Model\Rate;
use PhpSpec\ObjectBehavior;

final class BeerSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('add', [new Id('e8a68535-3e17-468f-acc3-8a3e0fa04a59'), new Name('King of Hop'), new Abv(5)]);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(Beer::class);
    }

    function it_has_id()
    {
        $this->id()->shouldBeLike(new Id('e8a68535-3e17-468f-acc3-8a3e0fa04a59'));
    }

    function it_can_be_rated()
    {
        $this->rate(new Rate(3.5));
    }
}
