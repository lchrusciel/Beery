<?php

declare(strict_types=1);

namespace Tests\Service;

interface SharedStorage
{
    public function get(string $key);

    public function has(string $key): bool;

    public function set(string $key, $resource): void;

    public function getLatestResource();
}
