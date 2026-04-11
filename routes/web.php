<?php

use App\Http\Controllers\Pengguna_Controller;
use App\Http\Controllers\Antrian_Online_Controller;
use App\Http\Controllers\Auth\Login_Controller;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\Admin_Controller;
use App\Http\Controllers\AkteLahirController;
use App\Http\Controllers\Keagamaan\Keagamaan_Controller;
use App\Http\Controllers\KartKeluargaController;
use App\Http\Controllers\AkteKematianController;
use App\Http\Controllers\LahirMatiController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SecureFileController;
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

// Rute untuk menangkap data form layanan mandiri
Route::post('/layanan-mandiri/akte-kematian', [AkteKematianController::class, 'store'])->name('aktekematian.store');
Route::post('/layanan-mandiri/lahir-mati', [LahirMatiController::class, 'store'])->name('lahirmati.store');

// Antrian Online (Public)
Route::prefix('antrian-online')->group(function () {
    Route::get('/', [Antrian_Online_Controller::class, 'Tampil_Antrian'])->name('antrian-online');
    Route::post('/', [Antrian_Online_Controller::class, 'Tambah_Antrian'])->name('antrian.store');
    Route::get('/cari', [Antrian_Online_Controller::class, 'Cari_Antrian'])->name('antrian.search');
    Route::post('/cari', [Antrian_Online_Controller::class, 'Cari_Antrian_Post'])->name('antrian-online.cari');
    Route::get('/detail/{nomor_antrian}', [Antrian_Online_Controller::class, 'Get_Detail_Antrian'])->name('antrian-online.detail');
    Route::get('/statistik', [Antrian_Online_Controller::class, 'Get_Statistik_Antrian'])->name('antrian.statistik');
    Route::get('/lacak', [Antrian_Online_Controller::class, 'Lacak_Berkas'])->name('antrian.lacak');
    Route::post('/lacak', [Antrian_Online_Controller::class, 'Lacak_Berkas_Post'])->name('antrian-online.lacak');
    Route::get('/get-data/{nomor_antrian}', [Antrian_Online_Controller::class, 'Get_Data_Antrian'])->name('antrian.get-data');
});

// Layanan Mandiri (Public)
Route::prefix('layanan-mandiri')->group(function () {
    Route::get('/', [PageController::class, 'layananMandiri'])->name('layanan-mandiri');
    Route::get('/{jenis_layanan}', [PageController::class, 'formLayanan'])->name('layanan-mandiri.form');
    Route::post('/{jenis_layanan}', [PageController::class, 'submitLayanan'])->name('layanan-mandiri.submit');
});


Route::post('/kk/store/ubah-data', [KartKeluargaController::class, 'store_perubahan_data'])->name('kk.store');
Route::post('/kk/store/ganti-kepala-keluarga', [KartKeluargaController::class, 'store_ganti_kepala_kk'])->name('kk.store.gantikepalakk');
Route::post('/kk/store/kk_hilang_rusak', [KartKeluargaController::class, 'store_kk_hilang_rusak'])->name('kk.store.hilangrusak');
Route::post('/kk/store/pisah_kk', [KartKeluargaController::class, 'store_pisah_kk'])->name('kk.store.pisahkk');

Route::post('/akte-kematian/store', [AkteKematianController::class, 'store'])->name('akte-kematian.store');
Route::post('/lahir-mati/store', [LahirMatiController::class, 'store'])->name('lahir-mati.store');
Route::post('/penerbitan-akte-kelahiran-pengguna/store',[AkteLahirController::class, 'store'])->name('aktelahir.store');
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
| SECURE FILE ROUTES (Authenticated file serving)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('secure-files')->group(function () {
    Route::get('/{path}', [SecureFileController::class, 'serve'])->name('secure-files.serve')->where('path', '.*');
    Route::get('/{path}/info', [SecureFileController::class, 'fileInfo'])->name('secure-files.info')->where('path', '.*');
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATION ROUTES
|--------------------------------------------------------------------------
*/

// Login routes (public access)
Route::get('login', [Login_Controller::class, 'tampilkan_form_login'])->name('login');
Route::post('login', [Login_Controller::class, 'proses_login'])->name('login.submit');

// Logout route - POST only untuk form, redirect GET ke home
Route::get('logout', function() {
    return redirect('/')->with('info', 'Silakan gunakan tombol logout untuk keluar dari sistem.');
})->name('logout.get');

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

    // Admin Registrasi (hanya jika belum ada admin)
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('admin.register');
    Route::post('/register', [RegisterController::class, 'register'])->name('admin.register.submit');

    // Verifikasi Pertanyaan Keamanan
    Route::get('/verify/{user_id}', [Login_Controller::class, 'showVerifyQuestion'])->name('admin.verify.question');
    Route::post('/verify', [RegisterController::class, 'verifySecurityQuestion'])->name('admin.verify.submit');

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
            Route::post('/terima/{uuid}', [Admin_Controller::class, 'Terima_Dokumen'])->name('admin.antrian-online.terima');
            Route::post('/verifikasi/{uuid}', [Admin_Controller::class, 'Verifikasi_Data'])->name('admin.antrian-online.verifikasi');
            Route::post('/cetak/{uuid}', [Admin_Controller::class, 'Proses_Cetak'])->name('admin.antrian-online.cetak');
            Route::post('/selesai/{uuid}', [Admin_Controller::class, 'Siap_Pengambilan'])->name('admin.antrian-online.selesai');
            Route::post('/update-berkas/{uuid}', [Admin_Controller::class, 'Update_Berkas'])->name('admin.antrian-online.update-berkas');
            Route::get('/riwayat/{uuid}', [Admin_Controller::class, 'Get_Riwayat_Berkas'])->name('admin.antrian-online.riwayat');
            Route::delete('/{uuid}', [Admin_Controller::class, 'Hapus_Antrian'])->name('admin.antrian-online.hapus');
        });

        Route::get('/tracking-berkas', [Admin_Controller::class, 'tracking_berkas'])->name('admin.tracking-berkas');
        Route::get('/dokumen-upload', [Admin_Controller::class, 'dokumen_upload'])->name('admin.dokumen-upload');

        // Penerbitan Dokumen
        // Kartu Keluarga
        Route::prefix('penerbitan-kk')->group(function () {
            Route::get('/', [KartKeluargaController::class, 'daftar_kk'])->name('admin.penerbitan-kk');
            Route::get('/detail/{uuid}/{jenis}', [KartKeluargaController::class, 'detail'])->name('admin.detail');
            Route::post('/{uuid}/{jenis}/status', [KartKeluargaController::class, 'updateStatus'])->name('admin.status');
            Route::get('/admin/berkas/{uuid}/{jenis}/lihat/{field}',[KartKeluargaController::class, 'lihatBerkas'])->name('admin.lihat-berkas');
        }); 

        // Penerbitan Akte Kematian
        Route::prefix('penerbitan-akte-kematian')->group(function () {
            Route::get('/', [AkteKematianController::class, 'daftar'])->name('admin.penerbitan-akte-kematian');
            Route::get('/detail/{uuid}', [AkteKematianController::class, 'detail'])->name('admin.akte-kematian.detail');
            Route::post('/{uuid}/status', [AkteKematianController::class, 'updateStatus'])->name('admin.akte-kematian.status');
        });

        // Penerbitan Lahir Mati
        Route::prefix('penerbitan-lahir-mati')->group(function () {
            Route::get('/', [LahirMatiController::class, 'daftar'])->name('admin.penerbitan-lahir-mati');
            Route::get('/detail/{uuid}', [LahirMatiController::class, 'detail'])->name('admin.lahir-mati.detail');
            Route::post('/{uuid}/status', [LahirMatiController::class, 'updateStatus'])->name('admin.lahir-mati.status');
        });

        // Akte Kelahiran
        Route::prefix('penerbitan-akte-lahir')->group(function(){
             Route::get('/', [AkteLahirController::class, 'daftar_aktelahir'])->name('admin.penerbitan-akte-lahir');
             Route::get('/detail/{uuid}',[AkteLahirController::class, 'detail'])->name('admin.detail.aktelahir');
            Route::post('/{uuid}/status',[AkteLahirController::class, 'updateStatus'])->name('admin.status.aktelahir');
        });
        Route::get('/penerbitan-pernikahan', [Admin_Controller::class, 'penerbitan_pernikahan'])->name('admin.penerbitan-pernikahan');
        // Manajemen Akun
       // Ganti admin.manajemen_akun menjadi admin.manajemen-akun
        Route::get('/manajemen-akun', [Admin_Controller::class, 'manajemen_akun'])->name('admin.manajemen-akun');

        // Route untuk memproses simpan (Pastikan NAME ini sama dengan yang ada di ACTION FORM HTML)
        Route::post('/manajemen-akun/store', [Admin_Controller::class, 'store_akun'])->name('admin.manajemen-akun.store');

        // API Routes untuk Admin
        Route::get('/api/total-akun', [Admin_Controller::class, 'getTotalAkun'])->name('admin.api.total-akun');
        Route::get('/api/chart-antrian', [Admin_Controller::class, 'getChartAntrian'])->name('admin.api.chart-antrian');
    
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
    Route::get('/sinkronisasi-dukcapil', [Keagamaan_Controller::class, 'sinkronisasi_dukcapil'])->name('keagamaan.sinkronisasi-dukcapil');
    Route::get('/manajemen-dokumen', [Keagamaan_Controller::class, 'manajemen_dokumen'])->name('keagamaan.manajemen_dokumen');
    Route::get('/lacak-berkas', [Keagamaan_Controller::class, 'lacak_berkas'])->name('keagamaan.lacak_berkas');

    // API Routes untuk Keagamaan
    Route::get('/api/data-keagamaan', [Keagamaan_Controller::class, 'get_data_keagamaan'])->name('keagamaan.api.data_keagamaan');
    Route::post('/api/tambah-keagamaan', [Keagamaan_Controller::class, 'tambah_keagamaan'])->name('keagamaan.api.tambah_keagamaan');
    Route::post('/api/update-keagamaan/{uuid}', [Keagamaan_Controller::class, 'update_keagamaan'])->name('keagamaan.api.update_keagamaan');
    Route::delete('/api/hapus-keagamaan/{uuid}', [Keagamaan_Controller::class, 'hapus_keagamaan'])->name('keagamaan.api.hapus_keagamaan');
    Route::get('/api/jenis-keagamaan', [Keagamaan_Controller::class, 'get_jenis_keagamaan'])->name('keagamaan.api.jenis_keagamaan');

    Route::post('/proses-request-pernikahan', [Keagamaan_Controller::class, 'proses_request_pernikahan'])->name('keagamaan.proses_request_pernikahan');
    Route::post('/sync-data-dukcapil', [Keagamaan_Controller::class, 'sync_data_dukcapil'])->name('keagamaan.sync_data_dukcapil');
    Route::post('/upload-dokumen', [Keagamaan_Controller::class, 'upload_dokumen'])->name('keagamaan.upload_dokumen');
});
