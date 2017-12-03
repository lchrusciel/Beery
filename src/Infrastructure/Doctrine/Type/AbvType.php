<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type;

use App\Domain\Model\Abv;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

final class AbvType extends Type
{
    private const NAME = 'abv';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getFloatDeclarationSQL($fieldDeclaration);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?float
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof Abv) {
            return $value->value();
        }

        throw ConversionException::conversionFailed($value, static::NAME);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Abv
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof Abv) {
            return $value;
        }

        try {
            return new Abv((float) $value);
        } catch (\InvalidArgumentException $e) {
            throw ConversionException::conversionFailed($value, static::NAME);
        }
    }

    public function getName(): string
    {
        return static::NAME;
    }
}
