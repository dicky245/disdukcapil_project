<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            Jenis_Keagamaan_Seeder::class,
            LayananSeeder::class,
            Antrian_Online_Seeder::class,
            Status_Lacak_Berkas_Seeder::class,
        ]);
    }
}
