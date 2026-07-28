<?php

namespace App\Enums;

enum SeedCategory: string
{
    case Kedelai     = 'Kedelai';
    case KacangTanah = 'Kacang Tanah';
    case KacangHijau = 'Kacang Hijau';

    public function label(): string
    {
        return $this->value;
    }

    public function abbr(): string
    {
        return match($this) {
            self::Kedelai     => 'KDL',
            self::KacangTanah => 'KTH',
            self::KacangHijau => 'KHJ',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Kedelai     => 'emerald',
            self::KacangTanah => 'amber',
            self::KacangHijau => 'lime',
        };
    }
}
