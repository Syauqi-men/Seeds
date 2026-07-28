<?php

namespace App\Models;

use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class StockTransaction extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'seed_lot_id',
        'transaction_type',
        'quantity',
        'reference_no',
        'notes',
        'transacted_at',
    ];

    protected $casts = [
        'transaction_type' => TransactionType::class,
        'transacted_at'    => 'datetime',
        'quantity'         => 'decimal:2',
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
            ->useLogName('stock_transactions')
            ->setDescriptionForEvent(fn(string $eventName) => "Transaksi stok untuk lot #{$this->seed_lot_id} di-{$eventName}");
    }
}
