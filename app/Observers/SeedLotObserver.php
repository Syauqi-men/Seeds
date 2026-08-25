<?php

namespace App\Observers;

use App\Enums\ProcessType;
use App\Enums\TransactionType;
use App\Models\SeedLot;

/**
 * SeedLotObserver — menghitung ulang stok snapshot di SeedLot
 * setiap kali ada perubahan di StockTransaction atau ProductionProcess.
 *
 * Logika stok:
 *   raw_stock    = SUM(IN) - SUM(OUT) + SUM(ADJUSTMENT)     [dari stock_transactions]
 *   clean_stock  = SUM(output_quantity) proses SORTING       [dari production_processes]
 *   graded_stock = SUM(output_quantity) proses GRADING       [dari production_processes]
 */
class SeedLotObserver
{
    public static function recalculate(SeedLot $lot): void
    {
        // ── raw_stock dari transaksi stok ────────────────────────────────
        $inTotal  = $lot->stockTransactions()
            ->where('transaction_type', TransactionType::IN->value)
            ->sum('quantity');

        $outTotal = $lot->stockTransactions()
            ->where('transaction_type', TransactionType::OUT->value)
            ->sum('quantity');

        $adjTotal = $lot->stockTransactions()
            ->where('transaction_type', TransactionType::ADJUSTMENT->value)
            ->sum('quantity');

        $rawStock = (float) $inTotal - (float) $outTotal + (float) $adjTotal;

        // ── clean_stock: output proses Sorting ───────────────────────────
        $cleanStock = (float) $lot->productionProcesses()
            ->where('process_type', ProcessType::Sorting->value)
            ->sum('output_quantity');

        // ── graded_stock: output proses Grading ──────────────────────────
        $gradedStock = (float) $lot->productionProcesses()
            ->where('process_type', ProcessType::Grading->value)
            ->sum('output_quantity');

        // updateQuietly mencegah infinite loop (tidak memicu event updated)
        $lot->updateQuietly([
            'raw_stock'    => max(0, $rawStock),
            'clean_stock'  => max(0, $cleanStock),
            'graded_stock' => max(0, $gradedStock),
        ]);
    }
}
