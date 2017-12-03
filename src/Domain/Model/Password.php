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
        return preg_match('"^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$"', $value) === 1;
    }
}
