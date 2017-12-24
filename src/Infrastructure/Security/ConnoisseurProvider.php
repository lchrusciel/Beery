<?php

declare(strict_types=1);

namespace App\Infrastructure\Security;

use App\Infrastructure\Exception\ConnoisseurViewNotFound;
use App\Infrastructure\Repository\ConnoisseurViews;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class ConnoisseurProvider implements UserProviderInterface
{
    /** @var ConnoisseurViews */
    private $connoisseurViewRepository;

    public function __construct(ConnoisseurViews $connoisseurViewRepository)
    {
        $this->connoisseurViewRepository = $connoisseurViewRepository;
    }

    public function loadUserByUsername($username): ConnoisseurSecurity
    {
        try {
            $connoisseurView = $this->connoisseurViewRepository->getByEmail($username);

            return ConnoisseurSecurity::fromConnoisseurView($connoisseurView);
        } catch (ConnoisseurViewNotFound $exception) {
            throw new UsernameNotFoundException('', 0, $exception);
        }
    }

    public function refreshUser(UserInterface $user): ConnoisseurSecurity
    {
        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class): bool
    {
        return $class === ConnoisseurSecurity::class;
    }
}
