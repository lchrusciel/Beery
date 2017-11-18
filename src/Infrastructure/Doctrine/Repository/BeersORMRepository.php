<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Application\Repository\Beers;
use App\Domain\Model\Beer;
use Doctrine\Common\Persistence\ObjectManager;

final class BeersORMRepository implements Beers
{
    /** @var ObjectManager */
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function add(Beer $beer): void
    {
        $this->objectManager->persist($beer);

        $this->objectManager->flush();
    }
}
