<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type;

use App\Domain\Model\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

final class EmailType extends Type
{
    private const NAME = 'email';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (empty($value)) {
            return null;
        }

        if (is_string($value)) {
            $value = new Email($value);
        }

        if ($value instanceof Email) {
            return $value->value();
        }

        throw ConversionException::conversionFailed($value, static::NAME);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Email
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof Email) {
            return $value;
        }

        try {
            return new Email($value);
        } catch (\InvalidArgumentException $e) {
            throw ConversionException::conversionFailed($value, static::NAME);
        }
    }

    public function getName(): string
    {
        return static::NAME;
    }
}
