<?php

use App\Http\Controllers\Auth\Login_Controller;
use App\Http\Controllers\Admin\Admin_Dashboard_Controller;
use App\Http\Controllers\Keagamaan\Keagamaan_Dashboard_Controller;
use App\Http\Controllers\Home_Controller;
use Illuminate\Support\Facades\Route;

// Home page (user dashboard - public view)
Route::get('/', [Home_Controller::class, 'index'])->name('home');

// Halaman profil
Route::get('/profil', [Home_Controller::class, 'profil'])->name('profil');

// Halaman berita
Route::get('/berita', [Home_Controller::class, 'berita'])->name('berita');

// Halaman layanan
Route::get('/layanan', [Home_Controller::class, 'layanan'])->name('layanan');

// Halaman kontak
Route::get('/kontak', [Home_Controller::class, 'kontak'])->name('kontak');

// Login routes
Route::get('login', [Login_Controller::class, 'show_login_form'])->name('login');
Route::post('login', [Login_Controller::class, 'login'])->name('login.post');
Route::post('logout', [Login_Controller::class, 'logout'])->name('logout');

// Admin Dashboard
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [Admin_Dashboard_Controller::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/kelola-berita', [Admin_Dashboard_Controller::class, 'kelola_berita'])->name('admin.kelola_berita');
    Route::get('/organisasi', [Admin_Dashboard_Controller::class, 'organisasi'])->name('admin.organisasi');
    Route::get('/penghargaan', [Admin_Dashboard_Controller::class, 'penghargaan'])->name('admin.penghargaan');
    Route::get('/dasar-hukum', [Admin_Dashboard_Controller::class, 'dasar_hukum'])->name('admin.dasar_hukum');
    Route::get('/statistik', [Admin_Dashboard_Controller::class, 'statistik'])->name('admin.statistik');
    Route::get('/antrian-online', [Admin_Dashboard_Controller::class, 'antrian_online'])->name('admin.antrian_online');
    Route::get('/konfirmasi-status', [Admin_Dashboard_Controller::class, 'konfirmasi_status'])->name('admin.konfirmasi_status');
    Route::get('/kelola-layanan', [Admin_Dashboard_Controller::class, 'kelola_layanan'])->name('admin.kelola_layanan');
    Route::get('/manajemen-akun', [Admin_Dashboard_Controller::class, 'manajemen_akun'])->name('admin.manajemen_akun');
    Route::get('/akun-keagamaan', [Admin_Dashboard_Controller::class, 'akun_keagamaan'])->name('admin.akun_keagamaan');
    Route::get('/penerbitan-kk', [Admin_Dashboard_Controller::class, 'penerbitan_kk'])->name('admin.penerbitan_kk');
    Route::get('/penerbitan-akte-lahir', [Admin_Dashboard_Controller::class, 'penerbitan_akte_lahir'])->name('admin.penerbitan_akte_lahir');
    Route::get('/penerbitan-akte-kematian', [Admin_Dashboard_Controller::class, 'penerbitan_akte_kematian'])->name('admin.penerbitan_akte_kematian');
    Route::get('/penerbitan-lahir-mati', [Admin_Dashboard_Controller::class, 'penerbitan_lahir_mati'])->name('admin.penerbitan_lahir_mati');
    Route::get('/penerbitan-pernikahan', [Admin_Dashboard_Controller::class, 'penerbitan_pernikahan'])->name('admin.penerbitan_pernikahan');
});

// Keagamaan Dashboard
Route::prefix('keagamaan')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [Keagamaan_Dashboard_Controller::class, 'dashboard'])->name('keagamaan.dashboard');
    Route::get('/antrian-kalender', [Keagamaan_Dashboard_Controller::class, 'antrian_kalender'])->name('keagamaan.antrian_kalender');
    Route::get('/sinkronisasi-dukcapil', [Keagamaan_Dashboard_Controller::class, 'sinkronisasi_dukcapil'])->name('keagamaan.sinkronisasi_dukcapil');
    Route::get('/manajemen-dokumen', [Keagamaan_Dashboard_Controller::class, 'manajemen_dokumen'])->name('keagamaan.manajemen_dokumen');
    Route::get('/lacak-berkas', [Keagamaan_Dashboard_Controller::class, 'lacak_berkas'])->name('keagamaan.lacak_berkas');
    Route::post('/proses-request-pernikahan', [Keagamaan_Dashboard_Controller::class, 'proses_request_pernikahan'])->name('keagamaan.proses_request_pernikahan');
    Route::post('/sync-data-dukcapil', [Keagamaan_Dashboard_Controller::class, 'sync_data_dukcapil'])->name('keagamaan.sync_data_dukcapil');
    Route::post('/upload-dokumen', [Keagamaan_Dashboard_Controller::class, 'upload_dokumen'])->name('keagamaan.upload_dokumen');
});
