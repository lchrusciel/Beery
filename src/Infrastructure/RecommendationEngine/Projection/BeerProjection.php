<?php

declare(strict_types=1);

namespace App\Infrastructure\RecommendationEngine\Projection;

use App\Domain\ApplyMethodDispatcherTrait;
use App\Domain\Beer\Event\BeerAdded;
use App\Infrastructure\RecommendationEngine\View\BeerView;
use GraphAware\Neo4j\OGM\EntityManagerInterface;

final class BeerProjection
{
    use ApplyMethodDispatcherTrait {
        applyMessage as public __invoke;
    }

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function applyBeerAdded(BeerAdded $beerAdded): void
    {
        $id = $beerAdded->id();
        $name = $beerAdded->name();

        $this->entityManager->persist(new BeerView($id->value(), $name->value()));
        $this->entityManager->flush();
    }
}
