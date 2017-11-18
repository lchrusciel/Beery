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

    function it_creates_a_beer(ObjectManager $objectManager, EventBus $eventBus): void
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
                return $beerbeerAdded->payload() == [
                    'name' => 'King of Hop',
                    'abv' => 5,
                ];
            }))
            ->shouldBeCalled()
        ;

        $this(AddBeer::create('King of Hop', 5));
    }

    function it_does_not_dispatch_event_if_flush_end_up_with_an_excpetion(
        ObjectManager $objectManager,
        EventBus $eventBus
    ): void {
        $objectManager->persist(Argument::any())->shouldBeCalled();
        $objectManager->flush()->willThrow(\InvalidArgumentException::class);

        $eventBus->dispatch(Argument::any())->shouldNotBeCalled();

        $this
            ->shouldThrow(\InvalidArgumentException::class)
            ->during('__invoke', [AddBeer::create('King of Hop', 5)])
        ;
    }

    function it_does_not_dispatch_event_if_persist_end_up_with_an_excpetion(
        ObjectManager $objectManager,
        EventBus $eventBus
    ): void {
        $objectManager->persist(Argument::any())->willThrow(\InvalidArgumentException::class);

        $eventBus->dispatch(Argument::any())->shouldNotBeCalled();

        $this
            ->shouldThrow(\InvalidArgumentException::class)
            ->during('__invoke', [AddBeer::create('King of Hop', 5)])
        ;
    }
}
