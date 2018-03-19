<?php

declare(strict_types=1);

namespace App\Infrastructure\RecommendationEngine;

use App\Infrastructure\RecommendationEngine\View\BeerView;
use GraphAware\Neo4j\OGM\EntityManager;

final class Neo4jRecommendationEngine implements RecommendationEngine
{
    /** @var EntityManager */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getRecommendationFor(string $connoisseur): array
    {
        $cql = '
            MATCH (unrated:Beer)<-[r:RATED]-(c:Connoisseur)-[s:SIMILARITY]-(subject:Connoisseur{email: {email}})
            WHERE NOT ((subject)-[:RATED]->(unrated))
            WITH unrated, s.similarity AS similarity, r.rate AS rate
            ORDER BY unrated.name, similarity DESC
            WITH unrated as beer, COLLECT(rate)[0..3] AS rates
            WITH beer, REDUCE(s = 0, i IN rates | s + i) * 1.0 / LENGTH(rates) AS recommendation
            WHERE recommendation >= 3
            RETURN beer
            ORDER BY recommendation DESC
        ';

        $query = $this->entityManager->createQuery($cql);
        $query->addEntityMapping('beer', BeerView::class);
        $query->addEntityMapping('unrated', BeerView::class);
        $query->setParameter('email', $connoisseur);

        return $query->execute();
    }
}
