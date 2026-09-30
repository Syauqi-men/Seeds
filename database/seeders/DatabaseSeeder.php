<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            SeedCategorySeeder::class,  
            SeedSeeder::class,
            SeedLotSeeder::class,
            ProductionProcessSeeder::class,
            LabTestSeeder::class,
            StockTransactionSeeder::class,
        ]);
    }
}
