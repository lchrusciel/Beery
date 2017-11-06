<?php

declare(strict_types=1);

namespace App\Domain\Event;

use Prooph\Common\Messaging\DomainEvent;
use Prooph\Common\Messaging\PayloadTrait;

final class BeerAdded extends DomainEvent
{
    use PayloadTrait;

    private function __construct(array $payload)
    {
        $this->init();
        $this->setPayload($payload);
    }

    public static function occur(string $name, int $abv): self
    {
        return new self(['name' => $name, 'abv' => $abv]);
    }

    public function name(): string
    {
        return $this->payload()['name'];
    }

    public function abv(): int
    {
        return $this->payload()['abv'];
    }
}
