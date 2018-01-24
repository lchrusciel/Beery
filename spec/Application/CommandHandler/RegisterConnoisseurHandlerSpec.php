<?php

declare(strict_types=1);

namespace spec\App\Application\CommandHandler;

use App\Application\Command\RegisterConnoisseur;
use App\Application\CommandHandler\RegisterConnoisseurHandler;
use App\Application\Repository\Connoisseurs;
use App\Domain\Connoisseur\Model\Connoisseur;
use App\Domain\Connoisseur\Model\Email;
use App\Domain\Connoisseur\Model\Id;
use App\Domain\Connoisseur\Model\Name;
use App\Domain\Connoisseur\Model\Password;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class RegisterConnoisseurHandlerSpec extends ObjectBehavior
{
    function let(Connoisseurs $connoisseurs)
    {
        $this->beConstructedWith($connoisseurs);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(RegisterConnoisseurHandler::class);
    }

    function it_creates_a_connoisseur(Connoisseurs $connoisseurs): void
    {
        $connoisseurs->add(Argument::type(Connoisseur::class))->shouldBeCalled();

        $this(RegisterConnoisseur::create(
            new Id('e8a68535-3e17-468f-acc3-8a3e0fa04a59'),
            new Name('Krzysztof Krawczyk'),
            new Email('krawczyk@biale.pl'),
            new Password('$2a$04$N2x1MTIgy8fth66TdWZ1NeHIjJIrK7Ns09I9xk1PDRn8IqkQSckua')
        ));
    }
}
