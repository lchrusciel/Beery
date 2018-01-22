<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\EventSubscriber;

use App\Domain\RecordsEvents;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Prooph\EventSourcing\Aggregate\AggregateRepository;
use Prooph\EventSourcing\Aggregate\AggregateType;
use Prooph\EventSourcing\EventStoreIntegration\ClosureAggregateTranslator;
use Prooph\EventStore\EventStore;

final class DomainEventDispatcher implements EventSubscriber
{
    /** @var EventStore */
    private $eventStore;

    public function getSubscribedEvents(): array
    {
        return ['postPersist', 'postUpdate'];
    }

    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $this->dispachDomainEvents($args);
    }

    public function postUpdate(LifecycleEventArgs $args): void
    {
        $this->dispachDomainEvents($args);
    }

    private function dispachDomainEvents(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();

        if ($entity instanceof RecordsEvents) {
            $proophRepository = new AggregateRepository(
                $this->eventStore,
                AggregateType::fromAggregateRootClass(get_class($entity)),
                new ClosureAggregateTranslator()
            );

            $proophRepository->saveAggregateRoot($entity);
        }
    }
}
