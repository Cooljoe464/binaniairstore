<?php

namespace App\Enums;

enum QuantityStatus: string
{
    case NONE = 'none';
    case LOW = 'low';
    case MEDIUM = 'medium';
    case GOOD = 'good';

    public static function fromQuantity(?int $quantity): self
    {
        if (is_null($quantity)) {
            return self::NONE;
        }

        if ($quantity <= self::lowThreshold()) {
            return self::LOW;
        }

        if ($quantity <= self::mediumThreshold()) {
            return self::MEDIUM;
        }

        return self::GOOD;
    }

    public function getColorClass(): string
    {
        return match ($this) {
            self::NONE => 'bg-gray-100 text-gray-800',
            self::LOW => 'bg-red-100 text-red-800',
            self::MEDIUM => 'bg-yellow-100 text-yellow-800',
            self::GOOD => 'bg-green-100 text-green-800',
        };
    }

    public static function lowThreshold(): int
    {
        return 10;
    }

    public static function mediumThreshold(): int
    {
        return 50;
    }
}
