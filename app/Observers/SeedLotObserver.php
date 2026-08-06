<?php

namespace App\Observers;

use App\Enums\TransactionType;
use App\Models\SeedLot;

class SeedLotObserver
{
    public static function recalculate(SeedLot $lot): void
    {
        $inTotal = $lot->stockTransactions()
            ->where('transaction_type', TransactionType::IN->value)
            ->sum('quantity');

        $outTotal = $lot->stockTransactions()
            ->where('transaction_type', TransactionType::OUT->value)
            ->sum('quantity');

        $adjustmentTotal = $lot->stockTransactions()
            ->where('transaction_type', TransactionType::ADJUSTMENT->value)
            ->sum('quantity');

        $rawStock = (float) $inTotal - (float) $outTotal + (float) $adjustmentTotal;

        // clean_stock: total output dari semua proses produksi yang selesai
        $cleanStock = (float) $lot->productionProcesses()->sum('output_quantity');

        // updateQuietly mencegah infinite loop 
        $lot->updateQuietly([
            'raw_stock'   => max(0, $rawStock),   
            'clean_stock' => max(0, $cleanStock),
        ]);
    }
}
