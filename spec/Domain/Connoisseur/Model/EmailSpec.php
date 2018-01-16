<?php

declare(strict_types=1);

namespace spec\App\Domain\Connoisseur\Model;

use App\Domain\Connoisseur\Exception\InvalidEmailException;
use PhpSpec\ObjectBehavior;

final class EmailSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith('krzysztof@biale.pl');
    }

    function it_is_an_email()
    {
        $this->value()->shouldReturn('krzysztof@biale.pl');
    }

    function it_throws_exception_if_email_is_invalid()
    {
        $this->shouldThrow(InvalidEmailException::class)->during('__construct', ['wrongemail']);
        $this->shouldThrow(InvalidEmailException::class)->during('__construct', ['wrongemail@example.com.pl@eu']);
        $this->shouldThrow(InvalidEmailException::class)->during('__construct', ['wrongemail@@']);
        $this->shouldThrow(InvalidEmailException::class)->during('__construct', ['@.$']);
    }
}
