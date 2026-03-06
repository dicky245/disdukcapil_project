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
            [
                'nama_layanan' => 'Penerbitan Kartu Keluarga Baru',
                'keterangan' => 'Penerbitan Kartu Keluarga (KK) baru untuk penduduk yang belum memiliki KK',
                'estimasi_waktu' => 30,
            ],
            [
                'nama_layanan' => 'Penerbitan Akte Kelahiran',
                'keterangan' => 'Penerbitan Akte Kelahiran untuk bayi yang baru lahir',
                'estimasi_waktu' => 45,
            ],
            [
                'nama_layanan' => 'Penerbitan Akte Kematian',
                'keterangan' => 'Penerbitan Akte Kematian untuk pelaporan kematian penduduk',
                'estimasi_waktu' => 30,
            ],
            [
                'nama_layanan' => 'Penerbitan Akte Lahir Mati',
                'keterangan' => 'Penerbitan Akte Lahir Mati (bayi lahir dalam keadaan meninggal)',
                'estimasi_waktu' => 35,
            ],
            [
                'nama_layanan' => 'Penerbitan Akte Perkawinan',
                'keterangan' => 'Penerbitan Akte Perkawinan untuk pencatatan pernikahan',
                'estimasi_waktu' => 40,
            ],
        ];

        foreach ($data_layanan as $layanan) {
            Layanan_Model::create($layanan);
        }

        $this->command->info('✓ Berhasil membuat ' . count($data_layanan) . ' layanan');
    }
}
