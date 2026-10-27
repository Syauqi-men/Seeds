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

        // Migrasi nama role lama ke nama role baru jika sudah ada di database
        $roleRenames = [
            'Petugas Benih'   => 'Seed',
            'Order Processor' => 'Order',
            'Proses Produksi' => 'Production',
        ];
        foreach ($roleRenames as $oldName => $newName) {
            $oldRole = Role::where('name', $oldName)->first();
            $newRole = Role::where('name', $newName)->first();
            if ($oldRole && ! $newRole) {
                $oldRole->update(['name' => $newName]);
            } elseif ($oldRole && $newRole) {
                $oldRole->delete();
            }
        }

        $adminRole      = Role::firstOrCreate(['name' => 'Administrator']);
        $benihRole      = Role::firstOrCreate(['name' => 'Seed']);
        $transaksiRole  = Role::firstOrCreate(['name' => 'Order']);
        $produksiRole   = Role::firstOrCreate(['name' => 'Production']);

        $admin = User::firstOrCreate(
            ['email' => 'admin@brmp.go.id'],
            [
                'name'     => 'Admin',
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

        $produksi = User::firstOrCreate(
            ['email' => 'produksi@brmp.go.id'],
            [
                'name'     => 'Petugas Produksi',
                'password' => Hash::make('Prod1234'),
            ]
        );
        $produksi->syncRoles([$produksiRole]);
    }
}
