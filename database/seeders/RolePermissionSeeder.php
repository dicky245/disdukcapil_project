<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            DB::table('model_has_permissions')->delete();
            DB::table('model_has_roles')->delete();
            DB::table('role_has_permissions')->delete();
            Permission::query()->delete();
            Role::query()->delete();
            User::query()->delete();

            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            $permissions = [
                'view berita',
                'create berita',
                'edit berita',
                'delete berita',
                'view organisasi',
                'create organisasi',
                'edit organisasi',
                'delete organisasi',
                'view penghargaan',
                'create penghargaan',
                'edit penghargaan',
                'delete penghargaan',
                'view dasar hukum',
                'create dasar hukum',
                'edit dasar hukum',
                'delete dasar hukum',
                'view statistik',
                'view antrian',
                'create antrian',
                'edit antrian',
                'delete antrian',
                'view konfirmasi status',
                'view pernikahan',
                'create pernikahan',
                'edit pernikahan',
                'delete pernikahan',
                'view sinkronisasi',
                'create sinkronisasi',
                'view dokumen',
                'create dokumen',
                'edit dokumen',
                'delete dokumen',
            ];

            foreach ($permissions as $permission) {
                Permission::create([
                    'name' => $permission,
                    'guard_name' => 'web',
                ]);
            }

            $adminRole = Role::create(['name' => 'Admin', 'guard_name' => 'web']);
            $adminRole->givePermissionTo(Permission::all());

            $keagamaanRole = Role::create(['name' => 'Keagamaan', 'guard_name' => 'web']);
            $keagamaanRole->givePermissionTo([
                'view antrian',
                'create antrian',
                'edit antrian',
                'delete antrian',
                'view pernikahan',
                'create pernikahan',
                'edit pernikahan',
                'delete pernikahan',
                'view sinkronisasi',
                'create sinkronisasi',
                'view dokumen',
                'create dokumen',
                'edit dokumen',
                'delete dokumen',
            ]);

            $admin = User::create([
                'name' => 'Administrator',
                'username' => 'admin',
                'password' => Hash::make('admin123'),
            ]);
            $admin->assignRole($adminRole);

            $this->command->info('');
            $this->command->info('========================================');
            $this->command->info('✓ Role & Permission Berhasil Dibuat!');
            $this->command->info('========================================');
            $this->command->info('');
            $this->command->info('ROLE YANG DIBUAT:');
            $this->command->info('  - Admin (Semua permissions)');
            $this->command->info('  - Keagamaan (Antrian, Pernikahan, Sinkronisasi, Dokumen)');
            $this->command->info('');
            $this->command->info('AKUN ADMIN:');
            $this->command->info('  Username: admin');
            $this->command->info('  Password: admin123');
            $this->command->info('');
            $this->command->info('CATATAN: Akun Keagamaan dapat dibuat oleh Admin');
            $this->command->info('========================================');
        });
    }
}
