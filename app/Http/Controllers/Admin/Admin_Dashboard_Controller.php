<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin_Dashboard_Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tampilkan dashboard admin
     */
    public function dashboard()
    {
        // Cek apakah user memiliki role Admin
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('admin.dashboard');
    }

    /**
     * Tampilkan halaman kelola berita
     */
    public function kelola_berita()
    {
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('admin.kelola_berita');
    }

    /**
     * Tampilkan halaman organisasi
     */
    public function organisasi()
    {
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('admin.organisasi');
    }

    /**
     * Tampilkan halaman penghargaan
     */
    public function penghargaan()
    {
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('admin.penghargaan');
    }

    /**
     * Tampilkan halaman dasar hukum
     */
    public function dasar_hukum()
    {
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('admin.dasar_hukum');
    }

    /**
     * Tampilkan halaman statistik
     */
    public function statistik()
    {
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('admin.statistik');
    }

    /**
     * Tampilkan halaman antrian online
     */
    public function antrian_online()
    {
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('admin.antrian_online');
    }

    /**
     * Tampilkan halaman konfirmasi status
     */
    public function konfirmasi_status()
    {
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('admin.konfirmasi_status');
    }

    /**
     * Tampilkan halaman kelola layanan
     */
    public function kelola_layanan()
    {
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('admin.kelola_layanan');
    }

    /**
     * Tampilkan halaman manajemen akun
     */
    public function manajemen_akun()
    {
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('admin.manajemen_akun');
    }

    /**
     * Tampilkan halaman akun keagamaan
     */
    public function akun_keagamaan()
    {
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('admin.akun_keagamaan');
    }

    /**
     * Tampilkan halaman penerbitan KK
     */
    public function penerbitan_kk()
    {
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('admin.penerbitan_kk');
    }

    /**
     * Tampilkan halaman penerbitan akte lahir
     */
    public function penerbitan_akte_lahir()
    {
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('admin.penerbitan_akte_lahir');
    }

    /**
     * Tampilkan halaman penerbitan akte kematian
     */
    public function penerbitan_akte_kematian()
    {
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('admin.penerbitan_akte_kematian');
    }

    /**
     * Tampilkan halaman penerbitan lahir mati
     */
    public function penerbitan_lahir_mati()
    {
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('admin.penerbitan_lahir_mati');
    }

    /**
     * Tampilkan halaman penerbitan pernikahan
     */
    public function penerbitan_pernikahan()
    {
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('admin.penerbitan_pernikahan');
    }
}
