<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItemAllocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_item_id',
        'seed_lot_id',
        'alloc_quantity',
    ];

    protected $casts = [
        'alloc_quantity' => 'decimal:2',
    ];

    // Relations 
    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function seedLot(): BelongsTo
    {
        return $this->belongsTo(SeedLot::class);
    }
}
