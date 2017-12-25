<?php

declare(strict_types=1);

namespace Tests\Behat\Context\Api;

use Behat\Behat\Context\Context;
use Tests\Service\HttpClient;

final class SecurityContext implements Context
{
    /** @var HttpClient */
    private $client;

    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * @Given I am logged in as :email with :password password
     */
    public function iAmLoggedInAs(string $email, string $password): void
    {
        $this->client->post('login_check', ['_username' => $email, '_password' => $password]);

        $response = $this->client->decodedResponseContent();

        $this->client->addHeader('HTTP_Authorization', 'Bearer ' . $response['token']);
    }
}
