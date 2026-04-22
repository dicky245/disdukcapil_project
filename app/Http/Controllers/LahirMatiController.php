<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LahirMati;
use App\Models\Antrian_Online_Model;
use App\Models\Lacak_Berkas_Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class LahirMatiController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'layanan_id'                  => 'required|integer',
            'nomor_antrian'               => 'nullable|string', // Pastikan ini sudah diganti
            'nik_pemohon'                 => 'required|string|digits:16',
            'nomor_kk_pemohon'            => 'nullable|string|digits:16',
            'nama_pemohon'                => 'required|string',
            'alamat_pemohon'              => 'required|string',
            'hubungan_pemohon'            => 'required|string',
            
            'ktp_pemohon'                 => 'nullable|file|mimes:pdf|max:5120',
            'kartu_keluarga_pemohon'      => 'nullable|file|mimes:pdf|max:5120',
            'ktp_saksi1'                  => 'nullable|file|mimes:pdf|max:5120',
            'ktp_saksi2'                  => 'nullable|file|mimes:pdf|max:5120',
            'formulir_f201'               => 'nullable|file|mimes:pdf|max:5120',
            'surat_keterangan_lahir_mati' => 'nullable|file|mimes:pdf|max:5120',
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
            // 1. GENERATE TOKEN ANTRIAN DI AWAL
            $nomorAntrian = $this->generateNomorAntrian();

            // 2. Ambil data teks
            $data = $request->except([
                'ktp_pemohon', 'kartu_keluarga_pemohon', 'ktp_saksi1', 
                'ktp_saksi2', 'formulir_f201', 'surat_keterangan_lahir_mati'
            ]);
            
            $data['status'] = 'Dokumen Diterima';
            
            // 3. INI KUNCINYA: Timpa input asal-asalan pemohon dengan Token Resmi
            $data['nomor_antrian'] = $nomorAntrian;

            // 4. Handle file uploads 
            $fileUploads = [
                'ktp_pemohon'                 => 'lahir_mati/pemohon',
                'kartu_keluarga_pemohon'      => 'lahir_mati/kk',
                'ktp_saksi1'                  => 'lahir_mati/saksi',
                'ktp_saksi2'                  => 'lahir_mati/saksi',
                'formulir_f201'               => 'lahir_mati/formulir',
                'surat_keterangan_lahir_mati' => 'lahir_mati/surat',
            ];

            foreach ($fileUploads as $inputName => $storagePath) {
                if ($request->hasFile($inputName)) {
                    $data[$inputName] = $request->file($inputName)->store($storagePath, 'public');
                }
            }

            // 5. Simpan ke Database
            $lahirMati = LahirMati::create($data);

            // 6. Create antrian online record
            $antrian = Antrian_Online_Model::create([
                'layanan_id'     => $request->layanan_id,
                'nomor_antrian'  => $nomorAntrian,
                'nama_lengkap'   => $request->nama_pemohon, 
                'nik'            => $request->nik_pemohon,
                'alamat'         => $request->alamat_pemohon,
                'tanggal_lahir'  => null,
                'status_antrian' => 'Menunggu',
            ]);

            // 7. Update record Lahir Mati
            $lahirMati->update(['antrian_online_id' => $antrian->antrian_online_id]);

            // 8. Create lacak berkas record
            Lacak_Berkas_Model::create([
                'antrian_online_id' => $antrian->antrian_online_id,
                'status'            => 'Dokumen Diterima',
                'tanggal'           => now()->toDateString(),
                'keterangan'        => 'Permohonan Pencatatan Lahir Mati diterima dan sedang menunggu verifikasi.',
            ]);

            return redirect()->back()->with('success', 'Permohonan Lahir Mati berhasil dikirim! Nomor Antrian Anda: ' . $nomorAntrian);

        } catch (\Exception $e) {
            $safeErrorMessage = htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $safeErrorMessage)->withInput();
        }
    }

    private function generateNomorAntrian()
    {
        // Format wajib Antrian Online: 3 Huruf - 3 Angka - 3 Angka (Contoh: LMT-106-001)
        $huruf = 'LMT'; // 3 Huruf penanda Lahir Mati
        
        // 3 Angka bagian tengah: Mengambil urutan hari dalam setahun (001 - 365)
        $hariKe = str_pad(date('z') + 1, 3, '0', STR_PAD_LEFT); 
        
        // 3 Angka bagian akhir: Urutan pendaftar hari ini
        $count = LahirMati::whereDate('created_at', now())->count() + 1;
        $urutan = str_pad($count, 3, '0', STR_PAD_LEFT);
        
        return "{$huruf}-{$hariKe}-{$urutan}";
    }

    // ... method daftar, detail, dan updateStatus tetap sama ...
    public function daftar(Request $request)
    {
        $query = LahirMati::query();
        if ($request->status) $query->where('status', $request->status);
        $dataLahirMati = $query->latest()->get();
        $jumlah = LahirMati::count();
        $menungguVerifikasi = LahirMati::where('status', 'Dokumen Diterima')->count();
        $dalamProses = LahirMati::where('status', 'Proses Cetak')->count();
        $selesai = LahirMati::where('status', 'Siap Pengambilan')->count();

        return view('admin.penerbitan_lahir_mati', compact('dataLahirMati', 'jumlah', 'menungguVerifikasi', 'dalamProses', 'selesai'));
    }

    public function detail($uuid)
    {
        $berkas = LahirMati::where('uuid', $uuid)->firstOrFail();
        return view('admin.penerbitan_lahir_mati_detail', compact('berkas'));
    }

    public function updateStatus(Request $request, $uuid)
    {
        $lahirMati = LahirMati::where('uuid', $uuid)->firstOrFail();
        $lahirMati->status = $request->status;
        if ($request->status == 'Tolak') $lahirMati->alasan_penolakan = $request->input('alasan_penolakan');
        $lahirMati->save();
        return redirect()->back()->with('success', 'Status berhasil diperbarui');
    }
}