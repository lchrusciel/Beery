<?php

declare(strict_types=1);

namespace App\Application\Event;

use App\Domain\Beer\Model\Abv;
use App\Domain\Beer\Model\Id;
use App\Domain\Beer\Model\Name;
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

    public static function occur(Id $id, Name $name, Abv $abv): self
    {
        return new self(['id' => $id->value(), 'name' => $name->value(), 'abv' => $abv->value()]);
    }

    public function id(): Id
    {
        return new Id($this->payload()['id']);
    }

    public function name(): Name
    {
        return new Name($this->payload()['name']);
    }

    public function abv(): Abv
    {
        return new Abv($this->payload()['abv']);
    }
}
