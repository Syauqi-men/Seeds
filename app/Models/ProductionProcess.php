<?php

namespace App\Models;

use App\Enums\ProcessType;
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
        'process_type',
        'worker_id',
        'input_quantity',
        'output_quantity',
        'sortir_quantity',   
        'waste_quantity',
        'processed_at',
        'notes',
    ];

    protected $casts = [
        'process_type'    => ProcessType::class,
        'processed_at'    => 'datetime',
        'input_quantity'  => 'decimal:2',
        'output_quantity' => 'decimal:2',
        'sortir_quantity' => 'decimal:2',
        'waste_quantity'  => 'decimal:2',
    ];

    // Relations 
    public function seedLot(): BelongsTo
    {
        return $this->belongsTo(SeedLot::class);
    }

    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }

    // Activity Log 
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
