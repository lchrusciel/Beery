<?php

declare(strict_types=1);

namespace Tests\Behat\Context\Api;

use Behat\Behat\Context\Context;
use Symfony\Component\HttpFoundation\Response;
use Tests\Service\HttpClient;
use Tests\Service\ResponseAsserter;

final class BeerContext implements Context
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
     * @When I add a new :beerName beer which has :abv% ABV
     */
    public function iAddANewBeerWhichHasAbv(string $beerName, int $abv): void
    {
        $this->client->post('beers', ['beerName' => $beerName, 'abv' => $abv]);
    }

    /**
     * @When I browse the beers catalogue
     */
    public function iBrowseTheBeersCatalogue()
    {
        $this->client->get('beers');
    }

    /**
     * @Then the :beerName beer should be available in the catalogue
     */
    public function theBeerShouldBeAvailableInTheCatalogue(string $beerName): void
    {
        $this->jsonAsserter->assertResponseCode($this->client->response(), Response::HTTP_CREATED);
    }

    /**
     * @Then I should see the :beerName beer
     */
    public function iShouldSeeTheBeer(string $beerName): void
    {
        $this->jsonAsserter->assertResponse(
            $this->client->response(),
            Response::HTTP_OK,
            sprintf('[{"id":@integer@,"name":"%s","abv":5}]', $beerName)
        );
    }
}
