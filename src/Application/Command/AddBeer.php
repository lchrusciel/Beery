<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Model\Abv;
use App\Domain\Model\Name;
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

    public static function create(Name $name, Abv $abv): self
    {
        return new self([
            'name' => $name->value(),
            'abv' => $abv->value(),
        ]);
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
