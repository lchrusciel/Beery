<?php

declare(strict_types=1);

namespace App\Infrastructure\Security;

use App\Infrastructure\ReadModel\View\ConnoisseurView;
use Symfony\Component\Security\Core\User\UserInterface;

final class ConnoisseurSecurity implements UserInterface
{
    /** @var string */
    private $username;

    /** @var string */
    private $password;

    private function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public static function fromConnoisseurView(ConnoisseurView $connoisseurView): self
    {
        return new self($connoisseurView->email(), $connoisseurView->password());
    }

    public static function withPassword(string $password): self
    {
        return new self('dummy', $password);
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials(): void
    {
    }
}
