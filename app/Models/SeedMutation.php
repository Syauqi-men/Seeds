<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeedMutation extends Model
{
    use HasFactory;

    protected $fillable = [
        'seed_lot_id',
        'mutated_at',
        'notes',
    ];

    protected $casts = [
        'mutated_at' => 'date',
    ];

    public function seedLot(): BelongsTo
    {
        return $this->belongsTo(SeedLot::class);
    }
}
