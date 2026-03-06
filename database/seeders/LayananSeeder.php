<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    DB::table('layanan')->insert([
        [
            'nama_layanan' => 'kartu keluarga',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'nama_layanan' => 'akte kelahiran',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'nama_layanan' => 'akte kematian',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'nama_layanan' => 'lahir mati',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'nama_layanan' => 'pernikahan',
            'created_at' => now(),
            'updated_at' => now()
        ]
    ]);
    }
}
