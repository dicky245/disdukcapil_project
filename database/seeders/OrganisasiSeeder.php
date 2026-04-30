<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganisasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $data = [
        ['kode_posisi' => 'kadis', 'nama_jabatan' => 'Kepala Dinas', 'nama_pejabat' => 'Dr. Johny Simanjuntak, M.Si', 'eselon' => 'Eselon II.b', 'urutan' => 1],
        ['kode_posisi' => 'sekdin', 'nama_jabatan' => 'Sekretaris', 'nama_pejabat' => 'Rina Sari, S.Pd, MM', 'eselon' => 'Eselon III.a', 'urutan' => 2],
        ['kode_posisi' => 'kabid_piak', 'nama_jabatan' => 'Bidang PIAK', 'nama_pejabat' => 'Budi Santoso', 'eselon' => 'Eselon III.a', 'urutan' => 3],
        ['kode_posisi' => 'kabid_dafduk', 'nama_jabatan' => 'Bidang Dafduk', 'nama_pejabat' => 'Siti Aminah', 'eselon' => 'Eselon III.a', 'urutan' => 4],
        ['kode_posisi' => 'kabid_pencatatan', 'nama_jabatan' => 'Bidang Pencatatan Sipil', 'nama_pejabat' => 'Ahmad Rizki', 'eselon' => 'Eselon III.a', 'urutan' => 5],
        ['kode_posisi' => 'kabid_psda', 'nama_jabatan' => 'Bidang PSDA', 'nama_pejabat' => 'Dewi Sartika', 'eselon' => 'Eselon III.a', 'urutan' => 6],
    ];

    foreach ($data as $item) {
        \App\Models\Organisasi::updateOrCreate(['kode_posisi' => $item['kode_posisi']], $item);
    }
}

}
