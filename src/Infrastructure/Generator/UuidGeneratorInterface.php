<?php

declare(strict_types=1);

namespace App\Infrastructure\Generator;

interface UuidGeneratorInterface
{
    public function generate(): string ;
}
