<?php

namespace App\Models;

use App\Enums\TestResult;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class LabTest extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'seed_lot_id',
        'germination_rate',
        'moisture_content',
        'test_result',
        'tested_at',
        'notes',
    ];

    protected $casts = [
        'test_result'      => TestResult::class,
        'tested_at'        => 'date',
        'germination_rate' => 'decimal:2',
        'moisture_content' => 'decimal:2',
    ];

    public const MIN_GERMINATION_RATE = 80.0;
    public const MAX_MOISTURE_CONTENT = 12.0;

    public static function determineResult(float $germinationRate, ?float $moistureContent = null): TestResult
    {
        $germPassed     = $germinationRate >= self::MIN_GERMINATION_RATE;
        $moisturePassed = $moistureContent === null || $moistureContent <= self::MAX_MOISTURE_CONTENT;

        return ($germPassed && $moisturePassed) ? TestResult::PASSED : TestResult::FAILED;
    }

    // Relations 
    public function seedLot(): BelongsTo
    {
        return $this->belongsTo(SeedLot::class);
    }

    // Activity Log 
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('lab_tests')
            ->setDescriptionForEvent(fn(string $eventName) => "Uji lab untuk lot #{$this->seed_lot_id} di-{$eventName}");
    }
}
