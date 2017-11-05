<?php

declare(strict_types=1);

namespace App\Application\CommandHandler;

use App\Application\Command\AddBeer;
use App\Domain\Model\Beer;
use Doctrine\Common\Persistence\ObjectManager;

final class AddBeerHandler
{
    /** @var ObjectManager */
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function __invoke(AddBeer $addBeer)
    {
        $this->objectManager->persist(Beer::add(
            $addBeer->beerName(),
            $addBeer->abv()
        ));

        $this->objectManager->flush();
    }
}
