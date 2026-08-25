<?php

namespace Database\Seeders;

use App\Enums\LotStatus;
use App\Models\Seed;
use App\Models\SeedLot;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

/**
 * Format nomor lot baru: NNN-[ABBR KATEGORI]-XX-[KELAS]-[ALIAS LOKASI]-[TH]
 * Contoh: 001-KDL-XX-BS-KP-26
 *
 *   NNN   = nomor urut 3 digit (global, tidak per kategori)
 *   ABBR  = singkatan kategori (KDL / KTH / KHJ)
 *   XX    = kode tanaman (abstrak, belum dikustomisasi)
 *   KELAS = var_class dari varietas (NS/BS/FS/SS)
 *   ALIAS = alias lokasi (KP/JG/NG/MN/GT)
 *   TH    = 2 digit tahun (25 = 2025, 26 = 2026)
 */
class SeedLotSeeder extends Seeder
{
    public function run(): void
    {
        $seeds = Seed::with('category')->get()->keyBy('var_name');
        $counter = 1; // nomor urut global

        $lotsData = [
            // ─── Anjasmoro (Kedelai BS) — 13 lot ────────────────────────────
            ['var' => 'Anjasmoro', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 180, 'status' => LotStatus::Ready],
            ['var' => 'Anjasmoro', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 160, 'status' => LotStatus::Ready],
            ['var' => 'Anjasmoro', 'alias' => 'JG', 'year' => 25, 'harvest_offset' => 140, 'status' => LotStatus::Ready],
            ['var' => 'Anjasmoro', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 120, 'status' => LotStatus::Processing],
            ['var' => 'Anjasmoro', 'alias' => 'NG', 'year' => 25, 'harvest_offset' => 100, 'status' => LotStatus::Processing],
            ['var' => 'Anjasmoro', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 90,  'status' => LotStatus::Processing],
            ['var' => 'Anjasmoro', 'alias' => 'MN', 'year' => 25, 'harvest_offset' => 80,  'status' => LotStatus::Quarantine],
            ['var' => 'Anjasmoro', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 70,  'status' => LotStatus::Quarantine],
            ['var' => 'Anjasmoro', 'alias' => 'JG', 'year' => 25, 'harvest_offset' => 60,  'status' => LotStatus::Raw],
            ['var' => 'Anjasmoro', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 50,  'status' => LotStatus::Raw],
            ['var' => 'Anjasmoro', 'alias' => 'NG', 'year' => 25, 'harvest_offset' => 40,  'status' => LotStatus::Raw],
            ['var' => 'Anjasmoro', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 30,  'status' => LotStatus::Depleted],
            ['var' => 'Anjasmoro', 'alias' => 'KP', 'year' => 26, 'harvest_offset' => 15,  'status' => LotStatus::Raw],

            // ─── Grobogan (Kedelai FS) — 5 lot ──────────────────────────────
            ['var' => 'Grobogan', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 200, 'status' => LotStatus::Ready],
            ['var' => 'Grobogan', 'alias' => 'JG', 'year' => 25, 'harvest_offset' => 160, 'status' => LotStatus::Ready],
            ['var' => 'Grobogan', 'alias' => 'NG', 'year' => 25, 'harvest_offset' => 120, 'status' => LotStatus::Raw],
            ['var' => 'Grobogan', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 90,  'status' => LotStatus::Depleted],
            ['var' => 'Grobogan', 'alias' => 'MN', 'year' => 26, 'harvest_offset' => 20,  'status' => LotStatus::Raw],

            // ─── Dena 1 (Kedelai SS) — 3 lot ────────────────────────────────
            ['var' => 'Dena 1', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 100, 'status' => LotStatus::Processing],
            ['var' => 'Dena 1', 'alias' => 'GT', 'year' => 25, 'harvest_offset' => 80,  'status' => LotStatus::Processing],
            ['var' => 'Dena 1', 'alias' => 'KP', 'year' => 26, 'harvest_offset' => 10,  'status' => LotStatus::Raw],

            // ─── Wilis (Kedelai NS) — 2 lot ──────────────────────────────────
            ['var' => 'Wilis', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 150, 'status' => LotStatus::Ready],
            ['var' => 'Wilis', 'alias' => 'JG', 'year' => 25, 'harvest_offset' => 90,  'status' => LotStatus::Ready],

            // ─── Hypoma 1 (Kacang Tanah BS) — 4 lot ─────────────────────────
            ['var' => 'Hypoma 1', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 120, 'status' => LotStatus::Ready],
            ['var' => 'Hypoma 1', 'alias' => 'NG', 'year' => 25, 'harvest_offset' => 90,  'status' => LotStatus::Processing],
            ['var' => 'Hypoma 1', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 60,  'status' => LotStatus::Raw],
            ['var' => 'Hypoma 1', 'alias' => 'JG', 'year' => 26, 'harvest_offset' => 15,  'status' => LotStatus::Raw],

            // ─── Hypoma 2 (Kacang Tanah FS) — 3 lot ─────────────────────────
            ['var' => 'Hypoma 2', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 110, 'status' => LotStatus::Ready],
            ['var' => 'Hypoma 2', 'alias' => 'MN', 'year' => 25, 'harvest_offset' => 80,  'status' => LotStatus::Ready],
            ['var' => 'Hypoma 2', 'alias' => 'KP', 'year' => 26, 'harvest_offset' => 20,  'status' => LotStatus::Raw],

            // ─── Bima (Kacang Tanah SS) — 2 lot ─────────────────────────────
            ['var' => 'Bima', 'alias' => 'NG', 'year' => 25, 'harvest_offset' => 100, 'status' => LotStatus::Quarantine],
            ['var' => 'Bima', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 70,  'status' => LotStatus::Quarantine],

            // ─── Kancil (Kacang Tanah FS) — 2 lot ───────────────────────────
            ['var' => 'Kancil', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 150, 'status' => LotStatus::Depleted],
            ['var' => 'Kancil', 'alias' => 'GT', 'year' => 25, 'harvest_offset' => 60,  'status' => LotStatus::Raw],

            // ─── Vima 1 (Kacang Hijau BS) — 4 lot ───────────────────────────
            ['var' => 'Vima 1', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 90,  'status' => LotStatus::Ready],
            ['var' => 'Vima 1', 'alias' => 'JG', 'year' => 25, 'harvest_offset' => 70,  'status' => LotStatus::Processing],
            ['var' => 'Vima 1', 'alias' => 'NG', 'year' => 25, 'harvest_offset' => 50,  'status' => LotStatus::Ready],
            ['var' => 'Vima 1', 'alias' => 'KP', 'year' => 26, 'harvest_offset' => 10,  'status' => LotStatus::Raw],

            // ─── Vima 2 (Kacang Hijau FS) — 3 lot ───────────────────────────
            ['var' => 'Vima 2', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 80,  'status' => LotStatus::Ready],
            ['var' => 'Vima 2', 'alias' => 'MN', 'year' => 25, 'harvest_offset' => 60,  'status' => LotStatus::Ready],
            ['var' => 'Vima 2', 'alias' => 'KP', 'year' => 26, 'harvest_offset' => 12,  'status' => LotStatus::Raw],

            // ─── Murai (Kacang Hijau SS) — 2 lot ────────────────────────────
            ['var' => 'Murai', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 120, 'status' => LotStatus::Raw],
            ['var' => 'Murai', 'alias' => 'JG', 'year' => 25, 'harvest_offset' => 70,  'status' => LotStatus::Processing],

            // ─── Kutilang (Kacang Hijau NS) — 2 lot ─────────────────────────
            ['var' => 'Kutilang', 'alias' => 'KP', 'year' => 25, 'harvest_offset' => 200, 'status' => LotStatus::Depleted],
            ['var' => 'Kutilang', 'alias' => 'GT', 'year' => 25, 'harvest_offset' => 90,  'status' => LotStatus::Ready],
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
                    'seed_id'      => $seed->id,
                    'lot_number'   => $lotNumber,
                    'location'     => $alias,
                    'harvest_date' => $item['harvest_offset']
                        ? Carbon::now()->subDays($item['harvest_offset'])->format('Y-m-d')
                        : null,
                    'origin_weight'    => rand(300, 2000) + 0.50,
                    'origin_moisture'  => rand(12, 18) + 0.5,
                    'arrival_weight'   => rand(290, 1990) + 0.20,
                    'arrival_moisture' => rand(11, 17) + 0.3,
                    'status'       => $item['status']->value,
                    'created_at'   => $createdAt,
                    'updated_at'   => $createdAt,
                ]
            );
        }
    }
}
