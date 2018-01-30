<?php

declare(strict_types=1);

namespace App\Infrastructure\RecommendationEngine\Projection;

use App\Domain\ApplyMethodDispatcherTrait;
use App\Domain\Connoisseur\Event\ConnoisseurRegistered;
use App\Infrastructure\RecommendationEngine\View\ConnoisseurView;
use GraphAware\Neo4j\OGM\EntityManagerInterface;

final class ConnoisseurProjector
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

    public function applyConnoisseurRegistered(ConnoisseurRegistered $connoisseurRegistered): void
    {
        $id = $connoisseurRegistered->id();
        $email = $connoisseurRegistered->email();

        $this->entityManager->persist(
            new ConnoisseurView(
                $id->value(),
                $email->value()
            )
        );

        $this->entityManager->flush();
    }
}
