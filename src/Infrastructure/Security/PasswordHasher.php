<?php

declare(strict_types=1);

namespace App\Infrastructure\Security;

interface PasswordHasher
{
    public function __invoke(string $password): string;
}
