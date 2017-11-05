<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Command\AddBeer;
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
            $request->request->get('beerName'),
            $request->request->get('abv')
        ));

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
