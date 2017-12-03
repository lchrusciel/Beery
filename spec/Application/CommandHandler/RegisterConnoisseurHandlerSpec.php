<?php

declare(strict_types=1);

namespace spec\App\Application\CommandHandler;

use App\Application\Command\RegisterConnoisseur;
use App\Application\CommandHandler\RegisterConnoisseurHandler;
use App\Application\Event\ConnoisseurRegistered;
use App\Application\Repository\Connoisseurs;
use App\Domain\Model\Connoisseur;
use App\Domain\Model\Email;
use App\Domain\Model\Name;
use App\Domain\Model\Password;
use PhpSpec\ObjectBehavior;
use Prooph\ServiceBus\EventBus;
use Prophecy\Argument;

final class RegisterConnoisseurHandlerSpec extends ObjectBehavior
{
    function let(EventBus $eventBus, Connoisseurs $connoisseurs)
    {
        $this->beConstructedWith($eventBus, $connoisseurs);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(RegisterConnoisseurHandler::class);
    }

    function it_creates_a_connoisseur(EventBus $eventBus, Connoisseurs $connoisseurs): void
    {
        $connoisseurs
            ->add(Argument::exact(Connoisseur::register(
                new Name('Krzysztof Krawczyk'),
                new Email('krawczyk@biale.pl'),
                new Password('$2a$04$N2x1MTIgy8fth66TdWZ1NeHIjJIrK7Ns09I9xk1PDRn8IqkQSckua'))
            ))->shouldBeCalled()
        ;

        $eventBus
            ->dispatch(Argument::that(function (ConnoisseurRegistered $connoisseurRegistered) {
                return
                    $connoisseurRegistered->name() == new Name('Krzysztof Krawczyk') &&
                    $connoisseurRegistered->email() == new Email('krawczyk@biale.pl') &&
                    $connoisseurRegistered->password() == new Password('$2a$04$N2x1MTIgy8fth66TdWZ1NeHIjJIrK7Ns09I9xk1PDRn8IqkQSckua')
                ;
            }))
            ->shouldBeCalled()
        ;

        $this(RegisterConnoisseur::create(
            new Name('Krzysztof Krawczyk'),
            new Email('krawczyk@biale.pl'),
            new Password('$2a$04$N2x1MTIgy8fth66TdWZ1NeHIjJIrK7Ns09I9xk1PDRn8IqkQSckua')
        ));
    }

    function it_does_not_dispatch_event_if_registering_connoisseur_would_fail(
        EventBus $eventBus,
        Connoisseurs $connoisseurs
    ): void {
        $connoisseurs->add(Argument::any())->willThrow(\InvalidArgumentException::class);

        $eventBus->dispatch(Argument::any())->shouldNotBeCalled();

        $this
            ->shouldThrow(\InvalidArgumentException::class)
            ->during('__invoke', [RegisterConnoisseur::create(
                new Name('Krzysztof Krawczyk'),
                new Email('krawczyk@biale.pl'),
                new Password('$2a$04$N2x1MTIgy8fth66TdWZ1NeHIjJIrK7Ns09I9xk1PDRn8IqkQSckua')
            )])
        ;
    }
}
