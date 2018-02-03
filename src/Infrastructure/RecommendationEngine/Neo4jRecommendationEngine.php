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
            MATCH (:Connoisseur{email: {email}})-[r1:RATED]->(rated:Beer)<-[r2:RATED]-()-[r3:RATED]->(unrated:Beer)
            WHERE r1.rate >= 4
            AND r2.rate >= 4
            AND r3.rate >= 4
            AND NOT ((:Connoisseur{email: {email}})-[:RATED]->(unrated))
            RETURN unrated
        ';

        $query = $this->entityManager->createQuery($cql);
        $query->addEntityMapping('rated', BeerView::class);
        $query->addEntityMapping('unrated', BeerView::class);
        $query->setParameter('email', $connoisseur);

        return $query->execute();
    }
}
