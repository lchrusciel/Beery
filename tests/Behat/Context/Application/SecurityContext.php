<?php

declare(strict_types=1);

namespace Tests\Behat\Context\Application;

use Behat\Behat\Context\Context;

final class SecurityContext implements Context
{
    /**
     * @Given I am logged in as :email with :password password
     */
    public function iAmLoggedInAs(): void
    {
        // Intentionally left blank
    }
}
