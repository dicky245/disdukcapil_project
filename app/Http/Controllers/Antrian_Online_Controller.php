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
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Generate nomor antrian dengan format ABC-123-456
        $nomor_antrian = $this->Generate_Nomor_Antrian();

        // Cek apakah nomor antrian sudah ada
        while (Antrian_Online_Model::where('nomor_antrian', $nomor_antrian)->exists()) {
            $nomor_antrian = $this->Generate_Nomor_Antrian();
        }

        // Buat antrian baru
        $antrian = Antrian_Online_Model::create([
            'nomor_antrian' => $nomor_antrian,
            'nama_lengkap' => $request->nama_lengkap,
            'layanan_id' => $request->layanan_id,
            'status_antrian' => 'Menunggu',
        ]);

        // Buat status awal lacak berkas
        Lacak_Berkas_Model::create([
            'antrian_online_id' => $antrian->antrian_online_id,
            'status' => 'Dokumen Diterima',
            'tanggal' => date('Y-m-d'),
            'keterangan' => 'Antrian berhasil dibuat',
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
        $antrian_menunggu = Antrian_Online_Model::whereDate('created_at', $hari_ini)
            ->where('status_antrian', 'Menunggu')
            ->count();
        $antrian_diproses = Antrian_Online_Model::whereDate('created_at', $hari_ini)
            ->where('status_antrian', 'Sedang Diproses')
            ->count();
        $antrian_selesai = Antrian_Online_Model::whereDate('created_at', $hari_ini)
            ->where('status_antrian', 'Selesai')
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
}
