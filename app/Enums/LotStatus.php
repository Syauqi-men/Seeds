<?php

namespace App\Enums;

enum LotStatus: string
{
    case Raw        = 'Raw';
    case Processing = 'Processing';
    case Quarantine = 'Quarantine';
    case Ready      = 'Ready';
    case Depleted   = 'Depleted';

    public function label(): string
    {
        return match($this) {
            self::Raw        => 'Mentah',
            self::Processing => 'Diproses',
            self::Quarantine => 'Karantina',
            self::Ready      => 'Siap',
            self::Depleted   => 'Habis',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::Raw        => 'badge-raw',
            self::Processing => 'badge-processing',
            self::Quarantine => 'badge-quarantine',
            self::Ready      => 'badge-ready',
            self::Depleted   => 'badge-depleted',
        };
    }
}
