<?php

declare(strict_types=1);

namespace App\Infrastructure\Security;

interface ConnoisseurPasswordHasherInterface
{
    public function __invoke(string $password): string;
}
