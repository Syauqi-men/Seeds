<?php

namespace Database\Seeders;

use App\Enums\ProcessType;
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
                $input     = rand(100, 500) + rand(0, 99) / 100;
                $output    = $input * (rand(85, 98) / 100); // 85-98% recovery rate
                $shrinkage = $input * (rand(1, 8) / 100);
                $waste     = $input - $output - $shrinkage;
                if ($waste < 0) $waste = 0;

                // Pilih jenis proses bergantian: Sorting untuk proses pertama, Grading berikutnya
                $type = $i === 0 ? ProcessType::Sorting : ProcessType::Grading;

                ProductionProcess::create([
                    'seed_lot_id'        => $lot->id,
                    'process_type'       => $type->value,
                    'worker_id'          => null, // tidak diwajibkan
                    'input_quantity'     => round($input, 2),
                    'output_quantity'    => round($output, 2),
                    'sortir_quantity'    => round($shrinkage, 2),
                    'waste_quantity'     => round($waste, 2),
                    'processed_at'       => Carbon::now()->subDays(rand(1, 60))->format('Y-m-d'),
                    'notes'              => $i === 0 ? 'Sortasi awal' : 'Grading batch ' . ($i + 1),
                ]);
            }
        }
    }
}
