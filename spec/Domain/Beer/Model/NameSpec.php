<?php

declare(strict_types=1);

namespace spec\App\Domain\Beer\Model;

use App\Domain\Beer\Exception\EmptyNameException;
use PhpSpec\ObjectBehavior;

final class NameSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith('Krzysztof Krawczyk');
    }

    function it_is_a_name(): void
    {
        $this->value()->shouldReturn('Krzysztof Krawczyk');
    }

    function it_cannot_be_empty(): void
    {
        $this->shouldThrow(EmptyNameException::class)->during('__construct', ['']);
    }
}
