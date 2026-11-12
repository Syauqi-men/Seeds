<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class SeedCategory extends Model
{
    use LogsActivity;

    protected $fillable = ['name', 'abbr', 'description'];

    public const COLORS = [
        'kedelai'      => '#EBB036', // Kuning keemasan terang/muda
        'kacang hijau' => '#3D7A4A', // Hijau sedikit matang
        'kacang tanah' => '#B86B52', // Merah kecoklatan muda
    ];

    public static function colorFor(?string $name): string
    {
        $key = mb_strtolower(trim((string) $name));
        return self::COLORS[$key] ?? '#64748B';
    }

    public static function badgeClassFor(?string $name): string
    {
        $slug = str_replace(' ', '-', mb_strtolower(trim((string) $name)));
        return 'badge-category-' . ($slug !== '' ? $slug : 'lain');
    }

    // Relations
    public function seeds(): HasMany
    {
        return $this->hasMany(Seed::class, 'category_id');
    }

    // Activity Log 
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('seed_categories')
            ->setDescriptionForEvent(fn(string $eventName) => "Kategori {$this->name} di-{$eventName}");
    }
}
