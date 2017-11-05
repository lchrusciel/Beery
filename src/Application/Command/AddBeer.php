<?php

declare(strict_types=1);

namespace App\Application\Command;

use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadTrait;

final class AddBeer extends Command
{
    use PayloadTrait;

    private function __construct(array $payload)
    {
        $this->init();
        $this->setPayload($payload);
    }

    public static function create(string $beerName, int $abv): self
    {
        return new self([
            'beerName' => $beerName,
            'abv' => $abv,
        ]);
    }

    public function beerName(): string
    {
        return $this->payload()['beerName'];
    }

    public function abv(): int
    {
        return $this->payload()['abv'];
    }
}
