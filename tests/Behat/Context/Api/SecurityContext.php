<?php

declare(strict_types=1);

namespace Tests\Behat\Context\Api;

use App\Application\Repository\Connoisseurs;
use Behat\Behat\Context\Context;
use Tests\Service\HttpClient;
use Tests\Service\SharedStorage;

final class SecurityContext implements Context
{
    /** @var HttpClient */
    private $client;

    /** @var SharedStorage */
    private $sharedStorage;

    /** @var Connoisseurs */
    private $connoisseurs;

    public function __construct(HttpClient $client, SharedStorage $sharedStorage, Connoisseurs $connoisseurs)
    {
        $this->client = $client;
        $this->sharedStorage = $sharedStorage;
        $this->connoisseurs = $connoisseurs;
    }

    /**
     * @Given I am logged in as :email with :password password
     */
    public function iAmLoggedInAs(string $email, string $password): void
    {
        $this->client->post('login_check', ['_username' => $email, '_password' => $password]);

        $response = $this->client->decodedResponseContent();

        $this->client->addHeader('HTTP_Authorization', 'Bearer ' . $response['token']);
        $this->sharedStorage->set('connoisseur', $this->connoisseurs->getOneByEmail($email));
    }
}
