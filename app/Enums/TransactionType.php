<?php

namespace App\Enums;

enum TransactionType: string
{
    case IN         = 'IN';
    case OUT        = 'OUT';
    case ADJUSTMENT = 'ADJUSTMENT';

    public function label(): string
    {
        return match($this) {
            self::IN         => 'Masuk',
            self::OUT        => 'Keluar',
            self::ADJUSTMENT => 'Penyesuaian',
        };
    }

    public function isDebit(): bool
    {
        return $this === self::IN;
    }
}
