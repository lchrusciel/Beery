<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Model\Abv;
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

    public static function create(string $beerName, Abv $abv): self
    {
        return new self([
            'beerName' => $beerName,
            'abv' => $abv->value(),
        ]);
    }

    public function name(): string
    {
        return $this->payload()['beerName'];
    }

    public function abv(): Abv
    {
        return new Abv($this->payload()['abv']);
    }
}
