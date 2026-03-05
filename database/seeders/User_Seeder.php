<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class User_Seeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'Admin']);
        $keagamaanRole = Role::create(['name' => 'Keagamaan']);

        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
        ])->assignRole($adminRole);

        User::create([
            'name' => 'Admin Keagamaan',
            'username' => 'keagamaan',
            'password' => Hash::make('keagamaan123'),
        ])->assignRole($keagamaanRole);

        $this->command->info('✓ Users berhasil dibuat!');
        $this->command->info('  Username: admin | Password: admin123');
        $this->command->info('  Username: keagamaan | Password: keagamaan123');
    }
}
