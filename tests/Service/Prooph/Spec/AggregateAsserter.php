<?php

declare(strict_types=1);

namespace Tests\Service\Prooph\Spec;

use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\EventStoreIntegration\ClosureAggregateTranslator;

final class AggregateAsserter
{
    /** @var ClosureAggregateTranslator */
    private $closureAggregateTranslator;

    /** @var MessageMatcher */
    private $messageMatcher;

    public function __construct()
    {
        $this->closureAggregateTranslator = new ClosureAggregateTranslator();
        $this->messageMatcher = new MessageMatcher();
    }

    public function assertAggregateHasProducedEvent($aggregateRoot, AggregateChanged $event): void
    {
        $producedEvents = $this->closureAggregateTranslator->extractPendingStreamEvents($aggregateRoot);

        assert(
            $this->messageMatcher->isOneOf($event, $producedEvents),
            'Expected one of the aggregate events to match the provided event.'
        );
    }
}
