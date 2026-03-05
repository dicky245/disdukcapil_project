<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Roles - HANYA Admin
        $adminRole = Role::firstOrCreate(
            ['name' => 'Admin']
        );

        // Buat User Admin - username lowercase
        $admin = User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
            ]
        );
        $admin->syncRoles([$adminRole->id]);

        $this->command->info('');
        $this->command->info('========================================');
        $this->command->info('✓ User Admin berhasil dibuat!');
        $this->command->info('========================================');
        $this->command->info('');
        $this->command->info('AKUN ADMIN:');
        $this->command->info('  Username: admin');
        $this->command->info('  Password: admin123');
        $this->command->info('========================================');
    }
}
