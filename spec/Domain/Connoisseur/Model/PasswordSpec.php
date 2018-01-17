<?php

declare(strict_types=1);

namespace spec\App\Domain\Connoisseur\Model;

use App\Domain\Connoisseur\Exception\InvalidPasswordException;
use PhpSpec\ObjectBehavior;

final class PasswordSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith('$2a$04$N2x1MTIgy8fth66TdWZ1NeHIjJIrK7Ns09I9xk1PDRn8IqkQSckua');
    }

    function it_is_a_password()
    {
        $this->value()->shouldReturn('$2a$04$N2x1MTIgy8fth66TdWZ1NeHIjJIrK7Ns09I9xk1PDRn8IqkQSckua');
    }

    function it_throws_exception_if_password_is_invalid()
    {
        $this->shouldThrow(InvalidPasswordException::class)->during('__construct', ['parostatkiem']);
        $this->shouldThrow(InvalidPasswordException::class)->during('__construct', ['paros1a']);
        $this->shouldThrow(InvalidPasswordException::class)->during('__construct', ['$2c$04$N2x1MTIgy8fth66TdWZ1NeHIjJIrK7Ns09I9xk1PDRn8IqkQSckua']);
        $this->shouldThrow(InvalidPasswordException::class)->during('__construct', ['$2a04$N2x1MTIgy8fth66TdWZ1NeHIjJIrK7Ns09I9xk1PDRn8IqkQSckua']);
        $this->shouldThrow(InvalidPasswordException::class)->during('__construct', ['$2a$04$N2x1MTIgy8fth66TdWZ1NeHIjJIrK7Ns09I9xk1PDRn8IqkQScku']);
    }
}
