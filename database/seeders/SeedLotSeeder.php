<?php

namespace Database\Seeders;

use App\Models\Seed;
use App\Models\SeedLot;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SeedLotSeeder extends Seeder
{
    public function run(): void
    {
        $seeds = Seed::with('category')->get()->keyBy('var_name');
        $counter = 1;

        $lotsData = [
            ['var' => 'Anjasmoro', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 180],
            ['var' => 'Anjasmoro', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 160],
            ['var' => 'Anjasmoro', 'alias' => 'JG', 'year' => 25, 'harvest_offset' => 140],
            ['var' => 'Anjasmoro', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 120],
            ['var' => 'Anjasmoro', 'alias' => 'NG', 'year' => 25, 'harvest_offset' => 100],
            ['var' => 'Anjasmoro', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 90],
            ['var' => 'Anjasmoro', 'alias' => 'MN', 'year' => 25, 'harvest_offset' => 80],
            ['var' => 'Anjasmoro', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 70],
            ['var' => 'Anjasmoro', 'alias' => 'JG', 'year' => 25, 'harvest_offset' => 60],
            ['var' => 'Anjasmoro', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 50],
            ['var' => 'Anjasmoro', 'alias' => 'NG', 'year' => 25, 'harvest_offset' => 40],
            ['var' => 'Anjasmoro', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 30],
            ['var' => 'Anjasmoro', 'alias' => 'KP', 'year' => 26, 'harvest_offset' => 15],

            ['var' => 'Grobogan', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 200],
            ['var' => 'Grobogan', 'alias' => 'JG', 'year' => 25, 'harvest_offset' => 160],
            ['var' => 'Grobogan', 'alias' => 'NG', 'year' => 25, 'harvest_offset' => 120],
            ['var' => 'Grobogan', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 90],
            ['var' => 'Grobogan', 'alias' => 'MN', 'year' => 26, 'harvest_offset' => 20],

            ['var' => 'Dena 1', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 100],
            ['var' => 'Dena 1', 'alias' => 'GT', 'year' => 25, 'harvest_offset' => 80],
            ['var' => 'Dena 1', 'alias' => 'KP', 'year' => 26, 'harvest_offset' => 10],

            ['var' => 'Hypoma 1', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 120],
            ['var' => 'Hypoma 1', 'alias' => 'NG', 'year' => 25, 'harvest_offset' => 90],
            ['var' => 'Hypoma 1', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 60],
            ['var' => 'Hypoma 1', 'alias' => 'JG', 'year' => 26, 'harvest_offset' => 15],

            ['var' => 'Hypoma 2', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 110],
            ['var' => 'Hypoma 2', 'alias' => 'MN', 'year' => 25, 'harvest_offset' => 80],
            ['var' => 'Hypoma 2', 'alias' => 'KP', 'year' => 26, 'harvest_offset' => 20],

            ['var' => 'Bima', 'alias' => 'NG', 'year' => 25, 'harvest_offset' => 100],
            ['var' => 'Bima', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 70],

            ['var' => 'Kancil', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 150],
            ['var' => 'Kancil', 'alias' => 'GT', 'year' => 25, 'harvest_offset' => 60],

            ['var' => 'Vima 1', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 90],
            ['var' => 'Vima 1', 'alias' => 'JG', 'year' => 25, 'harvest_offset' => 70],
            ['var' => 'Vima 1', 'alias' => 'NG', 'year' => 25, 'harvest_offset' => 50],
            ['var' => 'Vima 1', 'alias' => 'KP', 'year' => 26, 'harvest_offset' => 10],

            ['var' => 'Vima 2', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 80],
            ['var' => 'Vima 2', 'alias' => 'MN', 'year' => 25, 'harvest_offset' => 60],
            ['var' => 'Vima 2', 'alias' => 'KP', 'year' => 26, 'harvest_offset' => 12],

            ['var' => 'Murai', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 120],
            ['var' => 'Murai', 'alias' => 'JG', 'year' => 25, 'harvest_offset' => 70],
        ];

        foreach ($lotsData as $item) {
            $seed = $seeds[$item['var']] ?? null;
            if (!$seed) continue;

            $abbr  = strtoupper($seed->category?->abbr ?? 'XX');
            $kelas = $seed->var_class->value;
            $alias = $item['alias'];
            $year2 = str_pad($item['year'], 2, '0', STR_PAD_LEFT);

            $lotNumber = sprintf('%03d-%s-XX-%s-%s-%s', $counter++, $abbr, $kelas, $alias, $year2);

            $createdAt = Carbon::createFromFormat('y', $item['year'])->startOfYear()
                ->addDays(rand(1, 300));

            SeedLot::updateOrCreate(
                ['lot_number' => $lotNumber],
                [
                    'seed_id'          => $seed->id,
                    'lot_number'       => $lotNumber,
                    'location'         => $alias,
                    'harvest_date'     => $item['harvest_offset']
                        ? Carbon::now()->subDays($item['harvest_offset'])->format('Y-m-d')
                        : null,
                    'origin_weight'    => rand(300, 2000) + 0.50,
                    'origin_moisture'  => rand(12, 18) + 0.5,
                    'arrival_weight'   => rand(290, 1990) + 0.20,
                    'arrival_moisture' => rand(11, 17) + 0.3,
                    'created_at'       => $createdAt,
                    'updated_at'       => $createdAt,
                ]
            );
        }
    }
}
