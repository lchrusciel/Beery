<?php

declare(strict_types=1);

namespace spec\App\Application\CommandHandler;

use App\Application\Command\AddBeer;
use App\Application\CommandHandler\AddBeerHandler;
use App\Application\Event\BeerAdded;
use App\Application\Repository\Beers;
use App\Domain\Model\Abv;
use App\Domain\Model\Beer;
use PhpSpec\ObjectBehavior;
use Prooph\ServiceBus\EventBus;
use Prophecy\Argument;

final class AddBeerHandlerSpec extends ObjectBehavior
{
    function let(EventBus $eventBus, Beers $beers)
    {
        $this->beConstructedWith($eventBus, $beers);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(AddBeerHandler::class);
    }

    function it_creates_a_beer(EventBus $eventBus, Beers $beers): void
    {
        $beers->add(Argument::exact(Beer::add('King of Hop', new Abv(5))))->shouldBeCalled();

        $eventBus
            ->dispatch(Argument::that(function (BeerAdded $beerAdded) {
                return
                    $beerAdded->name() === 'King of Hop' &&
                    $beerAdded->abv() == new Abv(5)
                ;
            }))
            ->shouldBeCalled()
        ;

        $this(AddBeer::create('King of Hop', new Abv(5)));
    }

    function it_does_not_dispatch_event_if_adding_beer_would_fail(EventBus $eventBus, Beers $beers): void
    {
        $beers->add(Argument::any())->willThrow(\InvalidArgumentException::class);
        $eventBus->dispatch(Argument::any())->shouldNotBeCalled();

        $this
            ->shouldThrow(\InvalidArgumentException::class)
            ->during('__invoke', [AddBeer::create('King of Hop', new Abv(5))])
        ;
    }
}
