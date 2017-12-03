<?php

declare(strict_types=1);

namespace spec\App\Domain\Model;

use App\Domain\Exception\InvalidAbvValueException;
use PhpSpec\ObjectBehavior;

final class AbvSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith(4.56);
    }

    function it_is_an_abv()
    {
        $this->value()->shouldReturn(4.56);
    }

    function it_throws_exception_if_abv_is_invalid()
    {
        $this->shouldThrow(InvalidAbvValueException::class)->during('__construct', [-0.14]);
        $this->shouldThrow(InvalidAbvValueException::class)->during('__construct', [101]);
    }
}
