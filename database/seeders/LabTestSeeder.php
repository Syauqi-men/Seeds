<?php

namespace Database\Seeders;

use App\Enums\TestResult;
use App\Models\LabTest;
use App\Models\SeedLot;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LabTestSeeder extends Seeder
{
    public function run(): void
    {
        $lots = SeedLot::all();

        // Lab test per seed lot
        foreach ($lots as $lot) {
            $numTests = rand(1, 2);
            for ($i = 0; $i < $numTests; $i++) {
                $germRate = rand(72, 98) + rand(0, 9) / 10;
                $result = $germRate >= 80 ? TestResult::PASSED->value : TestResult::FAILED->value;

                LabTest::create([
                    'seed_lot_id'     => $lot->id,
                    'germination_rate'=> round($germRate, 1),
                    'moisture_content'=> rand(10, 14) + rand(0, 9) / 10,
                    'test_result'     => $result,
                    'tested_at'       => Carbon::now()->subDays(rand(5, 90))->format('Y-m-d'),
                    'notes'           => $result === 'PASSED'
                        ? 'Daya kecambah memenuhi standar SNI.'
                        : 'Daya kecambah di bawah standar, perlu pengujian ulang.',
                ]);
            }
        }
    }
}
