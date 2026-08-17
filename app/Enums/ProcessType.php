<?php

namespace App\Enums;

enum ProcessType: string
{
    case Sorting = 'Sorting';
    case Grading = 'Grading';

    public function label(): string
    {
        return match($this) {
            self::Sorting => 'Sortasi',
            self::Grading => 'Grading',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::Sorting => 'badge-processing',
            self::Grading => 'badge-ready',
        };
    }
}
