<?php

declare(strict_types=1);

namespace Tests\Service\Json;

use Symfony\Component\BrowserKit\Client;
use Symfony\Component\HttpFoundation\Response;
use Tests\Service\HttpClient;

final class JsonClient implements HttpClient
{
    /** @var Client */
    private $client;
    private $headers = [];

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function post(string $url, array $arguments): void
    {
        $this->client->request('POST', $url, $arguments, [], $this->headers);
    }

    public function get(string $url): void
    {
        $this->client->request('GET', $url, [], [], $this->headers);
    }

    public function response(): Response
    {
        $response = $this->client->getResponse();

        \assert($response instanceof Response);

        return $response;
    }

    public function decodedResponseContent(): array
    {
        $response = $this->response();

        return json_decode($response->getContent(), true);
    }

    public function addHeader(string $key, string $value): void
    {
        $this->headers[$key] = $value;
    }
}
