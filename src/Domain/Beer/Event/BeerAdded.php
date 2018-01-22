<?php

declare(strict_types=1);

namespace App\Domain\Beer\Event;

use App\Domain\Beer\Model\Abv;
use App\Domain\Beer\Model\Id;
use App\Domain\Beer\Model\Name;
use Prooph\EventSourcing\AggregateChanged;

final class BeerAdded extends AggregateChanged
{
    public static function withData(Id $id, Name $name, Abv $abv): self
    {
        return self::occur($id->value(), ['name' => $name->value(), 'abv' => $abv->value()]);
    }

    public function id(): Id
    {
        return new Id($this->aggregateId());
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
