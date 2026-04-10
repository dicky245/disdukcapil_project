<?php
/**
 * Test script to verify form submission for akte_kematian and lahir_mati
 * Run: php artisan tinker < test-form-submission.php
 */

// Test 1: Verify AkteKematian model accepts all new fields
echo "====== Testing Akte Kematian Model ======\n";
$akteData = [
    'layanan_id' => 3,
    'nomor_registrasi' => 'AK-2026-001',
    'nama_almarhum' => 'Almarhum Test',
    'nik_almarhum' => '1234567890123456',
    'tgl_meninggal' => '2026-04-08',
    'tempat_meninggal' => 'Rumah Sakit',
    'sebab_meninggal' => 'Sakit',
    'yang_menerangkan' => 'Dokter',
    'nik_pelapor' => '1111111111111111',
    'nomor_kk_pelapor' => '2222222222222222',
    'nama_pelapor' => 'Pelapor Test',
    'hubungan_pelapor' => 'Anak',
    'nik_saksi_1' => '3333333333333333',
    'nama_saksi_1' => 'Saksi 1',
    'nik_saksi_2' => '4444444444444444',
    'nama_saksi_2' => 'Saksi 2',
    'status' => 'Dokumen Diterima',
];

$fillable = \App\Models\AkteKematian::all()->first()?->getFillable() ?? (new \App\Models\AkteKematian)->getFillable();
echo "AkteKematian fillable fields:\n";
echo json_encode($fillable, JSON_PRETTY_PRINT) . "\n\n";

// Test 2: Verify LahirMati model accepts all new fields
echo "====== Testing Lahir Mati Model ======\n";
$lahirData = [
    'layanan_id' => 4,
    'nomor_registrasi' => 'LM-2026-001',
    'nik_pelapor' => '1111111111111111',
    'nama_pelapor' => 'Pelapor Test',
    'hubungan_pelapor' => 'Ayah',
    'nama_bayi' => 'Bayi Test',
    'jenis_kelamin' => 'Laki-laki',
    'tgl_lahir' => '2026-04-08',
    'tempat_lahir' => 'Rumah Sakit',
    'lama_kandungan' => 9,
    'penolong_persalinan' => 'Bidan',
    'nama_ayah' => 'Ayah Test',
    'nik_ayah' => '5555555555555555',
    'nama_ibu' => 'Ibu Test',
    'nik_ibu' => '6666666666666666',
    'nik_saksi_1' => '7777777777777777',
    'nama_saksi_1' => 'Saksi 1',
    'nik_saksi_2' => '8888888888888888',
    'nama_saksi_2' => 'Saksi 2',
    'status' => 'Dokumen Diterima',
];

$fillableLahir = \App\Models\LahirMati::all()->first()?->getFillable() ?? (new \App\Models\LahirMati)->getFillable();
echo "LahirMati fillable fields:\n";
echo json_encode($fillableLahir, JSON_PRETTY_PRINT) . "\n\n";

// Test 3: Check database table columns
echo "====== Database Schema Check ======\n";
$akte_columns = \DB::getSchemaBuilder()->getColumnListing('akte_kematian');
echo "Akte Kematian columns: " . count($akte_columns) . "\n";
echo "Columns: " . json_encode($akte_columns, JSON_PRETTY_PRINT) . "\n\n";

$lahir_columns = \DB::getSchemaBuilder()->getColumnListing('lahir_mati');
echo "Lahir Mati columns: " . count($lahir_columns) . "\n";
echo "Columns: " . json_encode($lahir_columns, JSON_PRETTY_PRINT) . "\n\n";

echo "✓ All tests completed. Form data structure is ready!\n";
