<?php

declare(strict_types=1);

namespace Tests\Behat\Context\Api;

use App\Domain\Model\Beer;
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
     * @When I try to add a new :beerName beer which has :abv% ABV
     */
    public function iTryToAddANewBeerWhichHasAbv(string $beerName, int $abv): void
    {
        try {
            $this->client->post('beers', ['beerName' => $beerName, 'abv' => $abv]);
        } catch (\InvalidArgumentException $exception) {
        }
    }

    /**
     * @When I browse the beers catalogue
     */
    public function iBrowseTheBeersCatalogue(): void
    {
        $this->client->get('beers');
    }

    /**
     * @When I check the :beer details
     */
    public function iCheckTheDetails(Beer $beer): void
    {
        $this->client->get('beers/' . $beer->id());
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
            sprintf('[{"id":@string@,"name":"%s","abv":"@string@","amountOfRates":0,"averageRate":"0.00"}]', $beerName)
        );
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
     * @Then I should see that the :beerName beer has :abv% ABV, :amountOfRates rates and its average rate is :rate
     */
    public function iShouldSeeThatTheBeerHasAbvRatesAndItsAvarageRateIs(
        string $beerName,
        int $abv,
        int $amountOfRates,
        float $rate
    ): void {
        $this->jsonAsserter->assertResponse(
            $this->client->response(),
            Response::HTTP_OK,
            sprintf(
                '{"id":"@string@","name":"%s","abv":"%.2f","amountOfRates":%d,"averageRate":"%.2f"}',
                $beerName,
                $abv,
                $amountOfRates,
                $rate
            )
        );
    }
}
