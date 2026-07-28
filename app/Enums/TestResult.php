<?php

namespace App\Enums;

enum TestResult: string
{
    case PASSED = 'PASSED';
    case FAILED = 'FAILED';

    public function label(): string
    {
        return match($this) {
            self::PASSED => 'Lulus',
            self::FAILED => 'Tidak Lulus',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::PASSED => 'badge-ready',
            self::FAILED => 'badge-depleted',
        };
    }
}
