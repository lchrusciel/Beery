<?php

declare(strict_types=1);

namespace App\Infrastructure\Projection;

use App\Application\Event\BeerAdded;
use App\Infrastructure\View\BeerView;
use Doctrine\Common\Persistence\ObjectManager;

final class BeerProjection
{
    /** @var ObjectManager */
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function __invoke(BeerAdded $beerAdded)
    {
        $this->objectManager->persist(new BeerView($beerAdded->name()->value(), $beerAdded->abv()->value()));

        $this->objectManager->flush();
    }
}
