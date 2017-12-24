<?php

declare(strict_types=1);

namespace Tests\Behat\Context\Api;

use Behat\Behat\Context\Context;
use Symfony\Component\BrowserKit\Client;
use Tests\Service\ResponseAsserter;

final class SecurityContext implements Context
{
    /** @var Client */
    private $client;

    /** @var ResponseAsserter */
    private $jsonAsserter;

    public function __construct(Client $client, ResponseAsserter $jsonAsserter)
    {
        $this->client = $client;
        $this->jsonAsserter = $jsonAsserter;
    }

    /**
     * @Given I am logged in as :email with :password password
     */
    public function iAmLoggedInAs(string $email, string $password): void
    {
        $this->client->request('POST', 'login_check', ['_username' => $email, '_password' => $password]);
    }
}
