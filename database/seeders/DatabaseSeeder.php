<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Urutan penting: Admin → Seeds → SeedLots → Processes → LabTests → Transactions
     * StockTransactionSeeder & ProductionProcessSeeder akan memicu SeedLotObserver
     * untuk menghitung raw_stock dan clean_stock secara otomatis.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            SeedSeeder::class,
            SeedLotSeeder::class,
            ProductionProcessSeeder::class,
            LabTestSeeder::class,
            StockTransactionSeeder::class,
        ]);
    }
}
