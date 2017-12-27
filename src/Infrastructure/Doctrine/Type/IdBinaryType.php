<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type;

use App\Domain\Model\Id;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;
use Ramsey\Uuid\Uuid;

final class IdBinaryType extends UuidBinaryOrderedTimeType
{
    public const NAME = 'id_binary';

    public function convertToPHPValue($value, AbstractPlatform $platform): Id
    {
        return new Id(parent::convertToPHPValue($value, $platform)->toString());
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof Id) {
            $value = Uuid::fromString($value->value());
        }

        return parent::convertToDatabaseValue($value, $platform);
    }

    public function getName(): string
    {
        return self::NAME;
    }

}
