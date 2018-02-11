<?php

declare(strict_types=1);

namespace spec\App\Infrastructure\RecommendationEngine\Projection;

use App\Domain\Beer\Event\BeerAdded;
use App\Domain\Beer\Event\BeerRated;
use App\Domain\Beer\Model\Abv;
use App\Domain\Beer\Model\Connoisseur;
use App\Domain\Beer\Model\Id;
use App\Domain\Beer\Model\Name;
use App\Domain\Beer\Model\Rate;
use App\Infrastructure\RecommendationEngine\Projection\BeerProjection;
use App\Infrastructure\RecommendationEngine\View\BeerRatingView;
use App\Infrastructure\RecommendationEngine\View\BeerView;
use App\Infrastructure\RecommendationEngine\View\ConnoisseurView;
use GraphAware\Neo4j\OGM\EntityManagerInterface;
use GraphAware\Neo4j\OGM\Repository\BaseRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class BeerProjectionSpec extends ObjectBehavior
{
    function let(EntityManagerInterface $entityManager, BaseRepository $beerRepository, BaseRepository $connoisseurRepository)
    {
        $this->beConstructedWith($entityManager);

        $entityManager->getRepository(BeerView::class)->willReturn($beerRepository);
        $entityManager->getRepository(ConnoisseurView::class)->willReturn($connoisseurRepository);
    }

    function it_is_a_beer_projection(): void
    {
        $this->shouldHaveType(BeerProjection::class);
    }

    function it_creates_a_beer_view(EntityManagerInterface $entityManager): void
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

    function it_creates_a_beer_rate_view(
        EntityManagerInterface $entityManager,
        BaseRepository $beerRepository,
        BaseRepository $connoisseurRepository,
        BeerView $beerView,
        ConnoisseurView $connoisseurView
    ): void {
        $beerRepository->findOneBy(['beerIdentifier' => 'e8a68535-3e17-468f-acc3-8a3e0fa04a59'])->willReturn($beerView);
        $connoisseurRepository->findOneBy(['email' => 'rick@morty.com'])->willReturn($connoisseurView);

        $beerView->rate(Argument::exact(new BeerRatingView(
            $connoisseurView->getWrappedObject(),
            $beerView->getWrappedObject(),
            5
        )))->shouldBeCalled();

        $entityManager->flush()->shouldBeCalled();

        $this(BeerRated::withData(
            new Id('e8a68535-3e17-468f-acc3-8a3e0fa04a59'),
            new Connoisseur('rick@morty.com'),
            new Rate(5))
        );
    }
}
