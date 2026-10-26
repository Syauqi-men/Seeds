<?php

namespace App\Enums;

enum VarClass: string
{
    case BS = 'BS';
    case FS = 'FS';
    case SS = 'SS';

    public function label(): string
    {
        return match($this) {
            self::BS => 'Breeder Seed (BS)',
            self::FS => 'Foundation Seed (FS)',
            self::SS => 'Stock Seed (SS)',
        };
    }
}
