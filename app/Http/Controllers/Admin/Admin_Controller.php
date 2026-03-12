<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Antrian_Online_Model;
use App\Models\Lacak_Berkas_Model;
use App\Models\Jenis_Keagamaan_Model; // TAMBAHKAN INI
use App\Models\User;
use App\Models\Layanan_Model;
use Illuminate\Http\Request;
use App\Models\Keagamaan_Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
    // Pastikan Anda sudah mengimpor Model di bagian atas file

    // Pastikan nama fungsinya 'manajemen_akun' sesuai dengan Route Anda

    public function manajemen_akun()
    {
        // Proteksi Role Admin
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // PERBAIKAN: Hanya ambil user yang memiliki role 'Keagamaan' melalui tabel Spatie
        // Admin tidak akan muncul karena Admin tidak memiliki role 'Keagamaan'
        $users = User::role('Keagamaan')->with('detail_keagamaan.jenis_keagamaan')->get();

        $list_agama = Jenis_Keagamaan_Model::all();

        return view('admin.manajemen_akun', compact('users', 'list_agama'));
    }

    public function store_akun(Request $request)
    {
        $request->validate([
            'name'     => 'required|string',
            'username' => 'required|unique:users,username,' . $request->accountId,
            'agama'    => 'required',
            'alamat'   => 'required',
            'status'   => 'required',
        ]);

        DB::beginTransaction();
        try {
            // 1. Simpan/Update ke tabel 'users'
            $userData = [
                'name'     => $request->name,
                'username' => $request->username,
            ];

            // Hanya update password jika diisi
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user = User::updateOrCreate(['id' => $request->accountId], $userData);

            // PENTING: Hubungkan user dengan role 'Keagamaan' di tabel model_has_roles (Spatie)
            // Ini yang membuat user muncul di tabel daftar akun saat di-filter
            $user->syncRoles(['Keagamaan']);

            // 2. Simpan/Update ke tabel 'keagamaan' (Detail Profil)
            $user->detail_keagamaan()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'jenis_keagamaan_id' => $request->agama,
                    'alamat'             => $request->alamat,
                    'status'             => $request->status,
                    // Kolom role tidak ditambahkan di sini sesuai instruksi Anda
                ]
            );

            DB::commit();
            // Mengirim session success untuk memicu pop-up SweetAlert2 di View
            return redirect()->back()->with('success', 'Akun Keagamaan Berhasil Disimpan!');
        } catch (\Exception $e) {
            DB::rollback();
            // Mengirim session error untuk memicu pop-up SweetAlert2 di View
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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
     * Terima dokumen (langkah pertama)
     */
    public function Terima_Dokumen($id)
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

        // Cek apakah status sudah Dokumen Diterima
        if ($antrian->status_antrian === 'Dokumen Diterima') {
            return response()->json([
                'success' => false,
                'message' => 'Dokumen sudah diterima sebelumnya',
            ], 400);
        }

        $antrian->update(['status_antrian' => 'Dokumen Diterima']);

        // Cek apakah sudah ada lacak berkas dengan status Dokumen Diterima
        $existing_lacak = Lacak_Berkas_Model::where('antrian_online_id', $antrian->antrian_online_id)
            ->where('status', 'Dokumen Diterima')
            ->first();

        // Hanya buat lacak berkas baru jika belum ada
        if (!$existing_lacak) {
            Lacak_Berkas_Model::create([
                'antrian_online_id' => $antrian->antrian_online_id,
                'status' => 'Dokumen Diterima',
                'tanggal' => date('Y-m-d'),
                'keterangan' => 'Dokumen diterima, menunggu verifikasi',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Dokumen berhasil diterima',
        ]);
    }

    /**
     * Mulai verifikasi data
     */
    public function Verifikasi_Data($id)
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

        // Cek apakah status sudah Verifikasi Data
        if ($antrian->status_antrian === 'Verifikasi Data') {
            return response()->json([
                'success' => false,
                'message' => 'Status sudah Verifikasi Data',
            ], 400);
        }

        $antrian->update(['status_antrian' => 'Verifikasi Data']);

        // Cek apakah sudah ada lacak berkas dengan status Verifikasi Data
        $existing_lacak = Lacak_Berkas_Model::where('antrian_online_id', $antrian->antrian_online_id)
            ->where('status', 'Verifikasi Data')
            ->first();

        // Hanya buat lacak berkas baru jika belum ada
        if (!$existing_lacak) {
            Lacak_Berkas_Model::create([
                'antrian_online_id' => $antrian->antrian_online_id,
                'status' => 'Verifikasi Data',
                'tanggal' => date('Y-m-d'),
                'keterangan' => 'Data sedang diverifikasi oleh admin',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Verifikasi data berhasil dimulai',
        ]);
    }

    /**
     * Proses cetak dokumen
     */
    public function Proses_Cetak($id)
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

        // Cek apakah status sudah Proses Cetak
        if ($antrian->status_antrian === 'Proses Cetak') {
            return response()->json([
                'success' => false,
                'message' => 'Status sudah Proses Cetak',
            ], 400);
        }

        $antrian->update(['status_antrian' => 'Proses Cetak']);

        // Cek apakah sudah ada lacak berkas dengan status Proses Cetak
        $existing_lacak = Lacak_Berkas_Model::where('antrian_online_id', $antrian->antrian_online_id)
            ->where('status', 'Proses Cetak')
            ->first();

        // Hanya buat lacak berkas baru jika belum ada
        if (!$existing_lacak) {
            Lacak_Berkas_Model::create([
                'antrian_online_id' => $antrian->antrian_online_id,
                'status' => 'Proses Cetak',
                'tanggal' => date('Y-m-d'),
                'keterangan' => 'Dokumen sedang dalam proses cetak',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Proses cetak berhasil dimulai',
        ]);
    }

    /**
     * Siap diambil
     */
    public function Siap_Pengambilan($id)
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

        // Cek apakah status sudah Siap Pengambilan
        if ($antrian->status_antrian === 'Siap Pengambilan') {
            return response()->json([
                'success' => false,
                'message' => 'Status sudah Siap Pengambilan',
            ], 400);
        }

        $antrian->update(['status_antrian' => 'Siap Pengambilan']);

        // Cek apakah sudah ada lacak berkas dengan status Siap Pengambilan
        $existing_lacak = Lacak_Berkas_Model::where('antrian_online_id', $antrian->antrian_online_id)
            ->where('status', 'Siap Pengambilan')
            ->first();

        // Hanya buat lacak berkas baru jika belum ada
        if (!$existing_lacak) {
            Lacak_Berkas_Model::create([
                'antrian_online_id' => $antrian->antrian_online_id,
                'status' => 'Siap Pengambilan',
                'tanggal' => date('Y-m-d'),
                'keterangan' => 'Dokumen siap diambil oleh pemohon',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Dokumen siap diambil',
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
            'alasan_penolakan' => 'required_if:status,Ditolak|string|nullable',
        ]);

        $antrian = Antrian_Online_Model::find($id);

        if (!$antrian) {
            return response()->json([
                'success' => false,
                'message' => 'Antrian tidak ditemukan',
            ], 404);
        }

        // Cek apakah status yang akan diupdate sama dengan status sekarang
        if ($antrian->status_antrian === $request->status) {
            return response()->json([
                'success' => false,
                'message' => 'Status antrian sama dengan status sekarang',
            ], 400);
        }

        // Update status antrian di tabel antrian_online
        $antrian->update(['status_antrian' => $request->status]);

        // Cek apakah sudah ada lacak berkas dengan status yang sama
        $existing_lacak = Lacak_Berkas_Model::where('antrian_online_id', $antrian->antrian_online_id)
            ->where('status', $request->status)
            ->first();

        // Hanya buat lacak berkas baru jika belum ada
        if (!$existing_lacak) {
            // Siapkan data untuk lacak berkas
            $dataLacak = [
                'antrian_online_id' => $antrian->antrian_online_id,
                'status' => $request->status,
                'tanggal' => date('Y-m-d'),
                'keterangan' => $request->keterangan ?? "Status diperbarui: {$request->status}",
            ];

            // Tambahkan alasan penolakan jika statusnya Ditolak
            if ($request->status === 'Ditolak' && $request->has('alasan_penolakan')) {
                $dataLacak['alasan_penolakan'] = $request->alasan_penolakan;
            }

            // Tambahkan riwayat lacak berkas baru
            Lacak_Berkas_Model::create($dataLacak);
        }

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
            'data' => [
                'riwayat' => $riwayat_berkas,
            ],
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
