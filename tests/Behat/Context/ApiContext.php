<?php

declare(strict_types=1);

namespace Tests\Behat\Context;

use Behat\Behat\Context\Context;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

final class ApiContext implements Context
{
    /** @var Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @When I add a new :beerName beer which has :abv% ABV
     */
    public function iAddANewBeerWhichHasAbv(string $beerName, int $abv): void
    {
        $this->client->request('POST', 'beers', ['beerName' => $beerName, 'abv' => $abv]);
    }

    /**
     * @Then the :beerName beer should be available in the catalogue
     */
    public function theBeerShouldBeAvailableInTheCatalogue(string $beerName): void
    {
        /** @var Response $response */
        $response = $this->client->getResponse();

        Assert::same(Response::HTTP_CREATED, $response->getStatusCode());
    }
}
