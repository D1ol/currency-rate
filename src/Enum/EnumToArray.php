<?php

namespace App\Enum;

trait EnumToArray
{
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function array(): array
    {
        return array_combine(self::values(), self::names());
    }

    public static function arrayReversed(): array
    {
        return array_combine(self::names(), self::values());
    }

    public static function casesValues(array $cases): array
    {
        return array_column($cases, 'value');
    }

    public static function fromName(string $name): self
    {
        foreach (self::cases() as $status) {
            if ($name === $status->name) {
                return $status;
            }
        }

        throw new \ValueError("$name is not a valid backing value for enum ".self::class);
    }
}
