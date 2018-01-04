<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\Exception\InvalidUuidFormatException;
use Ramsey\Uuid\Uuid;

final class Id
{
    /** @var string */
    private $id;

    public function __construct(string $id)
    {
        if (! Uuid::isValid($id)) {
            throw new InvalidUuidFormatException();
        }

        $this->id = $id;
    }

    public function __toString(): string
    {
        return $this->value();
    }

    public function value(): string
    {
        return $this->id;
    }
}
