<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisKeagamaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agama = [
            ['nama_jenis_keagamaan' => 'Kristen Protestan', 'keterangan' => 'Pelayanan Kristen Protestan'],
            ['nama_jenis_keagamaan' => 'Katolik', 'keterangan' => 'Pelayanan Katolik'],
            ['nama_jenis_keagamaan' => 'Islam', 'keterangan' => 'Pelayanan Islam'],
            ['nama_jenis_keagamaan' => 'Buddha', 'keterangan' => 'Pelayanan Buddha'],
            ['nama_jenis_keagamaan' => 'Hindu', 'keterangan' => 'Pelayanan Hindu'],
        ];

        foreach ($agama as $a) {
            \App\Models\Jenis_Keagamaan_Model::create($a);
        }
    }
}
