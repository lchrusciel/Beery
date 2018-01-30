<?php

declare(strict_types=1);

namespace Tests\Behat\Context\Application;

use App\Application\Recommendation\RecommendationEngine;
use App\Domain\Connoisseur\Model\Connoisseur;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;

final class RecommendationContext implements Context
{
    /** @var RecommendationEngine */
    private $recommendationEngine;

    /**
     * @When /^(I) ask for a beer recommendation$/
     */
    public function iAskForABeerRecommendation(Connoisseur $connoisseur)
    {
        throw new PendingException();
    }

    /**
     * @Then the :arg1 beer should be suggested
     */
    public function theBeerShouldBeSuggested($arg1)
    {
        throw new PendingException();
    }
}
