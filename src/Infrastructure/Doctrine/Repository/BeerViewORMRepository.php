<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

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

        $this->objectManager->flush();
    }

    public function getAll(): array
    {
        return $this->repository->findAll();
    }
}
