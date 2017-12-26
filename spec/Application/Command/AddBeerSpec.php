<?php

declare(strict_types=1);

namespace spec\App\Application\Command;

use App\Domain\Model\Abv;
use App\Domain\Model\Name;
use PhpSpec\ObjectBehavior;
use Prooph\Common\Messaging\Command;

final class AddBeerSpec extends ObjectBehavior
{
    function it_represents_add_beer_intention(): void
    {
        $this->beConstructedThrough('create', [new Name('King of Hop'), new Abv(5)]);

        $this->name()->shouldBeLike(new Name('King of Hop'));
        $this->abv()->shouldBeLike(new Abv(5));
    }

    function it_is_command(): void
    {
        $this->shouldHaveType(Command::class);
    }
}
