<?php

declare(strict_types=1);

namespace Tests\Behat\Context\Hook;

use Behat\Behat\Context\Context;
use GraphAware\Neo4j\Client\Client;
use GraphAware\Neo4j\OGM\EntityManagerInterface;

final class GraphContext implements Context
{
    /** @var Client */
    private $client;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->client = $entityManager->getDatabaseDriver();
    }

    /** @BeforeScenario */
    public function purgeDatabase(): void
    {
        $this->client->run('MATCH (n) DETACH DELETE n');
    }
}
