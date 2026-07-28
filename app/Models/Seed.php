<?php

namespace App\Models;

use App\Enums\SeedCategory;
use App\Enums\VarClass;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Seed extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'var_name',
        'var_class',
        'category',
        'description',
    ];

    protected $casts = [
        'var_class' => VarClass::class,
        'category'  => SeedCategory::class,
    ];

    // ─── Relations ────────────────────────────────────────────────────────
    public function seedLots(): HasMany
    {
        return $this->hasMany(SeedLot::class);
    }

    // ─── Activity Log ─────────────────────────────────────────────────────
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('seeds')
            ->setDescriptionForEvent(fn(string $eventName) => "Varietas benih {$this->var_name} di-{$eventName}");
    }
}
