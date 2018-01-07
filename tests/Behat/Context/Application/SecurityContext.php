<?php

declare(strict_types=1);

namespace Tests\Behat\Context\Application;

use App\Application\Repository\Connoisseurs;
use Behat\Behat\Context\Context;
use Tests\Service\SharedStorage;

final class SecurityContext implements Context
{
    /** @var SharedStorage */
    private $sharedStorage;

    /** @var Connoisseurs */
    private $connoisseurs;

    public function __construct(SharedStorage $sharedStorage, Connoisseurs $connoisseurs)
    {
        $this->sharedStorage = $sharedStorage;
        $this->connoisseurs = $connoisseurs;
    }

    /**
     * @Given I am logged in as :email with :password password
     */
    public function iAmLoggedInAs(string $email): void
    {
        $this->sharedStorage->set('connoisseur', $this->connoisseurs->getOneByEmail($email));
    }
}
