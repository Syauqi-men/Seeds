<?php

namespace App\Models;

use App\Enums\WorkerRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Worker extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
        'code',
        'role',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'role'      => WorkerRole::class,
        'is_active' => 'boolean',
    ];

    // Relations 
    public function productionProcesses(): HasMany
    {
        return $this->hasMany(ProductionProcess::class);
    }

    // Scopes 
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeCanDo($query, string $type)
    {
        return $query->where(function ($q) use ($type) {
            $q->where('role', $type)->orWhere('role', 'Both');
        });
    }

    // Activity Log 
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('workers')
            ->setDescriptionForEvent(fn(string $eventName) => "Pekerja {$this->name} di-{$eventName}");
    }
}
