<?php

namespace Database\Seeders;

use App\Enums\TransactionType;
use App\Models\SeedLot;
use App\Models\StockTransaction;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StockTransactionSeeder extends Seeder
{
    public function run(): void
    {
        $lots = SeedLot::all();

        foreach ($lots as $lot) {
            // 3-5 transaksi per lot: minimal satu IN, sisanya mix
            $numTx = rand(3, 5);

            // Transaksi IN pertama (stok masuk)
            StockTransaction::create([
                'seed_lot_id'      => $lot->id,
                'transaction_type' => TransactionType::IN->value,
                'quantity'         => rand(200, 1000) + 0.50,
                'reference_no'     => 'INV-' . strtoupper(substr($lot->lot_number, -6)) . '-001',
                'notes'            => 'Penerimaan stok awal dari panen.',
                'transacted_at'    => Carbon::now()->subDays(rand(60, 150)),
            ]);

            // Transaksi tambahan
            $types = [TransactionType::OUT->value, TransactionType::ADJUSTMENT->value, TransactionType::IN->value];
            for ($i = 1; $i < $numTx; $i++) {
                $type = $types[array_rand($types)];
                $qty  = $type === TransactionType::OUT->value
                    ? rand(10, 100) + 0.00    // keluar: jumlah kecil
                    : rand(-50, 50) + 0.00;   // adjustment: bisa negatif atau positif

                if ($type === TransactionType::IN->value) {
                    $qty = rand(50, 300) + 0.00;
                }

                StockTransaction::create([
                    'seed_lot_id'      => $lot->id,
                    'transaction_type' => $type,
                    'quantity'         => round(abs($qty) ?: 10, 2), // pastikan tidak nol
                    'reference_no'     => 'TRX-' . strtoupper(substr($lot->lot_number, -6)) . '-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                    'notes'            => match($type) {
                        TransactionType::IN->value         => 'Penerimaan stok tambahan.',
                        TransactionType::OUT->value        => 'Pengiriman ke instansi/petani.',
                        TransactionType::ADJUSTMENT->value => 'Penyesuaian stok hasil inventarisasi.',
                    },
                    'transacted_at' => Carbon::now()->subDays(rand(1, 50)),
                ]);
            }
        }
    }
}
