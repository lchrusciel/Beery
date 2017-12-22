<?php

declare(strict_types=1);

namespace spec\App\Infrastructure\Projection;

use App\Application\Event\ConnoisseurRegistered;
use App\Domain\Model\Email;
use App\Domain\Model\Name;
use App\Domain\Model\Password;
use App\Infrastructure\Projection\ConnoisseurRegisteredProjector;
use App\Infrastructure\Repository\ConnoisseurViews;
use App\Infrastructure\View\ConnoisseurView;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class ConnoisseurRegisteredProjectorSpec extends ObjectBehavior
{
    function let(ConnoisseurViews $connoisseurViews)
    {
        $this->beConstructedWith($connoisseurViews);
    }

    function it_is_a_connoisseur_projection(): void
    {
        $this->shouldHaveType(ConnoisseurRegisteredProjector::class);
    }

    function it_creates_a_beer_view(ConnoisseurViews $connoisseurViews)
    {
        $connoisseurViews
            ->add(Argument::exact(new ConnoisseurView(
                'Krzysztof Krawczyk',
                'krawczyk@biale.pl',
                '$2a$04$N2x1MTIgy8fth66TdWZ1NeHIjJIrK7Ns09I9xk1PDRn8IqkQSckua'
            )))
            ->shouldBeCalled()
        ;

        $this(ConnoisseurRegistered::occur(
            new Name('Krzysztof Krawczyk'),
            new Email('krawczyk@biale.pl'),
            new Password('$2a$04$N2x1MTIgy8fth66TdWZ1NeHIjJIrK7Ns09I9xk1PDRn8IqkQSckua')
        ));
    }
}
