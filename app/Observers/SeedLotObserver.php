<?php

namespace App\Observers;

use App\Enums\ProcessType;
use App\Models\SeedLot;

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

        $rawStock    = max(0, (float) ($lot->arrival_weight ?? 0) - $gradingInput);
        $gradedStock = max(0, $gradingOutput - $sortingInput);
        $cleanStock  = max(0, $sortingOutput);

        $lot->updateQuietly([
            'raw_stock'    => $rawStock,
            'graded_stock' => $gradedStock,
            'clean_stock'  => $cleanStock,
        ]);
    }
}
