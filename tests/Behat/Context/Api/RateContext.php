<?php

declare(strict_types=1);

namespace Tests\Behat\Context\Api;

use App\Domain\Model\Beer;
use Behat\Behat\Context\Context;
use Symfony\Component\HttpFoundation\Response;
use Tests\Service\HttpClient;
use Tests\Service\ResponseAsserter;

final class RateContext implements Context
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
     * @When I rate the :beer beer :rate
     */
    public function iRateTheBeer(Beer $beer, float $rate)
    {
        $this->client->post('beers/' . $beer->id() . '/rates', ['rate' => $rate]);
    }

    /**
     * @Then the :beer beer should have average rate :rate
     */
    public function theBeerShouldHaveAverageRate(Beer $beer, float $expectedRate)
    {
        $this->jsonAsserter->assertResponseCode($this->client->response(), Response::HTTP_CREATED);
    }
}
