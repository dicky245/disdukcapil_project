<?php

namespace App\Http\Controllers\Keagamaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Keagamaan_Dashboard_Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tampilkan dashboard keagamaan
     */
    public function dashboard()
    {
        // Cek apakah user memiliki role Keagamaan
        if (!Auth::user()->hasRole('Keagamaan')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('keagamaan.dashboard');
    }

    /**
     * Tampilkan halaman antrian dan kalender
     */
    public function antrian_kalender()
    {
        if (!Auth::user()->hasRole('Keagamaan')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('keagamaan.antrian_kalender');
    }

    /**
     * Tampilkan halaman sinkronisasi dukcapil
     */
    public function sinkronisasi_dukcapil()
    {
        if (!Auth::user()->hasRole('Keagamaan')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('keagamaan.sinkronisasi_dukcapil');
    }

    /**
     * Tampilkan halaman manajemen dokumen
     */
    public function manajemen_dokumen()
    {
        if (!Auth::user()->hasRole('Keagamaan')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('keagamaan.manajemen_dokumen');
    }

    /**
     * Lacak berkas pernikahan
     */
    public function lacak_berkas()
    {
        if (!Auth::user()->hasRole('Keagamaan')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('keagamaan.lacak_berkas');
    }

    /**
     * Proses request pernikahan baru
     */
    public function proses_request_pernikahan(Request $request)
    {
        if (!Auth::user()->hasRole('Keagamaan')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        // Validasi input
        $request->validate([
            'nama_pria' => 'required|string',
            'nama_wanita' => 'required|string',
            'tanggal_pernikahan' => 'required|date',
            'tempat_pernikahan' => 'required|string',
        ]);

        // Simpan data pernikahan
        // Logika penyimpanan akan ditambahkan nanti

        return back()->with('success', 'Request pernikahan berhasil diproses');
    }

    /**
     * Sync data ke dukcapil
     */
    public function sync_data_dukcapil(Request $request)
    {
        if (!Auth::user()->hasRole('Keagamaan')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        // Logika sync data ke dukcapil
        // Akan ditambahkan nanti

        return back()->with('success', 'Data berhasil disinkronisasi ke Dukcapil');
    }

    /**
     * Upload dokumen
     */
    public function upload_dokumen(Request $request)
    {
        if (!Auth::user()->hasRole('Keagamaan')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        // Validasi file
        $request->validate([
            'dokumen' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        // Logika upload dokumen
        // Akan ditambahkan nanti

        return back()->with('success', 'Dokumen berhasil diupload');
    }
}
