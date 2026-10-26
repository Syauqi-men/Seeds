<?php

namespace Database\Seeders;

use App\Enums\WorkerRole;
use App\Models\Worker;
use Illuminate\Database\Seeder;

class WorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $workers = [
            [
                'code'      => 'BS',
                'name'      => 'Bambang Supriyanto',
                'role'      => WorkerRole::Sorting,
                'is_active' => true,
                'notes'     => 'Operator sortasi benih gudang utama',
            ],
            [
                'code'      => 'SR',
                'name'      => 'Siti Rahmawati',
                'role'      => WorkerRole::Sorting,
                'is_active' => true,
                'notes'     => 'Petugas sortasi benih kedelai',
            ],
            [
                'code'      => 'SW',
                'name'      => 'Sri Wahyuni',
                'role'      => WorkerRole::Sorting,
                'is_active' => true,
                'notes'     => 'Petugas pembersihan dan sortasi manual',
            ],
            [
                'code'      => 'DK',
                'name'      => 'Dedi Kurniawan',
                'role'      => WorkerRole::Grading,
                'is_active' => true,
                'notes'     => 'Operator mesin grading benih',
            ],
            [
                'code'      => 'AS',
                'name'      => 'Agus Santoso',
                'role'      => WorkerRole::Grading,
                'is_active' => true,
                'notes'     => 'Operator grading kacang tanah',
            ],
            [
                'code'      => 'HP',
                'name'      => 'Hendra Pratama',
                'role'      => WorkerRole::Grading,
                'is_active' => true,
                'notes'     => 'Operator mesin ayakan grading',
            ],
            [
                'code'      => 'JW',
                'name'      => 'Joko Widodo',
                'role'      => WorkerRole::Both,
                'is_active' => true,
                'notes'     => 'Koordinator sortasi dan grading shift pagi',
            ],
            [
                'code'      => 'NH',
                'name'      => 'Nur Hidayah',
                'role'      => WorkerRole::Both,
                'is_active' => true,
                'notes'     => 'Tenaga teknis pengolahan benih',
            ],
        ];

        foreach ($workers as $worker) {
            Worker::updateOrCreate(
                ['code' => $worker['code']],
                $worker
            );
        }
    }
}
