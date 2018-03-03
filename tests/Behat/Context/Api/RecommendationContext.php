<?php

declare(strict_types=1);

namespace Tests\Behat\Context\Api;

use Behat\Behat\Context\Context;
use Symfony\Component\HttpFoundation\Response;
use Tests\Service\HttpClient;
use Tests\Service\ResponseAsserter;

final class RecommendationContext implements Context
{
    /** @var HttpClient */
    private $client;

    /** @var ResponseAsserter */
    private $jsonAsserter;

    public function __construct(HttpClient $client, ResponseAsserter $jsonAsserter)
    {
        $this->client = $client;
        $this->jsonAsserter = $jsonAsserter;
    }

    /**
     * @When I ask for a beer recommendation
     * @When I try to ask for a beer recommendation
     */
    public function iAskForABeerRecommendation(): void
    {
        $this->client->get('/me/recommendations/');
    }

    /**
     * @Then I should be notified that I'm not allowed to do it
     */
    public function iShouldBeNotifiedThatImNotAllowedToDoIt(): void
    {
        $this->jsonAsserter->assertResponseCode(
            $this->client->response(),
            Response::HTTP_UNAUTHORIZED
        );
    }

    /**
     * @Then the :beerName beer should be suggested
     */
    public function theBeerShouldBeSuggested(string $beerName): void
    {
        $this->jsonAsserter->assertResponseContent(
            $this->client->response(),
            sprintf(
                '[{"id":"@string@","name":"%s","abv":"@string@","amountOfRates":@integer@,"averageRate":"@string@"}]',
                $beerName
            )
        );
    }
}
