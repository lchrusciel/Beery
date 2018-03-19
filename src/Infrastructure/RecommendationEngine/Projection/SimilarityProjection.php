<?php

declare(strict_types=1);

namespace App\Infrastructure\RecommendationEngine\Projection;

use App\Domain\ApplyMethodDispatcherTrait;
use App\Domain\Beer\Event\BeerRated;
use GraphAware\Neo4j\OGM\EntityManager;

final class SimilarityProjection
{
    use ApplyMethodDispatcherTrait {
        applyMessage as public __invoke;
    }

    /** @var EntityManager */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function applyBeerRated(BeerRated $beerRated): void
    {
        $cql = '
            MATCH (c1:Connoisseur)-[x:RATED]->(b:Beer)<-[y:RATED]-(c2:Connoisseur)
            WITH SUM(x.rate * y.rate) AS xyDotProduct,
            SQRT(REDUCE(xDot = 0.0, a IN COLLECT(x.rate) | xDot + a^2)) as xLength,
            SQRT(REDUCE(yDot = 0.0, b IN COLLECT(y.rate) | yDot + b^2)) as yLength,
            c1, c2
            MERGE (c1)-[s:SIMILARITY]-(c2)
            SET s.similarity = xyDotProduct / (xLength * yLength)
        ';

        $query = $this->entityManager->createQuery($cql);

        $query->execute();
    }
}
