<?php

declare(strict_types=1);

namespace Tests\Behat\Service;

use Symfony\Component\HttpFoundation\Response;

interface JsonAsserterInterface
{
    public function assertResponse(Response $response, int $code, string $expectedContent): void;

    public function assertResponseContent(Response $response, string $expectedContent): void;

    public function assertResponseCode(Response $response, int $code): void;

    public function assertResponseHeader(Response $response): void;
}
