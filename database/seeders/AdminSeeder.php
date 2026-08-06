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
            ['email' => env('ADMIN_EMAIL', 'example@test.go.id')],
            [
                'name'              => 'Administrator',
                'email'             => env('ADMIN_EMAIL', 'example@test.go.id'),
                'password'          => Hash::make(env('ADMIN_PASSWORD', 'example_pass')),
                'email_verified_at' => now(),
            ]
        );
    }
}
