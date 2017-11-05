<?php

declare(strict_types=1);

namespace spec\App\Application\CommandHandler;

use App\Application\Command\AddBeer;
use App\Application\CommandHandler\AddBeerHandler;
use App\Domain\Event\BeerAdded;
use App\Domain\Model\Beer;
use Doctrine\Common\Persistence\ObjectManager;
use PhpSpec\ObjectBehavior;
use Prooph\ServiceBus\EventBus;
use Prophecy\Argument;

final class AddBeerHandlerSpec extends ObjectBehavior
{
    function let(ObjectManager $objectManager, EventBus $eventBus)
    {
        $this->beConstructedWith($objectManager, $eventBus);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(AddBeerHandler::class);
    }

    function it_creates_beer(ObjectManager $objectManager, EventBus $eventBus)
    {
        $objectManager
            ->persist(Argument::that(function (Beer $beer) {
                return $beer == Beer::add('King of Hop', 5);
            }))
            ->shouldBeCalled()
        ;

        $objectManager->flush()->shouldBeCalled();

        $eventBus
            ->dispatch(Argument::that(function (BeerAdded $beerbeerAdded) {
                return $beerbeerAdded == BeerAdded::occur('King of Hop', 5);
            }))
            ->shouldBeCalled()
        ;

        $this(AddBeer::create('King of Hop', 5));
    }
}
