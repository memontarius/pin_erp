<?php

namespace App\Enums;

enum ProductStatus: string
{
    case Available = 'available';
    case Unavailable = 'unavailable';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
