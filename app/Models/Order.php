<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Order extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'user_id',
        'petugas_benih_id',
        'cust_name',
        'reference_num',
        'order_type',
        'status',
        'payment_status',
        'notes',
    ];

    protected $casts = [
        'status'         => 'string',
        'order_type'     => 'string',
        'payment_status' => 'string',
        'created_at'     => 'datetime',
    ];

    // Relations 
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function petugasBenih(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_benih_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Activity Log 
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('orders')
            ->setDescriptionForEvent(fn(string $eventName) => "Pesanan #{$this->id} ({$this->cust_name}) di-{$eventName}");
    }
}
