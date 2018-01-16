<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type;

use App\Domain\Connoisseur\Model\Password;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

final class PasswordType extends Type
{
    private const NAME = 'password';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof Password) {
            return $value->value();
        }

        throw ConversionException::conversionFailed($value, static::NAME);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Password
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof Password) {
            return $value;
        }

        try {
            return new Password($value);
        } catch (\InvalidArgumentException $exception) {
            throw ConversionException::conversionFailed($value, static::NAME);
        }
    }

    public function getName(): string
    {
        return static::NAME;
    }
}
