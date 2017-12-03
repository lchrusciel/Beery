<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Application\Repository\Connoisseurs;
use App\Domain\Model\Connoisseur;
use Doctrine\Common\Persistence\ObjectManager;

final class ConnoisseurORMRepository implements Connoisseurs
{
    /** @var ObjectManager */
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function add(Connoisseur $connoisseur): void
    {
        $this->objectManager->persist($connoisseur);

        $this->objectManager->flush();
    }
}
