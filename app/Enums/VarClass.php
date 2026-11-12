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

    public function color(): string
    {
        return match($this) {
            self::BS => '#ed8e5f',
            self::FS => '#ffe5e5',
            self::SS => '#73264c',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::BS => 'badge-class-bs',
            self::FS => 'badge-class-fs',
            self::SS => 'badge-class-ss',
        };
    }

    public static function colorFor(?string $code): string
    {
        return match(strtoupper(trim((string) $code))) {
            'BS'    => '#ed8e5f',
            'FS'    => '#ffe5e5',
            'SS'    => '#73264c',
            default => '#64748B',
        };
    }

    public static function badgeClassFor(?string $code): string
    {
        return match(strtoupper(trim((string) $code))) {
            'BS'    => 'badge-class-bs',
            'FS'    => 'badge-class-fs',
            'SS'    => 'badge-class-ss',
            default => 'badge-raw',
        };
    }
}
