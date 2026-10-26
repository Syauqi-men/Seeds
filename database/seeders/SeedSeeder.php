<?php

namespace Database\Seeders;

use App\Models\Seed;
use App\Models\SeedCategory;
use Illuminate\Database\Seeder;

class SeedSeeder extends Seeder
{
    public function run(): void
    {
        // Get Category ID from DB(filled by SeedCategorySeeder)
        $cats = SeedCategory::all()->keyBy('name');

        $seeds = [
            ['var_name' => 'Anjasmoro', 'var_class' => 'BS', 'category_id' => $cats['Kedelai']->id,
             'description' => 'Varietas unggul nasional dengan potensi hasil tinggi, berbiji besar.'],
            ['var_name' => 'Grobogan',  'var_class' => 'FS', 'category_id' => $cats['Kedelai']->id,
             'description' => 'Varietas adaptif lahan sawah tadah hujan, umur genjah.'],
            ['var_name' => 'Dena 1',    'var_class' => 'SS', 'category_id' => $cats['Kedelai']->id,
             'description' => 'Toleran naungan hingga 50%, cocok untuk tumpang sari.'],

            ['var_name' => 'Hypoma 1', 'var_class' => 'BS', 'category_id' => $cats['Kacang Tanah']->id,
             'description' => 'Varietas baru hasil pemuliaan BATAN, toleran kekeringan.'],
            ['var_name' => 'Hypoma 2', 'var_class' => 'FS', 'category_id' => $cats['Kacang Tanah']->id,
             'description' => 'Kacang tanah tegak, polong besar, produktivitas tinggi.'],
            ['var_name' => 'Bima',     'var_class' => 'SS', 'category_id' => $cats['Kacang Tanah']->id,
             'description' => 'Hasil polong kering rata-rata 3,4 t/ha.'],
            ['var_name' => 'Kancil',   'var_class' => 'FS', 'category_id' => $cats['Kacang Tanah']->id,
             'description' => 'Tahan penyakit layu bakteri, cocok lahan kering.'],

            ['var_name' => 'Vima 1',   'var_class' => 'BS', 'category_id' => $cats['Kacang Hijau']->id,
             'description' => 'Varietas unggul, toleran curah hujan rendah.'],
            ['var_name' => 'Vima 2',   'var_class' => 'FS', 'category_id' => $cats['Kacang Hijau']->id,
             'description' => 'Umur genjah 55 hari, cocok untuk lahan kering.'],
            ['var_name' => 'Murai',    'var_class' => 'SS', 'category_id' => $cats['Kacang Hijau']->id,
             'description' => 'Biji besar, kulit polong tidak mudah pecah.'],
        ];

        foreach ($seeds as $data) {
            Seed::updateOrCreate(
                ['var_name' => $data['var_name'], 'category_id' => $data['category_id']],
                $data
            );
        }
    }
}
