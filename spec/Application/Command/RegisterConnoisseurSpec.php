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
    function it_represents_register_connoisseur_intention(): void
    {
        $this->beConstructedThrough('create', [
            new Name('Krzysztof Krawczyk'),
            new Email('krawczyk@biale.pl'),
            new Password('$2a$04$N2x1MTIgy8fth66TdWZ1NeHIjJIrK7Ns09I9xk1PDRn8IqkQSckua'),
        ]);

        $this->name()->shouldBeLike(new Name('Krzysztof Krawczyk'));
        $this->email()->shouldBeLike(new Email('krawczyk@biale.pl'));
        $this->password()->shouldBeLike(new Password('$2a$04$N2x1MTIgy8fth66TdWZ1NeHIjJIrK7Ns09I9xk1PDRn8IqkQSckua'));
    }

    function it_is_command(): void
    {
        $this->shouldHaveType(Command::class);
    }
}
