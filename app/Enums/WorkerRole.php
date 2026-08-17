<?php

namespace App\Enums;

enum WorkerRole: string
{
    case Sorting = 'Sorting';
    case Grading = 'Grading';
    case Both    = 'Both';

    public function label(): string
    {
        return match($this) {
            self::Sorting => 'Sortasi',
            self::Grading => 'Grading',
            self::Both    => 'Sortasi & Grading',
        };
    }
}
