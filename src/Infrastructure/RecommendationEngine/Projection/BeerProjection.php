<?php

declare(strict_types=1);

namespace App\Infrastructure\RecommendationEngine\Projection;

use App\Domain\ApplyMethodDispatcherTrait;
use App\Domain\Beer\Event\BeerAdded;
use App\Domain\Beer\Event\BeerRated;
use App\Infrastructure\RecommendationEngine\View\BeerRatingView;
use App\Infrastructure\RecommendationEngine\View\BeerView;
use App\Infrastructure\RecommendationEngine\View\ConnoisseurView;
use GraphAware\Neo4j\OGM\EntityManagerInterface;
use GraphAware\Neo4j\OGM\Repository\BaseRepository;

final class BeerProjection
{
    use ApplyMethodDispatcherTrait {
        applyMessage as public __invoke;
    }

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var BaseRepository */
    private $beerRepository;

    /** @var BaseRepository */
    private $connoisseurRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->beerRepository = $entityManager->getRepository(BeerView::class);
        $this->connoisseurRepository = $entityManager->getRepository(ConnoisseurView::class);
    }

    public function applyBeerAdded(BeerAdded $beerAdded): void
    {
        $id = $beerAdded->id();
        $name = $beerAdded->name();

        $this->entityManager->persist(new BeerView($id->value(), $name->value()));
        $this->entityManager->flush();
    }

    public function applyBeerRated(BeerRated $beerRated): void
    {
        $beerView = $this->beerRepository->findOneBy(['uuid' => $beerRated->beerId()->value()]);
        $connoisseurView = $this->connoisseurRepository->findOneBy(['email' => $beerRated->connoisseurEmail()->value()]);

        $rate = $beerRated->rate();

        $beerView->rate(new BeerRatingView($connoisseurView, $beerView, $rate->value()));

        $this->entityManager->flush();
    }
}
