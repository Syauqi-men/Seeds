<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Model SeedCategory — menggantikan Enum SeedCategory.
 * Digunakan sebagai relasi dari model Seed (category_id).
 */
class SeedCategory extends Model
{
    use LogsActivity;

    protected $fillable = ['name', 'abbr', 'description'];

    // ─── Relations ────────────────────────────────────────────────────────
    public function seeds(): HasMany
    {
        return $this->hasMany(Seed::class, 'category_id');
    }

    // ─── Activity Log ─────────────────────────────────────────────────────
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
