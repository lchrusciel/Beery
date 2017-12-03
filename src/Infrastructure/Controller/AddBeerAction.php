<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Command\AddBeer;
use App\Domain\Model\Abv;
use App\Domain\Model\Name;
use Prooph\ServiceBus\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class AddBeerAction
{
    /** @var CommandBus */
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(Request $request): Response
    {
        $this->commandBus->dispatch(AddBeer::create(
            new Name($request->request->getAlnum('beerName')),
            new Abv((float) $request->request->getDigits('abv'))
        ));

        return new JsonResponse(null, Response::HTTP_CREATED);
    }
}
