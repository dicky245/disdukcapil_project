<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Layanan_Model;

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
            ['nama_layanan' => 'Penerbitan Kartu Keluarga Karena Perubahan Data'],
            ['nama_layanan' => 'Penerbitan Akte Kelahiran'],
            ['nama_layanan' => 'Penerbitan Akte Kematian'],
            ['nama_layanan' => 'Penerbitan Akte Lahir Mati'],
            ['nama_layanan' => 'Penerbitan Akte Perkawinan'],
            ['nama_layanan' => 'Penerbitan Kartu Keluarga Baru Karena Penggantian Kepala Keluarga (Kematian Kepala Keluarga)'],
            ['nama_layanan' => 'Penerbitan Kartu Keluarga Karena Hilang/Rusak'],
            ['nama_layanan' => 'Penerbitan Kartu Keluarga Baru Karena Pisah KK Dalam 1 (Satu) Alamat'],
            
        ];

        foreach ($data_layanan as $layanan) {
            Layanan_Model::create($layanan);
        }

        $this->command->info('✓ Berhasil membuat ' . count($data_layanan) . ' layanan');
    }
}
