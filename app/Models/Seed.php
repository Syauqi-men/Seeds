<?php

namespace App\Models;

use App\Enums\VarClass;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Seed extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'var_name',
        'var_class',
        'category_id',   // FK ke seed_categories (menggantikan ENUM category)
        'description',
    ];

    protected $casts = [
        'var_class' => VarClass::class,
        // category tidak di-cast lagi — akses lewat relasi $seed->category
    ];

    // ─── Relations ────────────────────────────────────────────────────────
    public function category(): BelongsTo
    {
        return $this->belongsTo(SeedCategory::class, 'category_id');
    }

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
