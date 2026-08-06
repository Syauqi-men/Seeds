<?php

namespace App\Observers;

use App\Models\ProductionProcess;
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
