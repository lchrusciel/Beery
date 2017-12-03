<?php

declare(strict_types=1);

namespace spec\App\Application\Command;

use App\Domain\Model\Abv;
use PhpSpec\ObjectBehavior;
use Prooph\Common\Messaging\Command;

final class AddBeerSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedThrough('create', ['King of Hop', new Abv(5)]);
    }

    function it_is_command(): void
    {
        $this->shouldHaveType(Command::class);
    }

    function it_returns_name(): void
    {
        $this->name()->shouldReturn('King of Hop');
    }

    function it_returns_abv(): void
    {
        $this->abv()->shouldBeLike(new Abv(5));
    }
}
