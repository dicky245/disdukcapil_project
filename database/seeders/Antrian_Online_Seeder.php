<?php

namespace Database\Seeders;

use App\Models\Antrian_Online_Model;
use App\Models\Lacak_Berkas_Model;
use App\Models\Layanan_Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class Antrian_Online_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $layanan = Layanan_Model::first();

        if (!$layanan) {
            $this->command->warn('Tidak ada layanan ditemukan. Jalankan Layanan_Seeder terlebih dahulu.');
            return;
        }

        $antrian_data = [
            [
                'nomor_antrian' => 'ABC-001-001',
                'nama_lengkap' => 'Budi Santoso',
                'status_antrian' => 'Menunggu',
            ],
            [
                'nomor_antrian' => 'ABC-002-002',
                'nama_lengkap' => 'Siti Aminah',
                'status_antrian' => 'Verifikasi Data',
            ],
            [
                'nomor_antrian' => 'ABC-003-003',
                'nama_lengkap' => 'Ahmad Dahlan',
                'status_antrian' => 'Proses Cetak',
            ],
            [
                'nomor_antrian' => 'ABC-004-004',
                'nama_lengkap' => 'Dewi Sartika',
                'status_antrian' => 'Siap Pengambilan',
            ],
            [
                'nomor_antrian' => 'ABC-005-005',
                'nama_lengkap' => 'Rudi Hartono',
                'status_antrian' => 'Menunggu',
            ],
        ];

        foreach ($antrian_data as $data) {
            // Buat antrian
            $antrian = Antrian_Online_Model::create([
                'nomor_antrian' => $data['nomor_antrian'],
                'nama_lengkap' => $data['nama_lengkap'],
                'layanan_id' => $layanan->layanan_id,
                'status_antrian' => $data['status_antrian'],
            ]);

            // Buat riwayat lacak berkas sesuai status - SINKRON dengan status antrian
            if ($data['status_antrian'] === 'Menunggu') {
                Lacak_Berkas_Model::create([
                    'antrian_online_id' => $antrian->antrian_online_id,
                    'status' => 'Menunggu',
                    'tanggal' => date('Y-m-d'),
                    'keterangan' => 'Antrian berhasil dibuat. Menunggu dokumen diterima oleh admin.',
                ]);
            } elseif ($data['status_antrian'] === 'Verifikasi Data') {
                Lacak_Berkas_Model::create([
                    'antrian_online_id' => $antrian->antrian_online_id,
                    'status' => 'Menunggu',
                    'tanggal' => date('Y-m-d', strtotime('-2 days')),
                    'keterangan' => 'Antrian berhasil dibuat. Menunggu dokumen diterima oleh admin.',
                ]);
                Lacak_Berkas_Model::create([
                    'antrian_online_id' => $antrian->antrian_online_id,
                    'status' => 'Dokumen Diterima',
                    'tanggal' => date('Y-m-d', strtotime('-1 day')),
                    'keterangan' => 'Dokumen diterima, menunggu verifikasi',
                ]);
                Lacak_Berkas_Model::create([
                    'antrian_online_id' => $antrian->antrian_online_id,
                    'status' => 'Verifikasi Data',
                    'tanggal' => date('Y-m-d'),
                    'keterangan' => 'Data sedang diverifikasi oleh admin',
                ]);
            } elseif ($data['status_antrian'] === 'Proses Cetak') {
                Lacak_Berkas_Model::create([
                    'antrian_online_id' => $antrian->antrian_online_id,
                    'status' => 'Menunggu',
                    'tanggal' => date('Y-m-d', strtotime('-4 days')),
                    'keterangan' => 'Antrian berhasil dibuat. Menunggu dokumen diterima oleh admin.',
                ]);
                Lacak_Berkas_Model::create([
                    'antrian_online_id' => $antrian->antrian_online_id,
                    'status' => 'Dokumen Diterima',
                    'tanggal' => date('Y-m-d', strtotime('-3 days')),
                    'keterangan' => 'Dokumen diterima, menunggu verifikasi',
                ]);
                Lacak_Berkas_Model::create([
                    'antrian_online_id' => $antrian->antrian_online_id,
                    'status' => 'Verifikasi Data',
                    'tanggal' => date('Y-m-d', strtotime('-2 days')),
                    'keterangan' => 'Data sedang diverifikasi oleh admin',
                ]);
                Lacak_Berkas_Model::create([
                    'antrian_online_id' => $antrian->antrian_online_id,
                    'status' => 'Proses Cetak',
                    'tanggal' => date('Y-m-d', strtotime('-1 day')),
                    'keterangan' => 'Dokumen sedang dalam proses cetak',
                ]);
            } elseif ($data['status_antrian'] === 'Siap Pengambilan') {
                Lacak_Berkas_Model::create([
                    'antrian_online_id' => $antrian->antrian_online_id,
                    'status' => 'Menunggu',
                    'tanggal' => date('Y-m-d', strtotime('-5 days')),
                    'keterangan' => 'Antrian berhasil dibuat. Menunggu dokumen diterima oleh admin.',
                ]);
                Lacak_Berkas_Model::create([
                    'antrian_online_id' => $antrian->antrian_online_id,
                    'status' => 'Dokumen Diterima',
                    'tanggal' => date('Y-m-d', strtotime('-4 days')),
                    'keterangan' => 'Dokumen diterima, menunggu verifikasi',
                ]);
                Lacak_Berkas_Model::create([
                    'antrian_online_id' => $antrian->antrian_online_id,
                    'status' => 'Verifikasi Data',
                    'tanggal' => date('Y-m-d', strtotime('-3 days')),
                    'keterangan' => 'Data sedang diverifikasi oleh admin',
                ]);
                Lacak_Berkas_Model::create([
                    'antrian_online_id' => $antrian->antrian_online_id,
                    'status' => 'Proses Cetak',
                    'tanggal' => date('Y-m-d', strtotime('-2 days')),
                    'keterangan' => 'Dokumen sedang dalam proses cetak',
                ]);
                Lacak_Berkas_Model::create([
                    'antrian_online_id' => $antrian->antrian_online_id,
                    'status' => 'Siap Pengambilan',
                    'tanggal' => date('Y-m-d', strtotime('-1 day')),
                    'keterangan' => 'Dokumen siap diambil oleh pemohon',
                ]);
            }
        }

        $this->command->info('✓ Berhasil membuat ' . count($antrian_data) . ' data antrian untuk testing');
    }
}
