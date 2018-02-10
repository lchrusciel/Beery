<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\ArgumentResolver;

use App\Infrastructure\ReadModel\Repository\ConnoisseurViews;
use App\Infrastructure\ReadModel\View\ConnoisseurView;
use App\Infrastructure\Security\ConnoisseurSecurity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

final class ConnoisseurViewResolver implements ArgumentValueResolverInterface
{
    /** @var TokenStorageInterface */
    private $tokenStorage;

    /** @var ConnoisseurViews */
    private $connoisseurViewRepository;

    public function __construct(TokenStorageInterface $tokenStorage, ConnoisseurViews $connoisseurViewRepository)
    {
        $this->tokenStorage = $tokenStorage;
        $this->connoisseurViewRepository = $connoisseurViewRepository;
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        // only security user implementations are supported
        if ($argument->getType() !== ConnoisseurView::class) {
            return false;
        }

        $token = $this->tokenStorage->getToken();
        if (!$token instanceof TokenInterface) {
            return false;
        }

        $user = $token->getUser();

        // in case it's not an object we cannot do anything with it; E.g. "anon."
        return $user instanceof ConnoisseurSecurity;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): ?\Generator
    {
        $token = $this->tokenStorage->getToken();

        \assert($token !== null);

        $user = $token->getUser();

        \assert($user instanceof ConnoisseurSecurity);

        yield $this->connoisseurViewRepository->getByEmail($user->getUsername());
    }
}
