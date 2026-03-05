<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class Debug_Auth_Command extends Command
{
    protected $signature = 'debug:auth';

    protected $description = 'Debug sistem authentication secara menyeluruh';

    public function handle()
    {
        $this->info('========================================');
        $this->info('     DEBUG SISTEM AUTHENTICATION');
        $this->info('========================================');
        $this->newLine();

        // 1. Cek Database
        $this->info('1. KONEKSI DATABASE');
        try {
            $dbName = DB::connection()->getDatabaseName();
            $this->line("   Database: <info>{$dbName}</info>");
        } catch (\Exception $e) {
            $this->error("   Error: {$e->getMessage()}");
            return Command::FAILURE;
        }
        $this->newLine();

        // 2. Cek Users
        $this->info('2. USERS DI DATABASE');
        $users = User::all(['id', 'username', 'name']);
        if ($users->isEmpty()) {
            $this->error('   Tidak ada user di database!');
        } else {
            foreach ($users as $u) {
                $this->line("   ID: {$u->id}");
                $this->line("   Username: <info>{$u->username}</info>");
                $this->line("   Name: {$u->name}");
                $this->newLine();
            }
        }

        // 3. Cek Roles
        $this->info('3. ROLES DI DATABASE');
        $roles = Role::all(['id', 'name']);
        if ($roles->isEmpty()) {
            $this->error('   Tidak ada role di database!');
        } else {
            foreach ($roles as $r) {
                $this->line("   - <info>{$r->name}</info>");
            }
        }
        $this->newLine();

        // 4. Cek User-Role Relationships
        $this->info('4. USER-ROLE RELATIONSHIPS');
        $usersWithRoles = User::with('roles')->get();
        foreach ($usersWithRoles as $u) {
            $roleNames = $u->roles->pluck('name')->implode(', ');
            if (empty($roleNames)) {
                $this->error("   {$u->username} -> TIDAK PUNYA ROLE!");
            } else {
                $this->line("   <info>{$u->username}</info> -> Roles: {$roleNames}");
            }
        }
        $this->newLine();

        // 5. Test Password
        $this->info('5. VERIFIKASI PASSWORD');
        $admin = User::where('username', 'admin')->first();
        if ($admin) {
            $valid = Hash::check('admin123', $admin->password);
            if ($valid) {
                $this->line("   Admin (admin/admin123): <info>VALID ✓</info>");
            } else {
                $this->error("   Admin (admin/admin123): INVALID ✗");
            }
        } else {
            $this->error("   User 'admin' tidak ditemukan!");
        }

        $keagamaan = User::where('username', 'keagamaan')->first();
        if ($keagamaan) {
            $valid = Hash::check('keagamaan123', $keagamaan->password);
            if ($valid) {
                $this->line("   Keagamaan (keagamaan/keagamaan123): <info>VALID ✓</info>");
            } else {
                $this->error("   Keagamaan (keagamaan/keagamaan123): INVALID ✗");
            }
        } else {
            $this->error("   User 'keagamaan' tidak ditemukan!");
        }
        $this->newLine();

        // 6. Test Authentication Logic
        $this->info('6. TEST MANUAL AUTHENTICATION');
        $testUser = User::where('username', 'admin')->first();
        if ($testUser && Hash::check('admin123', $testUser->password)) {
            $this->line("   Manual authentication untuk admin: <info>SUCCESS ✓</info>");
            $this->line("   User bisa login dengan username=admin, password=admin123");
        } else {
            $this->error("   Manual authentication FAILED ✗");
        }
        $this->newLine();

        $this->info('========================================');
        $this->info('           DEBUG SELESAI');
        $this->info('========================================');

        return Command::SUCCESS;
    }
}
