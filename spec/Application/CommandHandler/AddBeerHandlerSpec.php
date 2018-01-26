<?php

declare(strict_types=1);

namespace spec\App\Application\CommandHandler;

use App\Application\Command\AddBeer;
use App\Application\CommandHandler\AddBeerHandler;
use App\Application\Repository\Beers;
use App\Domain\Beer\Model\Abv;
use App\Domain\Beer\Model\Beer;
use App\Domain\Beer\Model\Id;
use App\Domain\Beer\Model\Name;
use PhpSpec\ObjectBehavior;
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
        $beers->add(Argument::that(
            function (Beer $beer) {
                return $beer->id() == new Id('e8a68535-3e17-468f-acc3-8a3e0fa04a59');
            })
        )->shouldBeCalled();

        $this(AddBeer::create(
            new Id('e8a68535-3e17-468f-acc3-8a3e0fa04a59'),
            new Name('King of Hop'),
            new Abv(5)
        ));
    }
}
