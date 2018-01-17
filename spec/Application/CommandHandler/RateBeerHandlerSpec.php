<?php

declare(strict_types=1);

namespace spec\App\Application\CommandHandler;

use App\Application\Command\RateBeer;
use App\Application\CommandHandler\RateBeerHandler;
use App\Application\Event\BeerRated;
use App\Application\Repository\Beers;
use App\Application\Repository\Exception\BeerNotFoundException;
use App\Domain\Beer\Model\Beer;
use App\Domain\Beer\Model\Id;
use App\Domain\Beer\Model\Rate;
use App\Domain\Connoisseur\Model\Email;
use PhpSpec\ObjectBehavior;
use Prooph\ServiceBus\EventBus;
use Prophecy\Argument;

final class RateBeerHandlerSpec extends ObjectBehavior
{
    function let(EventBus $eventBus, Beers $beers)
    {
        $this->beConstructedWith($eventBus, $beers);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(RateBeerHandler::class);
    }

    function it_rates_beer(EventBus $eventBus, Beers $beers, Beer $beer): void
    {
        $beers->get(Argument::exact(new Id('02b9ccbc-e30b-4ec2-8fb9-339609f36c65')))->willReturn($beer);

        $beer->rate(Argument::exact(new Rate(3.5)))->shouldBeCalled();

        $eventBus
            ->dispatch(Argument::that(function (BeerRated $beerRated) {
                return
                    $beerRated->connoisseurEmail() == new Email('rick@morty.com') &&
                    $beerRated->beerId() == new Id('02b9ccbc-e30b-4ec2-8fb9-339609f36c65') &&
                    $beerRated->rate() == new Rate(3.5)
                ;
            }))
            ->shouldBeCalled()
        ;

        $this(RateBeer::create(
            new Email('rick@morty.com'),
            new Id('02b9ccbc-e30b-4ec2-8fb9-339609f36c65'),
            new Rate(3.5)
        ));
    }

    function it_does_not_dispatch_event_if_beer_has_not_been_found(EventBus $eventBus, Beers $beers): void
    {
        $beers->get(Argument::exact(new Id('02b9ccbc-e30b-4ec2-8fb9-339609f36c65')))->willThrow(BeerNotFoundException::class);

        $eventBus->dispatch(Argument::any())->shouldNotBeCalled();

        $this
            ->shouldThrow(BeerNotFoundException::class)
            ->during('__invoke', [RateBeer::create(
                new Email('rick@morty.com'),
                new Id('02b9ccbc-e30b-4ec2-8fb9-339609f36c65'),
                new Rate(3.5)
            )])
        ;
    }

    function it_does_not_dispatch_event_if_rate_could_not_be_added(EventBus $eventBus, Beers $beers, Beer $beer): void
    {
        $beers->get(Argument::exact(new Id('02b9ccbc-e30b-4ec2-8fb9-339609f36c65')))->willReturn($beer);
        $beer->rate(Argument::exact(new Rate(3.5)))->willThrow(\DomainException::class);

        $eventBus->dispatch(Argument::any())->shouldNotBeCalled();

        $this
            ->shouldThrow(\DomainException::class)
            ->during('__invoke', [RateBeer::create(
                new Email('rick@morty.com'),
                new Id('02b9ccbc-e30b-4ec2-8fb9-339609f36c65'),
                new Rate(3.5)
            )])
        ;
    }
}
