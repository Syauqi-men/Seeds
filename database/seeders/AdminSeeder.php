<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@brmp.go.id')],
            [
                'name'              => 'Administrator BRMP',
                'email'             => env('ADMIN_EMAIL', 'admin@brmp.go.id'),
                'password'          => Hash::make(env('ADMIN_PASSWORD', 'admin123')),
                'email_verified_at' => now(),
            ]
        );
    }
}
