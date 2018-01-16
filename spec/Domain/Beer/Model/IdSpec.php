<?php

declare(strict_types=1);

namespace spec\App\Domain\Beer\Model;

use App\Domain\Beer\Exception\InvalidUuidFormatException;
use PhpSpec\ObjectBehavior;

final class IdSpec extends ObjectBehavior
{
    function it_can_be_created_from_string(): void
    {
        $this->beConstructedWith('e8a68535-3e17-468f-acc3-8a3e0fa04a59');

        $this->value()->shouldReturn('e8a68535-3e17-468f-acc3-8a3e0fa04a59');
    }

    function it_has_to_be_valid(): void
    {
        $this->shouldThrow(InvalidUuidFormatException::class)->during('__construct', ['e8a68535-3e17-468f-acc3-8a3e0fa04a5']);
    }
}
