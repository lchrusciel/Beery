<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Infrastructure\Repository\ConnoisseurViews;
use App\Infrastructure\View\ConnoisseurView;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

final class ConnoisseurViewORMRepository implements ConnoisseurViews
{
    /** @var ObjectManager */
    private $objectManager;

    /** @var ObjectRepository */
    private $repository;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        $this->repository = $objectManager->getRepository(ConnoisseurView::class);
    }

    public function add(ConnoisseurView $connoisseurView): void
    {
        $this->objectManager->persist($connoisseurView);

        $this->objectManager->flush();
    }

    public function getByEmail(string $email): ConnoisseurView
    {
        $connoisseurView = $this->repository->findOneBy(['email' => $email]);

        \assert($connoisseurView instanceof ConnoisseurView);

        return $connoisseurView;
    }
}
