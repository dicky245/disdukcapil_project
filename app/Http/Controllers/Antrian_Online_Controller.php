<?php

namespace App\Http\Controllers;

use App\Models\Antrian_Online_Model;
use App\Models\Layanan_Model;
use App\Models\Lacak_Berkas_Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Antrian_Online_Controller extends Controller
{

    /**
     * Tampilkan halaman antrian online
     */
    public function Tampil_Antrian()
    {
        $data_layanan = Layanan_Model::all();
        return view('pages.antrian-online', compact('data_layanan'));
    }

    /**
     * Tambah antrian online baru
     */
    public function Tambah_Antrian(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'layanan_id' => 'required|exists:layanan,layanan_id',
            'nama_lengkap' => 'required|string|max:100',
            'alamat' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Validasi: 1 nama dengan 1 layanan hanya bisa 1 kali request dalam 1 hari
        $hari_ini = date('Y-m-d');
        $antrian_exists = Antrian_Online_Model::where('nama_lengkap', $request->nama_lengkap)
            ->where('layanan_id', $request->layanan_id)
            ->whereDate('created_at', $hari_ini)
            ->exists();

        if ($antrian_exists) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah memiliki antrian untuk layanan ini hari ini',
            ], 422);
        }

        // Generate nomor antrian dengan format ABC-123-456
        $nomor_antrian = $this->Generate_Nomor_Antrian();

        // Cek apakah nomor antrian sudah ada
        while (Antrian_Online_Model::where('nomor_antrian', $nomor_antrian)->exists()) {
            $nomor_antrian = $this->Generate_Nomor_Antrian();
        }

        // Buat antrian baru dengan alamat dan tanggal lahir
        $antrian = Antrian_Online_Model::create([
            'nomor_antrian' => $nomor_antrian,
            'nama_lengkap' => $request->nama_lengkap,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'layanan_id' => $request->layanan_id,
            'status_antrian' => 'Menunggu',
        ]);

        // Buat status awal lacak berkas - SAMA dengan status antrian
        Lacak_Berkas_Model::create([
            'antrian_online_id' => $antrian->antrian_online_id,
            'status' => 'Menunggu',
            'tanggal' => date('Y-m-d'),
            'keterangan' => 'Antrian berhasil dibuat. Menunggu dokumen diterima oleh admin.',
        ]);

        // Load relasi layanan untuk response
        $antrian->load('layanan');

        return response()->json([
            'success' => true,
            'message' => 'Antrian berhasil dibuat',
            'data' => [
                'nomor_antrian' => $nomor_antrian,
                'nama_lengkap' => $antrian->nama_lengkap,
                'layanan' => $antrian->layanan->nama_layanan,
            ],
        ], 201);
    }

    /**
     * Cari antrian berdasarkan nama dan/atau nomor antrian
     */
    public function Cari_Antrian(Request $request)
    {
        $query = Antrian_Online_Model::query();

        if ($request->has('nama_lengkap')) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_lengkap . '%');
        }

        if ($request->has('nomor_antrian')) {
            $query->where('nomor_antrian', $request->nomor_antrian);
        }

        if ($request->has('layanan_id')) {
            $query->where('layanan_id', $request->layanan_id);
        }

        $data_antrian = $query->with(['layanan', 'lacak_berkas'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data_antrian,
        ]);
    }

    /**
     * Get detail antrian
     */
    public function Get_Detail_Antrian($nomor_antrian)
    {
        $antrian = Antrian_Online_Model::with(['layanan', 'lacak_berkas'])
            ->where('nomor_antrian', $nomor_antrian)
            ->first();

        if (!$antrian) {
            return response()->json([
                'success' => false,
                'message' => 'Antrian tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $antrian,
        ]);
    }

    /**
     * Get statistik antrian hari ini
     */
    public function Get_Statistik_Antrian()
    {
        $hari_ini = date('Y-m-d');

        $total_antrian = Antrian_Online_Model::whereDate('created_at', $hari_ini)->count();

        // Antrian menunggu
        $antrian_menunggu = Antrian_Online_Model::whereDate('created_at', $hari_ini)
            ->where('status_antrian', 'Menunggu')
            ->count();

        // Antrian diproses (semua status kecuali Menunggu, Ditolak, Dibatalkan, Siap Pengambilan)
        $status_diproses = ['Dokumen Diterima', 'Verifikasi Data', 'Proses Cetak'];
        $antrian_diproses = Antrian_Online_Model::whereDate('created_at', $hari_ini)
            ->whereIn('status_antrian', $status_diproses)
            ->count();

        // Antrian selesai (Siap Pengambilan)
        $antrian_selesai = Antrian_Online_Model::whereDate('created_at', $hari_ini)
            ->where('status_antrian', 'Siap Pengambilan')
            ->count();

        return response()->json([
            'success' => true,
            'data' => [
                'total_antrian' => $total_antrian,
                'antrian_menunggu' => $antrian_menunggu,
                'antrian_diproses' => $antrian_diproses,
                'antrian_selesai' => $antrian_selesai,
            ],
        ]);
    }

    /**
     * Get semua layanan
     */
    public function Get_Layanan()
    {
        $data_layanan = Layanan_Model::all();

        return response()->json([
            'success' => true,
            'data' => $data_layanan,
        ]);
    }

    /**
     * Lacak berkas berdasarkan nomor antrian atau nama
     */
    public function Lacak_Berkas(Request $request)
    {
        $query = Antrian_Online_Model::query();

        if ($request->has('nomor_antrian') && !empty($request->nomor_antrian)) {
            $query->where('nomor_antrian', $request->nomor_antrian);
        } elseif ($request->has('nama_lengkap') && !empty($request->nama_lengkap)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_lengkap . '%');
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Masukkan nomor antrian atau nama lengkap',
            ], 400);
        }

        $antrian = $query->with(['layanan', 'lacak_berkas' => function($q) {
            $q->orderBy('created_at', 'asc');
        }])->first();

        if (!$antrian) {
            return response()->json([
                'success' => false,
                'message' => 'Data antrian tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'antrian_online_id' => $antrian->antrian_online_id,
                'nomor_antrian' => $antrian->nomor_antrian,
                'nama_lengkap' => $antrian->nama_lengkap,
                'status_antrian' => $antrian->status_antrian,
                'layanan' => $antrian->layanan ? $antrian->layanan->nama_layanan : '-',
                'created_at' => $antrian->created_at,
                'riwayat' => $antrian->lacak_berkas,
            ],
        ]);
    }

    /**
     * Generate nomor antrian dengan format ABC-123-456
     */
    private function Generate_Nomor_Antrian()
    {
        // Generate 3 huruf acak
        $huruf = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3));

        // Generate 3 angka acak untuk bagian pertama
        $angka1 = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);

        // Generate 3 angka acak untuk bagian kedua
        $angka2 = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);

        return "{$huruf}-{$angka1}-{$angka2}";
    }

    /**
                'error' => 'Terjadi kesalahan saat memproses gambar'
            ], 500);
        }
    }

    /**
     * Get data antrian by nomor antrian untuk auto-fill form layanan
     *
     * GET /antrian-online/get-data/{nomor_antrian}
     *
     * @param string $nomor_antrian
     * @return \Illuminate\Http\JsonResponse
     */
    public function Get_Data_Antrian($nomor_antrian)
    {
        $antrian = Antrian_Online_Model::where('nomor_antrian', $nomor_antrian)->first();

        if (!$antrian) {
            return response()->json([
                'success' => false,
                'message' => 'Antrian tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'nama_lengkap' => $antrian->nama_lengkap,
                'alamat' => $antrian->alamat,
                'tanggal_lahir' => $antrian->tanggal_lahir,
            ]
        ]);
    }
}
