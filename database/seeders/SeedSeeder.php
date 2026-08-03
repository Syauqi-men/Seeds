<?php

namespace Database\Seeders;

use App\Models\Seed;
use Illuminate\Database\Seeder;

class SeedSeeder extends Seeder
{
    public function run(): void
    {
        $seeds = [
            // === Kedelai (4 varietas, kelas bervariasi) ===
            ['var_name' => 'Anjasmoro',   'var_class' => 'BS', 'category' => 'Kedelai',      'description' => 'Varietas unggul nasional dengan potensi hasil tinggi, berbiji besar.'],
            ['var_name' => 'Grobogan',    'var_class' => 'FS', 'category' => 'Kedelai',      'description' => 'Varietas adaptif lahan sawah tadah hujan, umur genjah.'],
            ['var_name' => 'Dena 1',      'var_class' => 'SS', 'category' => 'Kedelai',      'description' => 'Toleran naungan hingga 50%, cocok untuk tumpang sari.'],
            ['var_name' => 'Wilis',       'var_class' => 'NS', 'category' => 'Kedelai',      'description' => 'Varietas klasik dengan daya adaptasi luas.'],

            // === Kacang Tanah (4 varietas) ===
            ['var_name' => 'Hypoma 1',    'var_class' => 'BS', 'category' => 'Kacang Tanah', 'description' => 'Varietas baru hasil pemuliaan BATAN, toleran kekeringan.'],
            ['var_name' => 'Hypoma 2',    'var_class' => 'FS', 'category' => 'Kacang Tanah', 'description' => 'Kacang tanah tegak, polong besar, produktivitas tinggi.'],
            ['var_name' => 'Bima',        'var_class' => 'SS', 'category' => 'Kacang Tanah', 'description' => 'Hasil polong kering rata-rata 3,4 t/ha.'],
            ['var_name' => 'Kancil',      'var_class' => 'FS', 'category' => 'Kacang Tanah', 'description' => 'Tahan penyakit layu bakteri, cocok lahan kering.'],

            // === Kacang Hijau (4 varietas) ===
            ['var_name' => 'Vima 1',      'var_class' => 'BS', 'category' => 'Kacang Hijau', 'description' => 'Varietas unggul, toleran curah hujan rendah.'],
            ['var_name' => 'Vima 2',      'var_class' => 'FS', 'category' => 'Kacang Hijau', 'description' => 'Umur genjah 55 hari, cocok untuk lahan kering.'],
            ['var_name' => 'Murai',       'var_class' => 'SS', 'category' => 'Kacang Hijau', 'description' => 'Biji besar, kulit polong tidak mudah pecah.'],
            ['var_name' => 'Kutilang',    'var_class' => 'NS', 'category' => 'Kacang Hijau', 'description' => 'Varietas lama dengan adaptasi luas di berbagai agroekosistem.'],
        ];

        foreach ($seeds as $data) {
            Seed::updateOrCreate(
                ['var_name' => $data['var_name'], 'category' => $data['category']],
                $data
            );
        }
    }
}
