<?php

declare(strict_types=1);

namespace App\Infrastructure\Security;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class ConnoisseurPasswordHasher implements ConnoisseurPasswordHasherInterface
{
    /** @var UserPasswordEncoderInterface */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function __invoke(string $password): string
    {
        $user = ConnoisseurSecurity::withPassword($password);

        return $this->passwordEncoder->encodePassword($user, $user->getPassword());
    }
}
