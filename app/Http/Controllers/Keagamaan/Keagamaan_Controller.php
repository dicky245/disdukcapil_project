<?php

namespace App\Http\Controllers\Keagamaan;

use App\Http\Controllers\Controller;
use App\Models\Keagamaan_Model;
use App\Models\Jenis_Keagamaan_Model;
use App\Exceptions\DatabaseException;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

// Import Model
use App\Models\Layanan_Model;
use App\Models\Lacak_Berkas_Model;
use App\Models\Antrian_Online_Model;

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

        $antrian = Antrian_Online_Model::with(['lacak_berkas', 'layanan'])
            ->latest()
            ->get();

        $stats = [
            'hari_ini' => $antrian->where('created_at', '>=', now()->startOfDay())->count(),
            'menunggu' => $antrian->where('status_antrian', 'Menunggu')->count(),
            'diterima' => $antrian->where('status_antrian', 'Sedang Diproses')->count(),
            'ditolak'  => $antrian->where('status_antrian', 'Dibatalkan')->count(),
            'total'    => $antrian->count()
        ];

        // Kirim variabel $antrian ke view
        return view('keagamaan.antrian_kalender', compact('antrian', 'stats'));
    }

    /**
     * Tampilkan halaman sinkronisasi dukcapil
     */
    public function sinkronisasi_dukcapil()
    {
        if (!Auth::user()->hasRole('Keagamaan')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('keagamaan.sinkronisasi-dukcapil');
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
        // Validasi Akses Role Keagamaan
        if (!Auth::user()->hasRole('Keagamaan')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        // 1. Ambil ID terakhir dari setiap antrian agar tidak duplikat (History Terkini)
        $latestLacakIds = Lacak_Berkas_Model::selectRaw('MAX(lacak_berkas_id) as id')
            ->groupBy('antrian_online_id')
            ->pluck('id');

        // 2. Filter data berdasarkan skema tabel yang Anda miliki
        $berkas = Lacak_Berkas_Model::with(['antrian_online.layanan', 'antrian_online.user'])
            ->whereIn('lacak_berkas_id', $latestLacakIds)

            /* PENYESUAIAN: 
           Karena di migration Anda tidak ada 'detail_form', 
           kita gunakan 'keterangan' atau hapus baris ini jika tidak ingin memfilter kolom kosong.
        */
            ->whereNotNull('keterangan')

            ->whereHas('antrian_online.layanan', function ($query) {
                // Memastikan hanya layanan terkait "Pernikahan" yang muncul untuk user Keagamaan
                $query->where('nama_layanan', 'like', '%Pernikahan%');
            })
            ->latest()
            ->get();

        return view('keagamaan.lacak_berkas', compact('berkas'));
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
    public function update_keagamaan(Request $request, $uuid)
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

        $keagamaan = Keagamaan_Model::where('keagamaan_id', $uuid)->first();

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

        if ($lacak) {
            $lacak->update([
                'status' => $request->status,
                'keterangan' => 'Diperbarui oleh petugas Keagamaan: ' . $request->keterangan
            ]);
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
                'status' => 'required'
            ]);

            $antrian = Antrian_Online_Model::where('antrian_online_id', $request->id)->firstOrFail();
            $antrian->status_antrian = $request->status;
            $antrian->save();

            $berkas = \App\Models\Lacak_Berkas_Model::where('antrian_online_id', $request->id)->first();

            if ($berkas) {
                if ($request->status == 'Ditolak') {
                    $berkas->keterangan = "Ditolak: " . ($request->alasan ?? 'Tanpa alasan spesifik');
                } else if ($request->status == 'Diterima') {
                    $berkas->keterangan = "Permohonan telah disetujui oleh petugas keagamaan.";
                }
                $berkas->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diperbarui menjadi ' . $request->status
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data antrian dengan ID ' . $request->id . ' tidak ditemukan.'
            ], 404);
        } catch (\Exception $e) {
            // Format error untuk user
            $errorInfo = DatabaseException::formatForUser($e);

            Log::error('Keagamaan update status failed', [
                'error_code' => $errorInfo['error_code'],
                'error' => $e->getMessage(),
                'location' => $errorInfo['location'],
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(
                DatabaseException::toJsonResponse($errorInfo),
                500
            );
        }
    }

    /**
     * Hapus data keagamaan
     */
    public function hapus_keagamaan($uuid)
    {
        if (!Auth::user()->hasRole('Keagamaan')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $keagamaan = Keagamaan_Model::where('keagamaan_id', $uuid)->first();

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

    public function store(Request $request)
    {
        $request->validate([
            'layanan_id' => 'required',
        ]);

        try {
            DB::beginTransaction();

            // 1. Simpan ke tabel Antrian_Online_Model
            $antrian = new Antrian_Online_Model();
            $antrian->user_id = Auth::id();
            $antrian->layanan_id = $request->layanan_id;
            $antrian->status = 'Pending';
            $antrian->save();

            $formData = $request->except(['_token', 'layanan_id']);

            $lacak = new Lacak_Berkas_Model();
            $lacak->antrian_online_id = $antrian->antrian_online_id;
            $lacak->status = 'Pending';
            $lacak->tanggal = now();
            $lacak->keterangan = 'Berkas pengajuan ' . ($request->nama_layanan ?? '') . ' telah diterima.';

            $lacak->detail_form = json_encode($formData);
            $lacak->save();

            DB::commit();

            return redirect()->back()->with('success', 'Pengajuan Anda berhasil dikirim dan sedang diproses.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Format error untuk user
            $errorInfo = DatabaseException::formatForUser($e);

            Log::error('Keagamaan submit pengajuan failed', [
                'error_code' => $errorInfo['error_code'],
                'error' => $e->getMessage(),
                'location' => $errorInfo['location'],
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', $errorInfo['user_message'])
                ->with('error_detail', $errorInfo['technical_detail'])
                ->with('error_location', $errorInfo['location'])
                ->with('error_solution', $errorInfo['solution'])
                ->with('error_code', $errorInfo['error_code']);
        }
    }
}