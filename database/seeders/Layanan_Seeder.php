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
            ['nama_layanan' => 'PENERBITAN KARTU KELUARGA KARENA PERUBAHAN DATA'],
            ['nama_layanan' => 'PENERBITAN AKTE KELAHIRAN'],
            ['nama_layanan' => 'Penerbitan Akte Kematian'],
            ['nama_layanan' => 'Penerbitan Akte Lahir Mati'],
            ['nama_layanan' => 'Penerbitan Akte Perkawinan'],
            ['nama_layanan' => 'PENERBITAN KARTU KELUARGA BARU KARENA PENGGANTIAN KEPALA KELUARGA (KEMATIAN KEPALA KELUARGA)'],
            ['nama_layanan' => 'PENERBITAN KARTU KELUARGA KARENA HILANG/RUSAK'],
            ['nama_layanan' => 'PENERBITAN KARTU KELUARGA BARU KARENA PISAH KK DALAM 1 (SATU) ALAMAT'],
            
        ];

        foreach ($data_layanan as $layanan) {
            Layanan_Model::create($layanan);
        }

        $this->command->info('✓ Berhasil membuat ' . count($data_layanan) . ' layanan');
    }
}
