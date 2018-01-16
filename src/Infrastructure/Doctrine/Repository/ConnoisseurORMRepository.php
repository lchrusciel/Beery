<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Application\Repository\Connoisseurs;
use App\Domain\Connoisseur\Model\Connoisseur;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

final class ConnoisseurORMRepository implements Connoisseurs
{
    /** @var ObjectManager */
    private $objectManager;

    /** @var ObjectRepository */
    private $repository;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        $this->repository = $this->objectManager->getRepository(Connoisseur::class);
    }

    public function add(Connoisseur $connoisseur): void
    {
        $this->objectManager->persist($connoisseur);

        $this->objectManager->flush();
    }

    public function getOneByEmail(string $email): Connoisseur
    {
        $connoisseur = $this->repository->findOneBy(['email' => $email]);

        \assert($connoisseur instanceof Connoisseur);

        return $connoisseur;
    }

    public function getOneByName(string $name): Connoisseur
    {
        $connoisseur = $this->repository->findOneBy(['name' => $name]);

        \assert($connoisseur instanceof Connoisseur);

        return $connoisseur;
    }
}
