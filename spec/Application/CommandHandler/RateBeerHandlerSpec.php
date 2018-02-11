<?php

declare(strict_types=1);

namespace spec\App\Application\CommandHandler;

use App\Application\Command\RateBeer;
use App\Application\CommandHandler\RateBeerHandler;
use App\Application\Repository\Beers;
use App\Domain\Beer\Model\Beer;
use App\Domain\Beer\Model\Connoisseur;
use App\Domain\Beer\Model\Id;
use App\Domain\Beer\Model\Rate;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class RateBeerHandlerSpec extends ObjectBehavior
{
    function let(Beers $beers)
    {
        $this->beConstructedWith($beers);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(RateBeerHandler::class);
    }

    function it_rates_beer(Beers $beers, Beer $beer): void
    {
        $beers->get(Argument::exact(new Id('02b9ccbc-e30b-4ec2-8fb9-339609f36c65')))->willReturn($beer);

        $beer->rate(Argument::exact(new Connoisseur('rick@morty.com')), Argument::exact(new Rate(3.5)))->shouldBeCalled();

        $this(RateBeer::create(
            new Connoisseur('rick@morty.com'),
            new Id('02b9ccbc-e30b-4ec2-8fb9-339609f36c65'),
            new Rate(3.5)
        ));
    }
}
