<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Antrian_Online_Model;
use App\Models\Lacak_Berkas_Model;
use App\Models\Layanan_Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin_Controller extends Controller
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
     * Tampilkan halaman visualisasi data
     */
    public function visualisasi_data()
    {
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('admin.visualisasi-data');
    }

    /**
     * Tampilkan halaman antrian online
     */
    public function antrian_online()
    {
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('admin.antrian-online-index');
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

    // ==================== ANTRIAN ONLINE FUNCTIONS ====================

    /**
     * Get data antrian online untuk admin
     */
    public function Get_Data_Antrian(Request $request)
    {
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $query = Antrian_Online_Model::with(['layanan', 'lacak_berkas']);

        // Filter berdasarkan status
        if ($request->has('status_antrian') && $request->status_antrian != '') {
            $query->where('status_antrian', $request->status_antrian);
        }

        // Filter berdasarkan layanan
        if ($request->has('layanan_id') && $request->layanan_id != '') {
            $query->where('layanan_id', $request->layanan_id);
        }

        // Filter berdasarkan tanggal
        if ($request->has('tanggal') && $request->tanggal != '') {
            $query->where('tanggal', $request->tanggal);
        }

        $data_antrian = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $data_antrian,
        ]);
    }

    /**
     * Mulai proses antrian
     */
    public function Mulai_Antrian($id)
    {
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $antrian = Antrian_Online_Model::find($id);

        if (!$antrian) {
            return response()->json([
                'success' => false,
                'message' => 'Antrian tidak ditemukan',
            ], 404);
        }

        $antrian->update(['status_antrian' => 'Sedang Diproses']);

        // Tambahkan riwayat lacak berkas
        Lacak_Berkas_Model::create([
            'antrian_online_id' => $antrian->antrian_online_id,
            'status' => 'Sedang Diproses',
            'tanggal' => date('Y-m-d'),
            'keterangan' => 'Antrian mulai diproses oleh admin',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Antrian berhasil diproses',
        ]);
    }

    /**
     * Selesaikan antrian
     */
    public function Selesaikan_Antrian($id)
    {
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $antrian = Antrian_Online_Model::find($id);

        if (!$antrian) {
            return response()->json([
                'success' => false,
                'message' => 'Antrian tidak ditemukan',
            ], 404);
        }

        $antrian->update(['status_antrian' => 'Selesai']);

        // Tambahkan riwayat lacak berkas
        Lacak_Berkas_Model::create([
            'antrian_online_id' => $antrian->antrian_online_id,
            'status' => 'Selesai',
            'tanggal' => date('Y-m-d'),
            'keterangan' => 'Antrian telah selesai diproses',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Antrian berhasil diselesaikan',
        ]);
    }

    /**
     * Update berkas antrian
     */
    public function Update_Berkas(Request $request, $id)
    {
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $request->validate([
            'status' => 'required|string|max:100',
            'keterangan' => 'nullable|string',
        ]);

        $antrian = Antrian_Online_Model::find($id);

        if (!$antrian) {
            return response()->json([
                'success' => false,
                'message' => 'Antrian tidak ditemukan',
            ], 404);
        }

        // Tambahkan riwayat lacak berkas baru
        Lacak_Berkas_Model::create([
            'antrian_online_id' => $antrian->antrian_online_id,
            'status' => $request->status,
            'tanggal' => date('Y-m-d'),
            'keterangan' => $request->keterangan ?? "Status diperbarui: {$request->status}",
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status berkas berhasil diperbarui',
        ]);
    }

    /**
     * Get riwayat lacak berkas
     */
    public function Get_Riwayat_Berkas($id)
    {
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $riwayat_berkas = Lacak_Berkas_Model::where('antrian_online_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $riwayat_berkas,
        ]);
    }

    /**
     * Hapus antrian
     */
    public function Hapus_Antrian($id)
    {
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $antrian = Antrian_Online_Model::find($id);

        if (!$antrian) {
            return response()->json([
                'success' => false,
                'message' => 'Antrian tidak ditemukan',
            ], 404);
        }

        // Hapus semua riwayat lacak berkas terkait
        Lacak_Berkas_Model::where('antrian_online_id', $id)->delete();

        // Hapus antrian
        $antrian->delete();

        return response()->json([
            'success' => true,
            'message' => 'Antrian berhasil dihapus',
        ]);
    }
}
