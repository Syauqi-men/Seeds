<?php

namespace App\Enums;

enum TransactionType: string
{
    case IN         = 'IN';
    case OUT        = 'OUT';
    case ADJUSTMENT = 'ADJUSTMENT';
    case GRADING    = 'GRADING';
    case SORTING    = 'SORTING';

    public function label(): string
    {
        return match($this) {
            self::IN         => 'Masuk',
            self::OUT        => 'Keluar',
            self::ADJUSTMENT => 'Penyesuaian',
            self::GRADING    => 'Grading',
            self::SORTING    => 'Sortasi',
        };
    }

    public function isDebit(): bool
    {
        return $this === self::IN;
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::IN         => 'badge-ready',
            self::OUT        => 'badge-depleted',
            self::ADJUSTMENT => 'badge-processing',
            self::GRADING    => 'badge-quarantine',
            self::SORTING    => 'badge-raw',
        };
    }
}
