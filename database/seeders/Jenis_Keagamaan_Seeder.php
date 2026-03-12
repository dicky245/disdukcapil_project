<?php

namespace Database\Seeders;

use App\Models\Jenis_Keagamaan_Model;
use Illuminate\Database\Seeder;

class Jenis_Keagamaan_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data jenis keagamaan yang sudah ada
        Jenis_Keagamaan_Model::query()->delete();

        $data_jenis_keagamaan = [
            ['nama_jenis_keagamaan' => 'Islam'],
            ['nama_jenis_keagamaan' => 'Kristen Protestan'],
            ['nama_jenis_keagamaan' => 'Kristen Katolik'],
            ['nama_jenis_keagamaan' => 'Hindu'],
            ['nama_jenis_keagamaan' => 'Buddha'],
            ['nama_jenis_keagamaan' => 'Konghucu'],
        ];

        foreach ($data_jenis_keagamaan as $jenis_keagamaan) {
            Jenis_Keagamaan_Model::create($jenis_keagamaan);
        }

        $this->command->info('✓ Berhasil membuat ' . count($data_jenis_keagamaan) . ' jenis keagamaan');
    }
}
