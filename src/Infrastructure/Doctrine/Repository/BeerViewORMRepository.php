<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Beer\Model\Id;
use App\Infrastructure\ReadModel\View\BeerView;
use App\Infrastructure\Repository\BeerViews;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

final class BeerViewORMRepository implements BeerViews
{
    /** @var ObjectManager */
    private $objectManager;

    /** @var ObjectRepository */
    private $repository;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        $this->repository = $objectManager->getRepository(BeerView::class);
    }

    public function add(BeerView $beerView): void
    {
        $this->objectManager->persist($beerView);

        $this->save();
    }

    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    public function get(Id $id): BeerView
    {
        $beerView = $this->repository->find($id);

        assert($beerView instanceof BeerView);

        return $beerView;
    }

    public function getByName(string $name): BeerView
    {
        $beerView = $this->repository->findOneBy(['name' => $name]);

        assert($beerView instanceof BeerView);

        return $beerView;
    }

    public function save(): void
    {
        $this->objectManager->flush();
    }
}
