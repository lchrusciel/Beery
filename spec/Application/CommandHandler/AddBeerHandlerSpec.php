<?php

declare(strict_types=1);

namespace spec\App\Application\CommandHandler;

use App\Application\Command\AddBeer;
use App\Application\CommandHandler\AddBeerHandler;
use App\Application\Event\BeerAdded;
use App\Application\Repository\Beers;
use App\Domain\Beer\Model\Abv;
use App\Domain\Beer\Model\Beer;
use App\Domain\Beer\Model\Id;
use App\Domain\Beer\Model\Name;
use PhpSpec\ObjectBehavior;
use Prooph\ServiceBus\EventBus;
use Prophecy\Argument;

final class AddBeerHandlerSpec extends ObjectBehavior
{
    function let(Beers $beers)
    {
        $this->beConstructedWith($beers);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(AddBeerHandler::class);
    }

    function it_creates_a_beer(Beers $beers): void
    {
        $beers->add(Argument::type(Beer::class))->shouldBeCalled();

        $this(AddBeer::create(
            new Id('e8a68535-3e17-468f-acc3-8a3e0fa04a59'),
            new Name('King of Hop'),
            new Abv(5)
        ));
    }

    function it_does_not_dispatch_event_if_adding_beer_would_fail(EventBus $eventBus, Beers $beers): void
    {
        $beers->add(Argument::any())->willThrow(\InvalidArgumentException::class);

        $this
            ->shouldThrow(\InvalidArgumentException::class)
            ->during('__invoke', [AddBeer::create(
                new Id('e8a68535-3e17-468f-acc3-8a3e0fa04a59'),
                new Name('King of Hop'),
                new Abv(5)
            )])
        ;
    }
}
