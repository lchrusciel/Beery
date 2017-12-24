<?php

declare(strict_types=1);

namespace Tests\Behat\Context\Api;

use Behat\Behat\Context\Context;
use Symfony\Component\HttpFoundation\Response;
use Tests\Service\HttpClient;
use Tests\Service\ResponseAsserter;

final class ConnoisseurContext implements Context
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
     * @When I register the :name connoisseur with the :email email and the :password password
     */
    public function iRegisterTheConnoisseurWithTheEmailAndTheEmail(string $name, string $email, string $password): void
    {
        $this->client->post('register', ['name' => $name, 'email' => $email, 'password' => $password]);
    }

    /**
     * @Then I should be able to log in as :name with :password password
     */
    public function theConnoisseurShouldBeCreated(string $name, string $password): void
    {
        $this->client->post('login_check', ['_username' => $name, '_password' => $password]);
        /** @var Response $response */
        $response = $this->client->response();

        $this->jsonAsserter->assertResponse($response, Response::HTTP_OK, '{"token": "@string@"}');
    }
}
