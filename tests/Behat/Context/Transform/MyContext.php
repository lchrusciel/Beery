<?php

declare(strict_types=1);

namespace Tests\Behat\Context\Transform;

use App\Domain\Model\Connoisseur;
use Behat\Behat\Context\Context;
use Tests\Service\SharedStorage;

final class MyContext implements Context
{
    /** @var SharedStorage */
    private $sharedStorage;

    public function __construct(SharedStorage $sharedStorage)
    {
        $this->sharedStorage = $sharedStorage;
    }

    /**
     * @Transform I
     */
    public function getConnoisseurFromSharedStorage(): Connoisseur
    {
        $connoisseur = $this->sharedStorage->get('connoisseur');

        \assert($connoisseur instanceof Connoisseur);

        return $connoisseur;
    }
}
