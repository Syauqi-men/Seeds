<?php

namespace App\Observers;

use App\Models\StockTransaction;

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
        $transaction->seedLot->load('stockTransactions');
        SeedLotObserver::recalculate($transaction->seedLot);
    }
}
