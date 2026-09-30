<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache role & permission
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $adminRole      = Role::firstOrCreate(['name' => 'Administrator']);
        $benihRole      = Role::firstOrCreate(['name' => 'Petugas Benih']);
        $transaksiRole  = Role::firstOrCreate(['name' => 'Order Processor']);

        $admin = User::firstOrCreate(
            ['email' => 'admin@brmp.go.id'],
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('Admin123'),
            ]
        );
        $admin->syncRoles([$adminRole]);


        $benih = User::firstOrCreate(
            ['email' => 'benih@brmp.go.id'],
            [
                'name'     => 'Petugas Benih',
                'password' => Hash::make('Benih123'),
            ]
        );
        $benih->syncRoles([$benihRole]);


        $transaksi = User::firstOrCreate(
            ['email' => 'transaksi@brmp.go.id'],
            [
                'name'     => 'Order Processor',
                'password' => Hash::make('Tran1234'),
            ]
        );
        $transaksi->syncRoles([$transaksiRole]);
    }
}
