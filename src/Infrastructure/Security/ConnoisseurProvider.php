<?php

declare(strict_types=1);

namespace App\Infrastructure\Security;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class ConnoisseurProvider implements UserProviderInterface
{
    /** @var ConnoisseurViewRepository */
    private $administratorViewRepository;

    public function __construct(ConnoisseurViewRepository $administratorViewRepository)
    {
        $this->administratorViewRepository = $administratorViewRepository;
    }

    public function loadUserByUsername($username): SecurityConnoisseur
    {
        try {
            $administratorView = $this->administratorViewRepository->getByUsername($username);

            return SecurityConnoisseur::fromConnoisseurView($administratorView);
        } catch (ConnoisseurViewNotFound $exception) {
            throw new UsernameNotFoundException('', 0, $exception);
        }
    }

    public function refreshUser(UserInterface $user): SecurityConnoisseur
    {
        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class): bool
    {
        return $class === ConnoisseurSecurity::class;
    }
}
