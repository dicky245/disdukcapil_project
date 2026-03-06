<?php

use App\Http\Controllers\Pengguna_Controller;
use App\Http\Controllers\Antrian_Online_Controller;
use App\Http\Controllers\Auth\Login_Controller;
use App\Http\Controllers\Admin\Admin_Controller;
use App\Http\Controllers\Keagamaan\Keagamaan_Controller;
use App\Http\Controllers\PageController;
use App\Models\Layanan_Model;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (Halaman yang bisa diakses tanpa login)
|--------------------------------------------------------------------------
*/

// Home page - Beranda
Route::get('/', [PageController::class, 'index'])->name('home');

// API Routes untuk layanan (public)
Route::get('/api/layanan', function() {
    $data_layanan = Layanan_Model::all();
    return response()->json([
        'success' => true,
        'data' => $data_layanan,
    ]);
})->name('api.layanan');

// Antrian Online (Public)
Route::prefix('antrian-online')->group(function () {
    Route::get('/', [Antrian_Online_Controller::class, 'Tampil_Antrian'])->name('antrian-online');
    Route::post('/', [Antrian_Online_Controller::class, 'Tambah_Antrian'])->name('antrian.store');
    Route::get('/cari', [Antrian_Online_Controller::class, 'Cari_Antrian'])->name('antrian.search');
    Route::get('/detail/{nomor_antrian}', [Antrian_Online_Controller::class, 'Get_Detail_Antrian'])->name('antrian.detail');
    Route::get('/statistik', [Antrian_Online_Controller::class, 'Get_Statistik_Antrian'])->name('antrian.statistik');
});

// Layanan Mandiri (Public)
Route::prefix('layanan-mandiri')->group(function () {
    Route::get('/', [PageController::class, 'layananMandiri'])->name('layanan-mandiri');
    Route::get('/{jenis_layanan}', [PageController::class, 'formLayanan'])->name('layanan-mandiri.form');
    Route::post('/{jenis_layanan}', [PageController::class, 'submitLayanan'])->name('layanan-mandiri.submit');
});

// Statistik/Data Publik
Route::get('/statistik', [PageController::class, 'statistik'])->name('statistik');

// Halaman profil
Route::get('/profil', [Pengguna_Controller::class, 'profil'])->name('profil');

// Halaman berita
Route::get('/berita', [Pengguna_Controller::class, 'berita'])->name('berita');

// Halaman layanan
Route::get('/layanan', [Pengguna_Controller::class, 'layanan'])->name('layanan');

// Halaman kontak
Route::get('/kontak', [Pengguna_Controller::class, 'kontak'])->name('kontak');

// Halaman tracking/lacak
Route::get('/tracking', [Pengguna_Controller::class, 'tracking'])->name('tracking');

/*
|--------------------------------------------------------------------------
| AUTHENTICATION ROUTES
|--------------------------------------------------------------------------
*/

// Login routes (public access)
Route::get('login', [Login_Controller::class, 'tampilkan_form_login'])->name('login');
Route::post('login', [Login_Controller::class, 'proses_login'])->name('login.submit');
Route::post('logout', [Login_Controller::class, 'proses_logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (Membutuhkan authentication)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {
    // Admin Login (tanpa middleware auth)
    Route::get('/login', [Login_Controller::class, 'adminLoginForm'])->name('admin.login');
    Route::post('/login', [Login_Controller::class, 'adminLogin'])->name('admin.login.submit');

    // Admin Dashboard & Pages (membutuhkan auth)
    Route::middleware(['auth'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [Admin_Controller::class, 'dashboard'])->name('admin.dashboard');

        // Manajemen Konten
        Route::get('/berita', [Admin_Controller::class, 'kelola_berita'])->name('admin.berita');
        Route::get('/organisasi', [Admin_Controller::class, 'organisasi'])->name('admin.organisasi');
        Route::get('/dasar-hukum', [Admin_Controller::class, 'dasar_hukum'])->name('admin.dasar-hukum');
        Route::get('/penghargaan', [Admin_Controller::class, 'penghargaan'])->name('admin.penghargaan');

        // Visualisasi Data
        Route::get('/visualisasi-data', [Admin_Controller::class, 'visualisasi_data'])->name('admin.visualisasi-data');

        // Kelola Layanan
        Route::prefix('antrian-online')->group(function () {
            Route::get('/', [Admin_Controller::class, 'antrian_online'])->name('admin.antrian-online');
            Route::get('/data', [Admin_Controller::class, 'Get_Data_Antrian'])->name('admin.antrian-online.data');
            Route::post('/mulai/{id}', [Admin_Controller::class, 'Mulai_Antrian'])->name('admin.antrian-online.mulai');
            Route::post('/selesai/{id}', [Admin_Controller::class, 'Selesaikan_Antrian'])->name('admin.antrian-online.selesai');
            Route::post('/update-berkas/{id}', [Admin_Controller::class, 'Update_Berkas'])->name('admin.antrian-online.update-berkas');
            Route::get('/riwayat/{id}', [Admin_Controller::class, 'Get_Riwayat_Berkas'])->name('admin.antrian-online.riwayat');
            Route::delete('/{id}', [Admin_Controller::class, 'Hapus_Antrian'])->name('admin.antrian-online.hapus');
        });

        Route::get('/tracking-berkas', [Admin_Controller::class, 'tracking_berkas'])->name('admin.tracking-berkas');
        Route::get('/dokumen-upload', [Admin_Controller::class, 'dokumen_upload'])->name('admin.dokumen-upload');
        Route::get('/konfirmasi-status', [Admin_Controller::class, 'konfirmasi_status'])->name('admin.konfirmasi-status');

        // Penerbitan Dokumen
        Route::get('/penerbitan-kk', [Admin_Controller::class, 'penerbitan_kk'])->name('admin.penerbitan-kk');
        Route::get('/penerbitan-akte-lahir', [Admin_Controller::class, 'penerbitan_akte_lahir'])->name('admin.penerbitan-akte-lahir');
        Route::get('/penerbitan-akte-kematian', [Admin_Controller::class, 'penerbitan_akte_kematian'])->name('admin.penerbitan-akte-kematian');
        Route::get('/penerbitan-lahir-mati', [Admin_Controller::class, 'penerbitan_lahir_mati'])->name('admin.penerbitan-lahir-mati');
        Route::get('/penerbitan-pernikahan', [Admin_Controller::class, 'penerbitan_pernikahan'])->name('admin.penerbitan-pernikahan');

        // Manajemen Akun
        Route::get('/manajemen-akun', [Admin_Controller::class, 'manajemen_akun'])->name('admin.manajemen-akun');
        Route::get('/akun-keagamaan', [Admin_Controller::class, 'akun_keagamaan'])->name('admin.akun-keagamaan');
    });
});

/*
|--------------------------------------------------------------------------
| KEAGAMAAN ROUTES (Untuk petugas keagamaan)
|--------------------------------------------------------------------------
*/

Route::prefix('keagamaan')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [Keagamaan_Controller::class, 'dashboard'])->name('keagamaan.dashboard');
    Route::get('/antrian-kalender', [Keagamaan_Controller::class, 'antrian_kalender'])->name('keagamaan.antrian_kalender');
    Route::get('/sinkronisasi-dukcapil', [Keagamaan_Controller::class, 'sinkronisasi_dukcapil'])->name('keagamaan.sinkronisasi_dukcapil');
    Route::get('/manajemen-dokumen', [Keagamaan_Controller::class, 'manajemen_dokumen'])->name('keagamaan.manajemen_dokumen');
    Route::get('/lacak-berkas', [Keagamaan_Controller::class, 'lacak_berkas'])->name('keagamaan.lacak_berkas');

    // API Routes untuk Keagamaan
    Route::get('/api/data-keagamaan', [Keagamaan_Controller::class, 'get_data_keagamaan'])->name('keagamaan.api.data_keagamaan');
    Route::post('/api/tambah-keagamaan', [Keagamaan_Controller::class, 'tambah_keagamaan'])->name('keagamaan.api.tambah_keagamaan');
    Route::post('/api/update-keagamaan/{id}', [Keagamaan_Controller::class, 'update_keagamaan'])->name('keagamaan.api.update_keagamaan');
    Route::delete('/api/hapus-keagamaan/{id}', [Keagamaan_Controller::class, 'hapus_keagamaan'])->name('keagamaan.api.hapus_keagamaan');
    Route::get('/api/jenis-keagamaan', [Keagamaan_Controller::class, 'get_jenis_keagamaan'])->name('keagamaan.api.jenis_keagamaan');

    Route::post('/proses-request-pernikahan', [Keagamaan_Controller::class, 'proses_request_pernikahan'])->name('keagamaan.proses_request_pernikahan');
    Route::post('/sync-data-dukcapil', [Keagamaan_Controller::class, 'sync_data_dukcapil'])->name('keagamaan.sync_data_dukcapil');
    Route::post('/upload-dokumen', [Keagamaan_Controller::class, 'upload_dokumen'])->name('keagamaan.upload_dokumen');
});
