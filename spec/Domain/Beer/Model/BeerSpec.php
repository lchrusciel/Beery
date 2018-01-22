<?php

declare(strict_types=1);

namespace spec\App\Domain\Beer\Model;

use App\Domain\Beer\Event\BeerAdded;
use App\Domain\Beer\Event\BeerRated;
use App\Domain\Beer\Exception\InvalidAbvValueException;
use App\Domain\Beer\Model\Abv;
use App\Domain\Beer\Model\Id;
use App\Domain\Beer\Model\Name;
use App\Domain\Beer\Model\Rate;
use App\Domain\Connoisseur\Model\Email;
use PhpSpec\ObjectBehavior;
use Tests\Service\Prooph\Spec\AggregateAsserter;

final class BeerSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedThrough('add', [
            new Id('e8a68535-3e17-468f-acc3-8a3e0fa04a59'),
            new Name('Oto Mata IPA'),
            new Abv( 5.2),
        ]);

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $this->getWrappedObject(),
            BeerAdded::withData(
                new Id('e8a68535-3e17-468f-acc3-8a3e0fa04a59'),
                new Name('Oto Mata IPA'),
                new Abv( 5.2)
            )
        );
    }

    function it_has_an_id(): void
    {
        $this->id()->shouldBeLike(new Id('e8a68535-3e17-468f-acc3-8a3e0fa04a59'));
    }

    function it_can_be_rated(): void
    {
        $this->rate(new Email('rick@morty.com'), new Rate(4));

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $this->getWrappedObject(),
            BeerRated::withData(
                new Id('e8a68535-3e17-468f-acc3-8a3e0fa04a59'),
                new Email('rick@morty.com'),
                new Rate(4)
            )
        );
    }
}
