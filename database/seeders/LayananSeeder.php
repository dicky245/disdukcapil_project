<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('layanan')->insert([
            [
                'layanan_id' => (string) Str::uuid(),
                'nama_layanan' => 'Penerbitan Kartu Keluarga',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'layanan_id' => (string) Str::uuid(),
                'nama_layanan' => 'Penerbitan Akte Lahir',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'layanan_id' => (string) Str::uuid(),
                'nama_layanan' => 'Penerbitan Akte Kematian',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'layanan_id' => (string) Str::uuid(),
                'nama_layanan' => 'Penerbitan Lahir Mati',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'layanan_id' => (string) Str::uuid(),
                'nama_layanan' => 'Penerbitan Pernikahan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
