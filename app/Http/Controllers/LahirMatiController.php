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
    /**
     * Simpan permohonan lahir mati dari layanan mandiri dengan sinkronisasi antrian online
     */
    public function store(Request $request)
    {
        // 1. VALIDASI MANUAL (Lebih aman dan bisa ditangkap SweetAlert)
        $validator = Validator::make($request->all(), [
            'layanan_id'          => 'required|integer',
            'nomor_registrasi'    => 'nullable|string',
            'nik_pelapor'         => 'required|string|digits:16',
            'nama_pelapor'        => 'required|string',
            'hubungan_pelapor'    => 'required|string',
            
            'tgl_lahir'           => 'required|date',
            'tempat_lahir'        => 'required|string',
            'lama_kandungan'      => 'nullable|string',
            'penolong_persalinan' => 'nullable|string',
            
            // Tambahan Data Bayi yang sebelumnya terlewat
            'nama_bayi'           => 'nullable|string',
            'jenis_kelamin'       => 'nullable|string|in:Laki-laki,Perempuan',
            
            'nik_ayah'            => 'required|string|digits:16',
            'nama_ayah'           => 'required|string',
            'nik_ibu'             => 'required|string|digits:16',
            'nama_ibu'            => 'required|string',
            
            'nik_saksi_1'         => 'nullable|string|digits:16',
            'nama_saksi_1'        => 'nullable|string',
            'nik_saksi_2'         => 'nullable|string|digits:16',
            'nama_saksi_2'        => 'nullable|string',
            
            'surat_keterangan_lahir_mati' => 'nullable|file|mimes:pdf|max:5120',
            'ktp_ayah'            => 'nullable|file|mimes:pdf|max:5120',
            'ktp_ibu'             => 'nullable|file|mimes:pdf|max:5120',
            'kk_orangtua'         => 'nullable|file|mimes:pdf|max:5120',
        ], [
            'digits' => 'Pastikan nomor NIK tepat 16 angka!',
            'mimes'  => 'Berkas yang diunggah harus berformat PDF!',
            'max'    => 'Ukuran berkas maksimal adalah 5MB.'
        ]);

        // Cegat jika validasi gagal, lalu lempar ke SweetAlert dengan aman
        if ($validator->fails()) {
            $errorList = implode('<br>', $validator->errors()->all());
            return redirect()->back()
                ->with('error', $errorList)
                ->withInput();
        }

        try {
            // 2. Ambil data
            $data = $request->except(['surat_keterangan_lahir_mati', 'ktp_ayah', 'ktp_ibu', 'kk_orangtua']);
            $data['status'] = 'Dokumen Diterima';

            // 3. Handle file uploads 
            if ($request->hasFile('surat_keterangan_lahir_mati')) {
                $data['surat_keterangan_lahir_mati'] = $request->file('surat_keterangan_lahir_mati')->store('lahir_mati/surat', 'public');
            }
            if ($request->hasFile('ktp_ayah')) {
                $data['ktp_ayah'] = $request->file('ktp_ayah')->store('lahir_mati/identitas', 'public');
            }
            if ($request->hasFile('ktp_ibu')) {
                $data['ktp_ibu'] = $request->file('ktp_ibu')->store('lahir_mati/identitas', 'public');
            }
            if ($request->hasFile('kk_orangtua')) {
                $data['kk_orangtua'] = $request->file('kk_orangtua')->store('lahir_mati/kk', 'public');
            }
            
            // 4. Bersihkan teks "Bulan" pada lama kandungan
            if (!empty($data['lama_kandungan'])) {
                $data['lama_kandungan'] = (int) preg_replace('/[^0-9]/', '', $data['lama_kandungan']);
            }

            // 5. Simpan ke Database
            $lahirMati = LahirMati::create($data);

            // 6. Generate nomor antrian
            $nomorAntrian = $this->generateNomorAntrian();

            // 7. Create antrian online record
            $antrian = Antrian_Online_Model::create([
                'layanan_id'     => $request->layanan_id,
                'nomor_antrian'  => $nomorAntrian,
                'nama_lengkap'   => $request->nama_ayah, 
                'nik'            => $request->nik_ayah,
                'alamat'         => 'Belum diisi',
                'tanggal_lahir'  => $request->tgl_lahir,
                'status_antrian' => 'Menunggu',
            ]);

            // 8. Update record Lahir Mati dengan UUID relasi antrian
            $lahirMati->update([
                'antrian_online_id' => $antrian->antrian_online_id,
            ]);

            // 9. Create lacak berkas record
            Lacak_Berkas_Model::create([
                'antrian_online_id' => $antrian->antrian_online_id,
                'status'            => 'Dokumen Diterima',
                'tanggal'           => now()->toDateString(),
                'keterangan'        => 'Permohonan Pencatatan Lahir Mati diterima dan sedang menunggu verifikasi petugas.',
            ]);

            // 10. Return success
            return redirect()->back()->with('success', 'Permohonan Lahir Mati berhasil dikirim! Nomor Antrian Anda: ' . $nomorAntrian);

        } catch (\Exception $e) {
            // BERSIHKAN TANDA KUTIP AGAR JAVASCRIPT SWEETALERT TIDAK CRASH
            $safeErrorMessage = htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
            $safeErrorMessage = str_replace(["\r", "\n"], ' ', $safeErrorMessage);
            
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $safeErrorMessage)->withInput();
        }
    }

    /**
     * Generate nomor antrian unik
     */
    private function generateNomorAntrian()
    {
        $prefix = 'LM-' . date('Ymd');
        $count = LahirMati::whereDate('created_at', now())->count() + 1;
        return $prefix . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Tampilkan daftar permohonan lahir mati (admin)
     */
    public function daftar(Request $request)
    {
        $query = LahirMati::query();
        if ($request->status) {
            $query->where('status', $request->status);
        }
        $dataLahirMati = $query->latest()->get();
        $jumlah = LahirMati::count();
        $menungguVerifikasi = LahirMati::where('status', 'Dokumen Diterima')->count();
        $dalamProses = LahirMati::where('status', 'Proses Cetak')->count();
        $selesai = LahirMati::where('status', 'Siap Pengambilan')->count();

        return view('admin.penerbitan_lahir_mati', compact(
            'dataLahirMati', 'jumlah', 'menungguVerifikasi', 'dalamProses', 'selesai'
        ));
    }

    /**
     * Tampilkan detail permohonan
     */
    public function detail($uuid)
    {
        $berkas = LahirMati::where('uuid', $uuid)->firstOrFail();
        return view('admin.penerbitan_lahir_mati_detail', compact('berkas'));
    }

    /**
     * Update status permohonan
     */
    public function updateStatus(Request $request, $uuid)
    {
        $lahirMati = LahirMati::where('uuid', $uuid)->firstOrFail();
        $lahirMati->status = $request->status;
        if ($request->status == 'Tolak') {
            $lahirMati->alasan_penolakan = $request->input('alasan_penolakan');
        }
        $lahirMati->save();
        return redirect()->back()->with('success', 'Status berhasil diperbarui');
    }
}