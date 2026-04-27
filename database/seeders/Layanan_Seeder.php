<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Layanan_Model;
use Illuminate\Support\Str;

class Layanan_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data layanan yang sudah ada
        Layanan_Model::query()->delete();

        $data_layanan = [
            ['layanan_id' => (string) Str::uuid(), 'nama_layanan' => 'Penerbitan Kartu Keluarga Karena Perubahan Data'],
            ['layanan_id' => (string) Str::uuid(), 'nama_layanan' => 'Penerbitan Akte Kelahiran'],
            ['layanan_id' => (string) Str::uuid(), 'nama_layanan' => 'Penerbitan Akte Kematian'],
            ['layanan_id' => (string) Str::uuid(), 'nama_layanan' => 'Penerbitan Akte Lahir Mati'],
            ['layanan_id' => (string) Str::uuid(), 'nama_layanan' => 'Penerbitan Akte Perkawinan'],
            ['layanan_id' => (string) Str::uuid(), 'nama_layanan' => 'Penerbitan Kartu Keluarga Baru Karena Penggantian Kepala Keluarga (Kematian Kepala Keluarga)'],
            ['layanan_id' => (string) Str::uuid(), 'nama_layanan' => 'Penerbitan Kartu Keluarga Karena Hilang/Rusak'],
            ['layanan_id' => (string) Str::uuid(), 'nama_layanan' => 'Penerbitan Kartu Keluarga Baru Karena Pisah KK Dalam 1 (Satu) Alamat'],
            
        ];

        foreach ($data_layanan as $layanan) {
            Layanan_Model::create($layanan);
        }

        $this->command->info('✓ Berhasil membuat ' . count($data_layanan) . ' layanan');
    }
}
