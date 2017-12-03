<?php

declare(strict_types=1);

namespace spec\App\Application\Command;

use App\Domain\Model\Email;
use App\Domain\Model\Name;
use App\Domain\Model\Password;
use PhpSpec\ObjectBehavior;
use Prooph\Common\Messaging\Command;

final class RegisterConnoisseurSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedThrough('create', [
            new Name('Krzysztof Krawczyk'),
            new Email('krawczyk@biale.pl'),
            new Password('parostatkiem1'),
        ]);
    }

    function it_is_command(): void
    {
        $this->shouldHaveType(Command::class);
    }

    function it_has_connoisseur_name(): void
    {
        $this->name()->shouldBeLike(new Name('Krzysztof Krawczyk'));
    }

    function it_has_connoisseur_email(): void
    {
        $this->email()->shouldBeLike(new Email('krawczyk@biale.pl'));
    }

    function it_has_connoisseur_password(): void
    {
        $this->password()->shouldBeLike(new Password('parostatkiem1'));
    }
}
