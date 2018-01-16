<?php

declare(strict_types=1);

namespace App\Domain\Connoisseur\Model;

use App\Domain\Connoisseur\Exception\EmptyNameException;

final class Name
{
    /** @var string */
    private $name;

    public function __construct(string $name)
    {
        if (empty($name)) {
            throw new EmptyNameException();
        }

        $this->name = $name;
    }

    public function value(): string
    {
        return $this->name;
    }
}
