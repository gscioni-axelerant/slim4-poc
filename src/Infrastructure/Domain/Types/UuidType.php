<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use Ramsey\Uuid\Uuid;

final class UuidType extends GuidType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!$value) {
            return null;
        }

        return $value->toString();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return Uuid::fromString($value);
    }
}
