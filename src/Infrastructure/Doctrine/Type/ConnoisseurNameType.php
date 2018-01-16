<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type;

use App\Domain\Connoisseur\Model\Name;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

final class ConnoisseurNameType extends Type
{
    private const NAME = 'name';

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
            $value = new Name($value);
        }

        if ($value instanceof Name) {
            return $value->value();
        }

        throw ConversionException::conversionFailed($value, static::NAME);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Name
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof Name) {
            return $value;
        }

        try {
            return new Name($value);
        } catch (\InvalidArgumentException $exception) {
            throw ConversionException::conversionFailed($value, static::NAME);
        }
    }

    public function getName(): string
    {
        return static::NAME;
    }
}
