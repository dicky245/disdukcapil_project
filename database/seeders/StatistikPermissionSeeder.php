<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class StatistikPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Definisikan permission untuk modul statistik
        $permissions = [
            'view statistik',
            'create statistik',
            'edit statistik',
            'delete statistik',
            'export statistik',
            'generate statistik',
        ];

        $createdPermissions = [];
        foreach ($permissions as $permissionName) {
            // Cek apakah permission sudah ada
            $exists = Permission::where('name', $permissionName)
                ->where('guard_name', 'web')
                ->exists();
            
            if (!$exists) {
                $permission = Permission::create([
                    'name' => $permissionName,
                    'guard_name' => 'web',
                ]);
                $createdPermissions[] = $permissionName;
                $this->command->info("Permission '{$permissionName}' berhasil dibuat.");
            } else {
                $this->command->info("Permission '{$permissionName}' sudah ada.");
            }
        }

        // Assign semua permission ke role Admin (role_id = 1)
        $adminRole = Role::findById(1); // Admin role
        
        if ($adminRole) {
            foreach ($permissions as $permissionName) {
                $permission = Permission::where('name', $permissionName)
                    ->where('guard_name', 'web')
                    ->first();
                
                if ($permission) {
                    // Cek apakah sudah assign
                    $exists = DB::table('role_has_permissions')
                        ->where('role_id', 1)
                        ->where('permission_id', $permission->id)
                        ->exists();
                    
                    if (!$exists) {
                        $adminRole->givePermissionTo($permission);
                    }
                }
            }
            $this->command->info("Semua permission statistik diberikan ke role Admin.");
        } else {
            $this->command->warn("Role Admin (ID=1) tidak ditemukan. Pastikan RoleSeeder sudah dijalankan.");
        }

        // Assign permission ke role Keclesiastical (jika ada)
        $keclesiasticalRole = Role::where('name', 'Keclesiastical')->first();
        if ($keclesiasticalRole) {
            $viewExportPerms = ['view statistik', 'create statistik', 'export statistik'];
            foreach ($viewExportPerms as $permName) {
                $permission = Permission::where('name', $permName)
                    ->where('guard_name', 'web')
                    ->first();
                
                if ($permission) {
                    $exists = DB::table('role_has_permissions')
                        ->where('role_id', $keclesiasticalRole->id)
                        ->where('permission_id', $permission->id)
                        ->exists();
                    
                    if (!$exists) {
                        $keclesiasticalRole->givePermissionTo($permission);
                    }
                }
            }
            $this->command->info("Permission view/export diberikan ke role Keclesiastical.");
        }
    }
}
