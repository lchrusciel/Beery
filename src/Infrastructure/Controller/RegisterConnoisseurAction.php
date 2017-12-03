<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Command\RegisterConnoisseur;
use App\Domain\Model\Email;
use App\Domain\Model\Name;
use App\Domain\Model\Password;
use Prooph\ServiceBus\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class RegisterConnoisseurAction
{
    /** @var CommandBus */
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(Request $request): Response
    {
        $this->commandBus->dispatch(RegisterConnoisseur::create(
            new Name($request->request->getAlnum('name')),
            new Email($request->request->get('email')),
            new Password($request->request->get('password'))
        ));

        return new JsonResponse(null, Response::HTTP_CREATED);
    }
}
