<?php

declare(strict_types=1);

namespace spec\App\Domain\Model;

use App\Domain\Model\Abv;
use App\Domain\Model\Beer;
use PhpSpec\ObjectBehavior;

final class BeerSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('add', ['King of Hop', new Abv(5)]);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(Beer::class);
    }
}
