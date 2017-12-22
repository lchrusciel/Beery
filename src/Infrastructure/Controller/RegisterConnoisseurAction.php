<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Command\RegisterConnoisseur;
use App\Domain\Model\Email;
use App\Domain\Model\Name;
use App\Domain\Model\Password;
use App\Infrastructure\Security\PasswordHasher;
use Prooph\ServiceBus\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class RegisterConnoisseurAction
{
    /** @var CommandBus */
    private $commandBus;

    /** @var PasswordHasher */
    private $passwordHasher;

    public function __construct(CommandBus $commandBus, PasswordHasher $passwordHasher)
    {
        $this->commandBus = $commandBus;
        $this->passwordHasher = $passwordHasher;
    }

    public function __invoke(Request $request): Response
    {
        $this->commandBus->dispatch(RegisterConnoisseur::create(
            new Name($request->request->getAlnum('name')),
            new Email($request->request->get('email')),
            new Password(($this->passwordHasher)($request->request->get('password')))
        ));

        return new JsonResponse(null, Response::HTTP_CREATED);
    }
}
