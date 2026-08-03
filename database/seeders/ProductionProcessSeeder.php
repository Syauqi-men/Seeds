<?php

namespace Database\Seeders;

use App\Models\ProductionProcess;
use App\Models\SeedLot;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProductionProcessSeeder extends Seeder
{
    public function run(): void
    {
        $lots = SeedLot::all();

        foreach ($lots as $lot) {
            // Buat 2-3 proses produksi per lot
            $numProcesses = rand(2, 3);
            for ($i = 0; $i < $numProcesses; $i++) {
                $input    = rand(100, 500) + rand(0, 99) / 100;
                $output   = $input * (rand(85, 98) / 100); // 85-98% recovery rate
                $shrinkage= $input * (rand(1, 8) / 100);
                $waste    = $input - $output - $shrinkage;
                if ($waste < 0) $waste = 0;

                ProductionProcess::create([
                    'seed_lot_id'       => $lot->id,
                    'input_quantity'    => round($input, 2),
                    'output_quantity'   => round($output, 2),
                    'shrinkage_quantity'=> round($shrinkage, 2),
                    'waste_quantity'    => round($waste, 2),
                    'moisture_start'    => rand(14, 20) + rand(0, 9) / 10,
                    'moisture_end'      => rand(11, 13) + rand(0, 9) / 10,
                    'processed_at'      => Carbon::now()->subDays(rand(1, 60)),
                    'notes'             => $i === 0 ? 'Proses pembersihan awal' : 'Proses lanjutan batch ' . ($i + 1),
                ]);
            }
        }
    }
}
