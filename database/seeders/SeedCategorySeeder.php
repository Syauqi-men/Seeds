<?php

namespace Database\Seeders;

use App\Models\SeedCategory;
use Illuminate\Database\Seeder;

class SeedCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Kedelai',      'abbr' => 'KDL', 'description' => 'Tanaman kedelai (Glycine max)'],
            ['name' => 'Kacang Tanah', 'abbr' => 'KTH', 'description' => 'Tanaman kacang tanah (Arachis hypogaea)'],
            ['name' => 'Kacang Hijau', 'abbr' => 'KHJ', 'description' => 'Tanaman kacang hijau (Vigna radiata)'],
        ];

        foreach ($categories as $data) {
            SeedCategory::updateOrCreate(['name' => $data['name']], $data);
        }
    }
}
