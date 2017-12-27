<?php

declare(strict_types=1);

namespace spec\App\Domain\Model;

use App\Domain\Model\Abv;
use App\Domain\Model\Beer;
use App\Domain\Model\Id;
use App\Domain\Model\Name;
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
}
