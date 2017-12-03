<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\Exception\InvalidPasswordException;

final class Password
{
    /** @var string */
    private $value;

    public function __construct(string $value)
    {
        if ($value === '' || !$this->validatePassword($value)) {
            throw new InvalidPasswordException();
        }

        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    private function validatePassword(string $value): bool
    {
        // Pattern explanation https://stackoverflow.com/a/32190124/4243630
        return preg_match('"^\$2[ayb]\$.{56}$"', $value) === 1;
    }
}
