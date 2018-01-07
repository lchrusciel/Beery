<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Application\Repository\Beers;
use App\Application\Repository\Exception\BeerNotFoundException;
use App\Domain\Model\Beer;
use App\Domain\Model\Id;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

final class BeersORMRepository implements Beers
{
    /** @var ObjectManager */
    private $objectManager;

    /** @var ObjectRepository */
    private $repository;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        $this->repository = $this->objectManager->getRepository(Beer::class);
    }

    public function add(Beer $beer): void
    {
        $this->objectManager->persist($beer);

        $this->objectManager->flush();
    }

    public function get(Id $id): Beer
    {
        $beer = $this->repository->find($id);

        if (!$beer instanceof Beer) {
            throw new BeerNotFoundException();
        }

        return $beer;
    }

    public function getByName(string $beerName): Beer
    {
        $beer = $this->repository->findOneBy(['name' => $beerName]);

        if (!$beer instanceof Beer) {
            throw new BeerNotFoundException();
        }

        return $beer;
    }
}
