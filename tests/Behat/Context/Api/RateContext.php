<?php

declare(strict_types=1);

namespace Tests\Behat\Context\Api;

use App\Domain\Beer\Model\Beer;
use App\Infrastructure\ReadModel\View\BeerView;
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
    public function iRateTheBeer(Beer $beer, float $rate): void
    {
        $this->client->post('beers/' . $beer->id() . '/rates', ['rate' => $rate]);
    }

    /**
     * @Then the :beerView beer should have average rate :rate
     */
    public function theBeerShouldHaveAverageRate(BeerView $beerView, float $rate): void
    {
        $this->client->get('beers/' . $beerView->getId());

        $this->jsonAsserter->assertResponse(
            $this->client->response(),
            Response::HTTP_OK,
            sprintf(
                '{"id":"@string@","name":"%s","abv":"@string@","amountOfRates":"@integer@","averageRate":"%.2f"}',
                $beerView->getName(),
                $rate
            )
        );
    }
}
