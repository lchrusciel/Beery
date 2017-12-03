<?php

declare(strict_types=1);

namespace spec\App\Domain\Model;

use App\Domain\Exception\InvalidPasswordException;
use PhpSpec\ObjectBehavior;

final class PasswordSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith('parostatkiem1');
    }

    function it_is_a_password()
    {
        $this->value()->shouldReturn('parostatkiem1');
    }

    function it_throws_exception_if_password_is_invalid()
    {
        $this->shouldThrow(InvalidPasswordException::class)->during('__construct', ['parostatkiem']);
        $this->shouldThrow(InvalidPasswordException::class)->during('__construct', ['paros1a']);
    }
}
