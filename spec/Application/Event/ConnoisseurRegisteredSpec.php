<?php

declare(strict_types=1);

namespace spec\App\Application\Event;

use App\Domain\Model\Email;
use App\Domain\Model\Name;
use App\Domain\Model\Password;
use PhpSpec\ObjectBehavior;
use Prooph\Common\Messaging\DomainEvent;

final class ConnoisseurRegisteredSpec extends ObjectBehavior
{
    function it_represents_connoisseur_registerded_event_occurrence()
    {
        $this->beConstructedThrough('occur', [
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
        $this->shouldHaveType(DomainEvent::class);
    }
}
