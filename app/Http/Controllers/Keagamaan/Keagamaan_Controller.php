<?php

namespace App\Http\Controllers\Keagamaan;

use App\Http\Controllers\Controller;
use App\Models\Keagamaan_Model;
use App\Models\Jenis_Keagamaan_Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Keagamaan_Controller extends Controller
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
        if (!Auth::user()->hasRole('Keagamaan')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('keagamaan.dashboard');
    }

    /**
     * Tampilkan halaman antrian kalender
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
     * Tampilkan halaman lacak berkas
     */
    public function lacak_berkas()
    {
        if (!Auth::user()->hasRole('Keagamaan')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('keagamaan.lacak_berkas');
    }

    // ==================== API METHODS ====================

    /**
     * Get data keagamaan
     */
    public function get_data_keagamaan(Request $request)
    {
        if (!Auth::user()->hasRole('Keagamaan')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $query = Keagamaan_Model::with(['jenis_keagamaan']);

        // Filter berdasarkan jenis
        if ($request->has('jenis_keagamaan_id') && $request->jenis_keagamaan_id != '') {
            $query->where('jenis_keagamaan_id', $request->jenis_keagamaan_id);
        }

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $data_keagamaan = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $data_keagamaan,
        ]);
    }

    /**
     * Tambah data keagamaan baru
     */
    public function tambah_keagamaan(Request $request)
    {
        if (!Auth::user()->hasRole('Keagamaan')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $validated_data = $request->validate([
            'jenis_keagamaan_id' => 'required|exists:jenis_keagamaan,jenis_keagamaan_id',
            'nama' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $keagamaan = Keagamaan_Model::create([
            'jenis_keagamaan_id' => $validated_data['jenis_keagamaan_id'],
            'nama' => $validated_data['nama'],
            'tanggal' => $validated_data['tanggal'],
            'keterangan' => $validated_data['keterangan'] ?? null,
            'status' => 'Pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data keagamaan berhasil ditambahkan',
            'data' => $keagamaan,
        ], 201);
    }

    /**
     * Update data keagamaan
     */
    public function update_keagamaan(Request $request, $id)
    {
        if (!Auth::user()->hasRole('Keagamaan')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $validated_data = $request->validate([
            'jenis_keagamaan_id' => 'required|exists:jenis_keagamaan,jenis_keagamaan_id',
            'nama' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
            'status' => 'required|string|in:Pending,Proses,Selesai,Ditolak',
        ]);

        $keagamaan = Keagamaan_Model::find($id);

        if (!$keagamaan) {
            return response()->json([
                'success' => false,
                'message' => 'Data keagamaan tidak ditemukan',
            ], 404);
        }

        $keagamaan->update($validated_data);

        return response()->json([
            'success' => true,
            'message' => 'Data keagamaan berhasil diperbarui',
            'data' => $keagamaan,
        ]);
    }

    /**
     * Hapus data keagamaan
     */
    public function hapus_keagamaan($id)
    {
        if (!Auth::user()->hasRole('Keagamaan')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $keagamaan = Keagamaan_Model::find($id);

        if (!$keagamaan) {
            return response()->json([
                'success' => false,
                'message' => 'Data keagamaan tidak ditemukan',
            ], 404);
        }

        $keagamaan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data keagamaan berhasil dihapus',
        ]);
    }

    /**
     * Get jenis keagamaan
     */
    public function get_jenis_keagamaan()
    {
        if (!Auth::user()->hasRole('Keagamaan')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $jenis_keagamaan = Jenis_Keagamaan_Model::all();

        return response()->json([
            'success' => true,
            'data' => $jenis_keagamaan,
        ]);
    }

    /**
     * Proses request pernikahan
     */
    public function proses_request_pernikahan(Request $request)
    {
        if (!Auth::user()->hasRole('Keagamaan')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $validated_data = $request->validate([
            'keagamaan_id' => 'required|exists:keagamaan,keagamaan_id',
            'status' => 'required|string|in:Pending,Proses,Selesai,Ditolak',
            'catatan' => 'nullable|string',
        ]);

        $keagamaan = Keagamaan_Model::find($validated_data['keagamaan_id']);

        if (!$keagamaan) {
            return response()->json([
                'success' => false,
                'message' => 'Data keagamaan tidak ditemukan',
            ], 404);
        }

        $keagamaan->update([
            'status' => $validated_data['status'],
            'keterangan' => $validated_data['catatan'] ?? $keagamaan->keterangan,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Request pernikahan berhasil diproses',
            'data' => $keagamaan,
        ]);
    }

    /**
     * Sinkronisasi data dengan dukcapil
     */
    public function sync_data_dukcapil(Request $request)
    {
        if (!Auth::user()->hasRole('Keagamaan')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        // Simulasi sinkronisasi data
        // Dalam implementasi nyata, ini akan memanggil API dukcapil

        return response()->json([
            'success' => true,
            'message' => 'Sinkronisasi data dukcapil berhasil',
            'data' => [
                'synced_at' => now(),
                'total_records' => 0,
            ],
        ]);
    }

    /**
     * Upload dokumen
     */
    public function upload_dokumen(Request $request)
    {
        if (!Auth::user()->hasRole('Keagamaan')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $validated_data = $request->validate([
            'keagamaan_id' => 'required|exists:keagamaan,keagamaan_id',
            'dokumen' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'jenis_dokumen' => 'required|string|max:50',
        ]);

        // Simpan dokumen
        $file_path = $request->file('dokumen')->store('dokumen_keagamaan', 'public');

        // Dalam implementasi nyata, simpan info dokumen ke tabel terpisah

        return response()->json([
            'success' => true,
            'message' => 'Dokumen berhasil diunggah',
            'data' => [
                'file_path' => $file_path,
                'jenis_dokumen' => $validated_data['jenis_dokumen'],
            ],
        ]);
    }
}
