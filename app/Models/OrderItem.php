<?php

namespace App\Models;

use App\Enums\VarClass;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'seed_id',
        'seed_class',
        'quantity',
    ];

    protected $casts = [
        'seed_class' => VarClass::class,
        'quantity'   => 'decimal:2',
    ];

    // Relations 
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function seed(): BelongsTo
    {
        return $this->belongsTo(Seed::class);
    }

    public function allocations(): HasMany
    {
        return $this->hasMany(OrderItemAllocation::class);
    }
}
