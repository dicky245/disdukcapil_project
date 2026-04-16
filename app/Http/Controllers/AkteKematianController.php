<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AkteKematian;
use App\Models\Antrian_Online_Model;
use App\Models\Lacak_Berkas_Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AkteKematianController extends Controller
{
    /**
     * Simpan permohonan akte kematian dari layanan mandiri dengan sinkronisasi antrian online
     */
    public function store(Request $request)
    {
        // 1. Validasi dengan struktur yang lebih aman
        $validator = Validator::make($request->all(), [
            'layanan_id'                => 'required|integer',
            'nomor_antrian'          => 'nullable|string',
            'nik_pemohon'               => 'required|string|digits:16',
            'nomor_kk_pemohon'          => 'nullable|string|digits:16',
            'nama_pemohon'              => 'required|string',
            'alamat_pemohon'            => 'required|string',
            'hubungan_pemohon'          => 'required|string',
            
            // File validation
            'ktp_pemohon'               => 'nullable|file|mimes:pdf|max:5120',
            'kartu_keluarga_pemohon'    => 'nullable|file|mimes:pdf|max:5120',
            'formulir_f201'             => 'nullable|file|mimes:pdf|max:5120',
            'surat_keterangan_kematian' => 'nullable|file|mimes:pdf|max:5120',
            'ktp_almarhum'              => 'nullable|file|mimes:pdf|max:5120',
            'ktp_saksi1'                => 'nullable|file|mimes:pdf|max:5120',
            'ktp_saksi2'                => 'nullable|file|mimes:pdf|max:5120',
        ], [
            'digits' => 'Pastikan nomor NIK/KK tepat 16 angka!',
            'mimes'  => 'Berkas yang diunggah harus berformat PDF!',
            'max'    => 'Ukuran berkas maksimal adalah 5MB.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', 'Validasi Gagal:<br>' . implode('<br>', $validator->errors()->all()))
                ->withInput();
        }

        try {
            // 2. Ambil semua data teks
            $data = $request->except([
                'ktp_pemohon', 'kartu_keluarga_pemohon', 'formulir_f201', 
                'surat_keterangan_kematian', 'ktp_almarhum', 'ktp_saksi1', 'ktp_saksi2'
            ]);
            $data['status'] = 'Dokumen Diterima';

            // 3. Handle file uploads (Simpan ke storage/app/public/akte_kematian)
            $fileUploads = [
                'ktp_pemohon'               => 'akte_kematian/pemohon',
                'kartu_keluarga_pemohon'    => 'akte_kematian/kk',
                'formulir_f201'             => 'akte_kematian/formulir',
                'surat_keterangan_kematian' => 'akte_kematian/surat',
                'ktp_almarhum'              => 'akte_kematian/almarhum',
                'ktp_saksi1'                => 'akte_kematian/saksi',
                'ktp_saksi2'                => 'akte_kematian/saksi',
            ];

            foreach ($fileUploads as $inputName => $storagePath) {
                if ($request->hasFile($inputName)) {
                    $data[$inputName] = $request->file($inputName)->store($storagePath, 'public');
                }
            }

            // 4. Simpan ke database Akte Kematian
            $akteKematian = AkteKematian::create($data);

            // 5. Generate nomor antrian
            $nomorAntrian = $this->generateNomorAntrian();

            // 6. Create antrian online record (PERBAIKAN ERROR "CANNOT BE NULL" DI SINI)
            $antrian = Antrian_Online_Model::create([
                'layanan_id'     => $request->layanan_id,
                'nomor_antrian'  => $nomorAntrian,
                
                // Variabel disesuaikan dengan yang ada di log/form
                'nama_lengkap'   => $request->nama_pemohon, 
                'nik'            => $request->nik_pemohon,
                'alamat'         => $request->alamat_pemohon, 
                
                'tanggal_lahir'  => null,
                'status_antrian' => 'Menunggu',
            ]);

            // 7. Update akte kematian dengan ID relasi antrian
            $akteKematian->update([
                'antrian_online_id' => $antrian->antrian_online_id,
            ]);

            // 8. Create lacak berkas record
            Lacak_Berkas_Model::create([
                'antrian_online_id' => $antrian->antrian_online_id,
                'status'            => 'Dokumen Diterima',
                'tanggal'           => now()->toDateString(),
                'keterangan'        => 'Permohonan Akte Kematian diterima dan sedang menunggu verifikasi.',
            ]);

            // 9. Kembalikan ke halaman User dengan pesan sukses
            return redirect()->back()->with('success', 'Permohonan Akte Kematian berhasil dikirim! Nomor Antrian Anda: ' . $nomorAntrian);

        } catch (\Exception $e) {
            // Pembersih teks error agar SweetAlert tidak crash
            $safeErrorMessage = htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
            $safeErrorMessage = str_replace(["\r", "\n"], ' ', $safeErrorMessage);
            
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $safeErrorMessage)->withInput();
        }
    }

    /**
     * Generate nomor antrian unik
     */
    private function generateNomorAntrian()
    {
        $prefix = 'AK-' . date('Ymd');
        $count = AkteKematian::whereDate('created_at', now())->count() + 1;
        return $prefix . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Tampilkan daftar permohonan akte kematian (admin)
     */
    public function daftar(Request $request)
    {
        $query = AkteKematian::query();
        if ($request->status) {
            $query->where('status', $request->status);
        }
        $dataKematian = $query->latest()->get();
        $jumlah = AkteKematian::count();
        $menungguVerifikasi = AkteKematian::where('status', 'Dokumen Diterima')->count();
        $dalamProses = AkteKematian::where('status', 'Proses Cetak')->count();
        $selesai = AkteKematian::where('status', 'Siap Pengambilan')->count();

        return view('admin.penerbitan_akte_kematian', compact(
            'dataKematian', 'jumlah', 'menungguVerifikasi', 'dalamProses', 'selesai'
        ));
    }

    /**
     * Tampilkan detail permohonan
     */
    public function detail($uuid)
    {
        $berkas = AkteKematian::where('uuid', $uuid)->firstOrFail();
        return view('admin.penerbitan_akte_kematian_detail', compact('berkas'));
    }

    /**
     * Update status permohonan
     */
    public function updateStatus(Request $request, $uuid)
    {
        $kematian = AkteKematian::where('uuid', $uuid)->firstOrFail();
        $kematian->status = $request->status;
        if ($request->status == 'Tolak') {
            $kematian->alasan_penolakan = $request->input('alasan_penolakan');
        }
        $kematian->save();
        return redirect()->back()->with('success', 'Status berhasil diperbarui');
    }
}