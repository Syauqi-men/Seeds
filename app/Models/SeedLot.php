<?php

namespace App\Models;

use App\Enums\LotStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class SeedLot extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'seed_id',
        'lot_number',
        'harvest_date',
        'origin_weight',
        'origin_moisture',
        'arrival_weight',
        'arrival_moisture',
        'location',
        'lot_code_prefix',
        'status',
        'raw_stock',
        'clean_stock',
        'graded_stock',
    ];

    protected $casts = [
        'status'          => LotStatus::class,
        'harvest_date'    => 'date',
        'raw_stock'       => 'decimal:2',
        'clean_stock'     => 'decimal:2',
        'graded_stock'    => 'decimal:2',
    ];

    // ─── Relations ────────────────────────────────────────────────────────
    public function seed(): BelongsTo
    {
        return $this->belongsTo(Seed::class);
    }

    public function productionProcesses(): HasMany
    {
        return $this->hasMany(ProductionProcess::class);
    }

    public function labTests(): HasMany
    {
        return $this->hasMany(LabTest::class);
    }

    public function stockTransactions(): HasMany
    {
        return $this->hasMany(StockTransaction::class);
    }

    // ─── Activity Log ─────────────────────────────────────────────────────
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('seed_lots')
            ->setDescriptionForEvent(fn(string $eventName) => "Lot {$this->lot_number} di-{$eventName}");
    }
}
