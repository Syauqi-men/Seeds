<?php

namespace App\Observers;

use App\Models\ProductionProcess;

/**
 * Memicu recalculate clean_stock di SeedLot setiap kali
 * ada perubahan pada ProductionProcess.
 */
class ProductionProcessObserver
{
    public function created(ProductionProcess $process): void
    {
        SeedLotObserver::recalculate($process->seedLot);
    }

    public function updated(ProductionProcess $process): void
    {
        SeedLotObserver::recalculate($process->seedLot);
    }

    public function deleted(ProductionProcess $process): void
    {
        $process->seedLot->load('productionProcesses');
        SeedLotObserver::recalculate($process->seedLot);
    }
}
