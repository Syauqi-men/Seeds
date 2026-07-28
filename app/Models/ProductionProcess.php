<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ProductionProcess extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'seed_lot_id',
        'input_quantity',
        'output_quantity',
        'shrinkage_quantity',
        'waste_quantity',
        'moisture_start',
        'moisture_end',
        'processed_at',
        'notes',
    ];

    protected $casts = [
        'processed_at'      => 'datetime',
        'input_quantity'    => 'decimal:2',
        'output_quantity'   => 'decimal:2',
        'shrinkage_quantity'=> 'decimal:2',
        'waste_quantity'    => 'decimal:2',
    ];

    // ─── Relations ────────────────────────────────────────────────────────
    public function seedLot(): BelongsTo
    {
        return $this->belongsTo(SeedLot::class);
    }

    // ─── Activity Log ─────────────────────────────────────────────────────
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('production_processes')
            ->setDescriptionForEvent(fn(string $eventName) => "Proses produksi untuk lot #{$this->seed_lot_id} di-{$eventName}");
    }
}
