<?php

namespace Database\Seeders;

use App\Enums\LotStatus;
use App\Models\Seed;
use App\Models\SeedLot;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SeedLotSeeder extends Seeder
{
    public function run(): void
    {
        $seeds = Seed::all()->keyBy('var_name');

        $lots = [];

        // ─── Anjasmoro: 13 lot (lebih dari 10 untuk uji pagination PRD §0.9) ───────
        for ($i = 1; $i <= 13; $i++) {
            $status = match(true) {
                $i <= 3  => LotStatus::Ready,
                $i <= 6  => LotStatus::Processing,
                $i <= 8  => LotStatus::Quarantine,
                $i <= 11 => LotStatus::Raw,
                default  => LotStatus::Depleted,
            };
            $lots[] = [
                'seed_id'     => $seeds['Anjasmoro']->id,
                'lot_number'  => sprintf('LOT-KDL-2025-%03d', $i),
                'harvest_date'=> Carbon::now()->subDays(rand(30, 180))->format('Y-m-d'),
                'origin_weight'   => rand(500, 2000) + 0.50,
                'origin_moisture' => rand(12, 18) + 0.5,
                'arrival_weight'  => rand(490, 1990) + 0.20,
                'arrival_moisture'=> rand(11, 17) + 0.3,
                'status'     => $status->value,
            ];
        }

        // ─── Grobogan: 5 lot ────────────────────────────────────────────────────────
        for ($i = 1; $i <= 5; $i++) {
            $lots[] = [
                'seed_id'      => $seeds['Grobogan']->id,
                'lot_number'   => sprintf('LOT-KDL-2025-%03d', 20 + $i),
                'harvest_date' => Carbon::now()->subDays(rand(60, 200))->format('Y-m-d'),
                'origin_weight'=> rand(300, 1500) + 0.00,
                'status'       => collect([LotStatus::Ready, LotStatus::Raw, LotStatus::Depleted])->random()->value,
            ];
        }

        // ─── Dena 1: 3 lot ──────────────────────────────────────────────────────────
        for ($i = 1; $i <= 3; $i++) {
            $lots[] = [
                'seed_id'    => $seeds['Dena 1']->id,
                'lot_number' => sprintf('LOT-KDL-2025-%03d', 30 + $i),
                'status'     => LotStatus::Processing->value,
            ];
        }

        // ─── Wilis: 2 lot ───────────────────────────────────────────────────────────
        for ($i = 1; $i <= 2; $i++) {
            $lots[] = [
                'seed_id'    => $seeds['Wilis']->id,
                'lot_number' => sprintf('LOT-KDL-2025-%03d', 40 + $i),
                'status'     => LotStatus::Ready->value,
            ];
        }

        // ─── Kacang Tanah: Hypoma 1 (4 lot) ─────────────────────────────────────────
        for ($i = 1; $i <= 4; $i++) {
            $lots[] = [
                'seed_id'      => $seeds['Hypoma 1']->id,
                'lot_number'   => sprintf('LOT-KTH-2025-%03d', $i),
                'harvest_date' => Carbon::now()->subDays(rand(30, 120))->format('Y-m-d'),
                'origin_weight'=> rand(400, 1200) + 0.50,
                'status'       => collect([LotStatus::Ready, LotStatus::Processing, LotStatus::Raw])->random()->value,
            ];
        }

        // ─── Hypoma 2: 3 lot ────────────────────────────────────────────────────────
        for ($i = 1; $i <= 3; $i++) {
            $lots[] = [
                'seed_id'    => $seeds['Hypoma 2']->id,
                'lot_number' => sprintf('LOT-KTH-2025-%03d', 10 + $i),
                'status'     => LotStatus::Ready->value,
            ];
        }

        // ─── Bima: 2 lot ────────────────────────────────────────────────────────────
        for ($i = 1; $i <= 2; $i++) {
            $lots[] = [
                'seed_id'    => $seeds['Bima']->id,
                'lot_number' => sprintf('LOT-KTH-2025-%03d', 20 + $i),
                'status'     => LotStatus::Quarantine->value,
            ];
        }

        // ─── Kancil: 2 lot ──────────────────────────────────────────────────────────
        $lots[] = [
            'seed_id'    => $seeds['Kancil']->id,
            'lot_number' => 'LOT-KTH-2025-030',
            'status'     => LotStatus::Depleted->value,
        ];
        $lots[] = [
            'seed_id'    => $seeds['Kancil']->id,
            'lot_number' => 'LOT-KTH-2025-031',
            'status'     => LotStatus::Raw->value,
        ];

        // ─── Kacang Hijau: Vima 1 (4 lot) ───────────────────────────────────────────
        for ($i = 1; $i <= 4; $i++) {
            $lots[] = [
                'seed_id'      => $seeds['Vima 1']->id,
                'lot_number'   => sprintf('LOT-KHJ-2025-%03d', $i),
                'harvest_date' => Carbon::now()->subDays(rand(20, 90))->format('Y-m-d'),
                'status'       => collect([LotStatus::Ready, LotStatus::Processing])->random()->value,
            ];
        }

        // ─── Vima 2: 3 lot ──────────────────────────────────────────────────────────
        for ($i = 1; $i <= 3; $i++) {
            $lots[] = [
                'seed_id'    => $seeds['Vima 2']->id,
                'lot_number' => sprintf('LOT-KHJ-2025-%03d', 10 + $i),
                'status'     => LotStatus::Ready->value,
            ];
        }

        // ─── Murai: 2 lot, Kutilang: 2 lot ──────────────────────────────────────────
        $lots[] = ['seed_id' => $seeds['Murai']->id,   'lot_number' => 'LOT-KHJ-2025-020', 'status' => LotStatus::Raw->value];
        $lots[] = ['seed_id' => $seeds['Murai']->id,   'lot_number' => 'LOT-KHJ-2025-021', 'status' => LotStatus::Processing->value];
        $lots[] = ['seed_id' => $seeds['Kutilang']->id,'lot_number' => 'LOT-KHJ-2025-030', 'status' => LotStatus::Depleted->value];
        $lots[] = ['seed_id' => $seeds['Kutilang']->id,'lot_number' => 'LOT-KHJ-2025-031', 'status' => LotStatus::Ready->value];

        foreach ($lots as $lotData) {
            SeedLot::updateOrCreate(
                ['lot_number' => $lotData['lot_number']],
                $lotData
            );
        }
    }
}
