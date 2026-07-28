<?php

namespace App\Enums;

enum VarClass: string
{
    case NS = 'NS';
    case BS = 'BS';
    case FS = 'FS';
    case SS = 'SS';

    public function label(): string
    {
        return match($this) {
            self::NS => 'Nucleus Seed (NS)',
            self::BS => 'Breeder Seed (BS)',
            self::FS => 'Foundation Seed (FS)',
            self::SS => 'Stock Seed (SS)',
        };
    }
}
