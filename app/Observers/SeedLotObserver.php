<?php

namespace App\Observers;

use App\Enums\ProcessType;
use App\Models\OrderItemAllocation;
use App\Models\SeedLot;
use App\Models\SeedMutation;

class SeedLotObserver
{
    public static function recalculate(SeedLot $lot): void
    { 
        $gradingInput  = (float) $lot->productionProcesses()
            ->where('process_type', ProcessType::Grading->value)
            ->sum('input_quantity');

        $gradingOutput = (float) $lot->productionProcesses()
            ->where('process_type', ProcessType::Grading->value)
            ->sum('output_quantity');

        $sortingInput  = (float) $lot->productionProcesses()
            ->where('process_type', ProcessType::Sorting->value)
            ->sum('input_quantity');

        $sortingOutput = (float) $lot->productionProcesses()
            ->where('process_type', ProcessType::Sorting->value)
            ->sum('output_quantity');

        // Pengeluaran dari pesanan yang sudah berstatus completed
        $completedAllocations = (float) OrderItemAllocation::where('seed_lot_id', $lot->id)
            ->whereHas('orderItem.order', fn($q) => $q->where('status', 'completed'))
            ->sum('alloc_quantity');

        // Pengeluaran sampel mutasi benih (2 kg per mutasi)
        $mutationDeductions = (float) SeedMutation::where('seed_lot_id', $lot->id)->count() * 2;

        $rawStock    = max(0, (float) ($lot->arrival_weight ?? 0) - $gradingInput);
        $gradedStock = max(0, $gradingOutput - $sortingInput);
        $cleanStock  = max(0, $sortingOutput - $completedAllocations - $mutationDeductions);

        $lot->updateQuietly([
            'raw_stock'    => $rawStock,
            'graded_stock' => $gradedStock,
            'clean_stock'  => $cleanStock,
        ]);
    }
}
