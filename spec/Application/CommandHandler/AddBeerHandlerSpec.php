<?php

declare(strict_types=1);

namespace spec\App\Application\CommandHandler;

use App\Application\Command\AddBeer;
use App\Application\CommandHandler\AddBeerHandler;
use App\Domain\Model\Beer;
use Doctrine\Common\Persistence\ObjectManager;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class AddBeerHandlerSpec extends ObjectBehavior
{
    function let(ObjectManager $objectManager)
    {
        $this->beConstructedWith($objectManager);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(AddBeerHandler::class);
    }

    function it_creates_beer(ObjectManager $objectManager)
    {
        $objectManager
            ->persist(Argument::that(function (Beer $beer) {
                return $beer == Beer::add('King of Hop', 5);
            }))
            ->shouldBeCalled()
        ;

        $objectManager->flush()->shouldBeCalled();

        $this(AddBeer::create('King of Hop', 5));
    }
}
