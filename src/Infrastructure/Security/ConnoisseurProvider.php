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
    private $administratorViewRepository;

    public function __construct(ConnoisseurViews $administratorViewRepository)
    {
        $this->administratorViewRepository = $administratorViewRepository;
    }

    public function loadUserByUsername($username): ConnoisseurSecurity
    {
        try {
            $administratorView = $this->administratorViewRepository->getByEmail($username);

            return ConnoisseurSecurity::fromConnoisseurView($administratorView);
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
