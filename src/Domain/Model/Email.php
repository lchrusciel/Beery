<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\Exception\InvalidEmailException;

final class Email
{
    /** @var string */
    private $value;

    public function __construct(string $value)
    {
        if ($value === '' || ! $this->validateEmail($value)) {
            throw new InvalidEmailException();
        }

        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    private function validateEmail(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }
}
