<?php

declare(strict_types=1);

namespace App\Domain\Model;

use Ramsey\Uuid\Uuid;
use App\Domain\Exception\InvalidUuidFormatException;

final class Id
{
    /** @var string */
    private $id;

    public function __construct(string $id)
    {
        if (!Uuid::isValid($id)) {
            throw new InvalidUuidFormatException();
        }

        $this->id = $id;
    }

    public function value(): string
    {
        return $this->id;
    }
}
