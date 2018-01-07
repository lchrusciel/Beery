<?php

declare(strict_types=1);

namespace Tests\Behat\Context\Transform;

use App\Application\Repository\Connoisseurs;
use App\Domain\Model\Connoisseur;
use Behat\Behat\Context\Context;

final class ConnoisseurContext implements Context
{
    /** @var Connoisseurs */
    private $connoisseurs;

    public function __construct(Connoisseurs $connoisseurs)
    {
        $this->connoisseurs = $connoisseurs;
    }

    /**
     * @Transform :connoisseur
     */
    public function getConnoisseurByName(string $connoisseurName): Connoisseur
    {
        return $this->connoisseurs->getOneByName($connoisseurName);
    }
}
