<?php

declare(strict_types=1);

namespace spec\App\Domain\Beer\Model;

use App\Domain\Beer\Exception\InvalidRateValueException;
use PhpSpec\ObjectBehavior;

final class RateSpec extends ObjectBehavior
{
    function it_is_a_rate()
    {
        $this->beConstructedWith(4.56);

        $this->value()->shouldReturn(4.56);
    }

    function it_has_minimal_value_1()
    {
        $this->beConstructedWith(1);

        $this->value()->shouldReturn(1.0);
    }

    function it_has_maximal_value_5()
    {
        $this->beConstructedWith(5);

        $this->value()->shouldReturn(5.0);
    }

    function it_throws_exception_if_rate_is_invalid()
    {
        $this->shouldThrow(InvalidRateValueException::class)->during('__construct', [-0.1]);
        $this->shouldThrow(InvalidRateValueException::class)->during('__construct', [6]);
        $this->shouldThrow(InvalidRateValueException::class)->during('__construct', [5.1]);
        $this->shouldThrow(InvalidRateValueException::class)->during('__construct', [0]);
        $this->shouldThrow(InvalidRateValueException::class)->during('__construct', [0.9]);
    }
}
