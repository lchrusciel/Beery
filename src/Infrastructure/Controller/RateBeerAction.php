<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Command\RateBeer;
use App\Domain\Beer\Model\Id;
use App\Domain\Beer\Model\Rate;
use App\Domain\Connoisseur\Model\Email;
use App\Infrastructure\Security\ConnoisseurSecurity;
use Prooph\ServiceBus\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class RateBeerAction
{
    /** @var CommandBus */
    private $commandBus;

    /** @var TokenStorageInterface */
    private $tokenStorage;

    public function __construct(CommandBus $commandBus, TokenStorageInterface $tokenStorage)
    {
        $this->commandBus = $commandBus;
        $this->tokenStorage = $tokenStorage;
    }

    public function __invoke(Request $request): Response
    {
        $requestParameterBag = $request->request;
        $attributesParameterBag = $request->attributes;

        $token = $this->tokenStorage->getToken();

        \assert($token !== null);

        /** @var ConnoisseurSecurity $connoisseurSecurity */
        $connoisseurSecurity = $token->getUser();
        $connoisseurEmail = $connoisseurSecurity->getUsername();

        $this->commandBus->dispatch(RateBeer::create(
            new Email($connoisseurEmail),
            new Id($attributesParameterBag->get('beerId')),
            new Rate((float) $requestParameterBag->getDigits('rate'))
        ));

        return new JsonResponse(null, Response::HTTP_CREATED);
    }
}
