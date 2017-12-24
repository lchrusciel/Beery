<?php

declare(strict_types=1);

namespace Tests\Behat\Context\Api;

use Behat\Behat\Context\Context;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\HttpFoundation\Response;
use Tests\Service\Asserter\JsonAsserterInterface;

final class ConnoisseurContext implements Context
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
     * @When I register the :name connoisseur with the :email email and the :password password
     */
    public function iRegisterTheConnoisseurWithTheEmailAndTheEmail(string $name, string $email, string $password): void
    {
        $this->client->request('POST', 'connoisseurs', ['name' => $name, 'email' => $email, 'password' => $password]);
    }

    /**
     * @Then I should be able to log in as :name with :password password
     */
    public function theConnoisseurShouldBeCreated(string $name, string $password): void
    {
        /** @var Response $response */
        $response = $this->client->getResponse();

        $this->jsonAsserter->assertResponseCode($response, Response::HTTP_CREATED);
    }
}
