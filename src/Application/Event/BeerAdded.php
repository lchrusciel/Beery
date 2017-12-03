<?php

declare(strict_types=1);

namespace App\Application\Event;

use App\Domain\Model\Abv;
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

    public static function occur(string $name, Abv $abv): self
    {
        return new self(['name' => $name, 'abv' => $abv->value()]);
    }

    public function name(): string
    {
        return $this->payload()['name'];
    }

    public function abv(): Abv
    {
        return new Abv($this->payload()['abv']);
    }
}
