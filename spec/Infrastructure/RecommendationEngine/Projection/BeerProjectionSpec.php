<?php

declare(strict_types=1);

namespace spec\App\Infrastructure\RecommendationEngine\Projection;

use App\Domain\Beer\Event\BeerAdded;
use App\Domain\Beer\Model\Abv;
use App\Domain\Beer\Model\Id;
use App\Domain\Beer\Model\Name;
use App\Infrastructure\RecommendationEngine\Projection\BeerProjection;
use App\Infrastructure\RecommendationEngine\View\BeerView;
use GraphAware\Neo4j\OGM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class BeerProjectionSpec extends ObjectBehavior
{
    function let(EntityManagerInterface $entityManager)
    {
        $this->beConstructedWith($entityManager);
    }

    function it_is_a_beer_projection(): void
    {
        $this->shouldHaveType(BeerProjection::class);
    }

    function it_creates_a_beer_view(EntityManagerInterface $entityManager)
    {
        $entityManager->persist(Argument::exact(new BeerView(
            'e8a68535-3e17-468f-acc3-8a3e0fa04a59',
            'King of Hop'
        )))->shouldBeCalled();

        $entityManager->flush()->shouldBeCalled();

        $this(BeerAdded::withData(
            new Id('e8a68535-3e17-468f-acc3-8a3e0fa04a59'),
            new Name('King of Hop'),
            new Abv(5))
        );
    }
}
