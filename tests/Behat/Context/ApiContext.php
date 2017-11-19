<?php

declare(strict_types=1);

namespace Tests\Behat\Context;

use Behat\Behat\Context\Context;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\HttpFoundation\Response;
use Tests\Behat\Service\JsonAsserterInterface;

final class ApiContext implements Context
{
    /** @var Client */
    private $client;

    /** @var JsonAsserterInterface */
    private $jsonAsserter;

    public function __construct(Client $client, JsonAsserterInterface $jsonAsserter)
    {
        $this->client = $client;
        $this->jsonAsserter = $jsonAsserter;
    }

    /**
     * @When I add a new :beerName beer which has :abv% ABV
     */
    public function iAddANewBeerWhichHasAbv(string $beerName, int $abv): void
    {
        $this->client->request('POST', 'beers', ['beerName' => $beerName, 'abv' => $abv]);
    }

    /**
     * @When I browse the beers catalogue
     */
    public function iBrowseTheBeersCatalogue()
    {
        $this->client->request('GET', 'beers');
    }

    /**
     * @Then the :beerName beer should be available in the catalogue
     */
    public function theBeerShouldBeAvailableInTheCatalogue(string $beerName): void
    {
        /** @var Response $response */
        $response = $this->client->getResponse();

        $this->jsonAsserter->assertResponseCode($response, Response::HTTP_CREATED);
    }

    /**
     * @Then I should see the :beerName beer
     */
    public function iShouldSeeTheBeer(string $beerName): void
    {
        /** @var Response $response */
        $response = $this->client->getResponse();

        $this->jsonAsserter->assertResponse(
            $response,
            Response::HTTP_OK,
            sprintf('[{"id":@integer@,"name":"%s","abv":5}]', $beerName)
        );
    }
}
