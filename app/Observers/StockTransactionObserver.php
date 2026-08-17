<?php

namespace App\Observers;

use App\Models\StockTransaction;

/**
 * Memicu recalculate raw_stock di SeedLot setiap kali
 * ada perubahan pada StockTransaction.
 */
class StockTransactionObserver
{
    public function created(StockTransaction $transaction): void
    {
        SeedLotObserver::recalculate($transaction->seedLot);
    }

    public function updated(StockTransaction $transaction): void
    {
        SeedLotObserver::recalculate($transaction->seedLot);
    }

    public function deleted(StockTransaction $transaction): void
    {
        // Refresh relasi agar hitungan tidak pakai cache query lama
        $transaction->seedLot->load('stockTransactions');
        SeedLotObserver::recalculate($transaction->seedLot);
    }
}
