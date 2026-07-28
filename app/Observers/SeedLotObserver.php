<?php

namespace App\Observers;

use App\Enums\TransactionType;
use App\Models\SeedLot;

/**
 * SeedLotObserver — mengupdate raw_stock dan clean_stock di SeedLot
 * setiap kali ada perubahan di StockTransaction atau ProductionProcess.
 *
 * PRD §0.4: snapshot ter-otomasi, kolom ini read-only dari sisi form admin.
 */
class SeedLotObserver
{
    /**
     * Hitung ulang raw_stock dan clean_stock untuk lot tertentu,
     * lalu simpan langsung ke DB tanpa memicu event lagi (updateQuietly).
     */
    public static function recalculate(SeedLot $lot): void
    {
        // raw_stock: total stok mentah berdasarkan transaksi
        // IN  → menambah stok
        // OUT → mengurangi stok
        // ADJUSTMENT → bisa positif atau negatif (quantity bisa minus jika penyesuaian turun)
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

        // updateQuietly mencegah infinite loop (tidak memicu event updated pada SeedLot)
        $lot->updateQuietly([
            'raw_stock'   => max(0, $rawStock),   // tidak boleh negatif
            'clean_stock' => max(0, $cleanStock),
        ]);
    }
}
