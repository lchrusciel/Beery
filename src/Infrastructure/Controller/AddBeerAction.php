<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Command\AddBeer;
use App\Domain\Model\Abv;
use App\Domain\Model\Id;
use App\Domain\Model\Name;
use App\Infrastructure\Generator\UuidGeneratorInterface;
use Prooph\ServiceBus\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class AddBeerAction
{
    /** @var CommandBus */
    private $commandBus;

    /** @var UuidGeneratorInterface */
    private $generator;

    public function __construct(CommandBus $commandBus, UuidGeneratorInterface $generator)
    {
        $this->commandBus = $commandBus;
        $this->generator = $generator;
    }

    public function __invoke(Request $request): Response
    {
        $this->commandBus->dispatch(AddBeer::create(
            new Id($this->generator->generate()),
            new Name($request->request->getAlnum('beerName')),
            new Abv((float) $request->request->getDigits('abv'))
        ));

        return new JsonResponse(null, Response::HTTP_CREATED);
    }
}
