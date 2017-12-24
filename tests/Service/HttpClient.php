<?php

declare(strict_types=1);

namespace Tests\Service;

use Symfony\Component\HttpFoundation\Response;

interface HttpClient
{
    public function get(string $url): void;

    public function post(string $url, array $arguments): void;

    public function response(): Response;

    public function decodedResponseContent(): array;

    public function addHeader(string $key, string $value): void;
}
