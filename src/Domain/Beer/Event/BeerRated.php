<?php

declare(strict_types=1);

namespace App\Domain\Beer\Event;

use App\Domain\Beer\Model\Id;
use App\Domain\Beer\Model\Rate;
use App\Domain\Connoisseur\Model\Email;
use Prooph\EventSourcing\AggregateChanged;

final class BeerRated extends AggregateChanged
{
    public static function withData(Id $beerId, Email $connoisseurEmail, Rate $rate): self
    {
        return self::occur($beerId->value(), [
            'connoisseur_email' => $connoisseurEmail->value(),
            'rate' => $rate->value(),
        ]);
    }

    public function beerId(): Id
    {
        return new Id($this->aggregateId());
    }

    public function connoisseurEmail(): Email
    {
        return new Email($this->payload()['connoisseur_email']);
    }

    public function rate(): Rate
    {
        return new Rate($this->payload()['rate']);
    }
}
