<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AkteKematian;
use App\Models\Antrian_Online_Model;
use App\Models\Lacak_Berkas_Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AkteKematianController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'layanan_id'                => 'required|integer',
            'nomor_antrian'             => 'nullable|string',
            'nik_pemohon'               => 'required|digits:16',
            'nomor_kk_pemohon'          => 'nullable|digits:16',
            'nama_pemohon'              => 'required|string',
            'alamat_pemohon'            => 'required|string',
            'hubungan_pemohon'          => 'required|string',
            'ktp_pemohon'               => 'nullable|file|mimes:pdf|max:5120',
            'kartu_keluarga_pemohon'    => 'nullable|file|mimes:pdf|max:5120',
            'formulir_f201'             => 'nullable|file|mimes:pdf|max:5120',
            'surat_keterangan_kematian' => 'nullable|file|mimes:pdf|max:5120',
            'ktp_almarhum'              => 'nullable|file|mimes:pdf|max:5120',
            'ktp_saksi1'                => 'nullable|file|mimes:pdf|max:5120',
            'ktp_saksi2'                => 'nullable|file|mimes:pdf|max:5120',
            'foto_wajah'                => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Validasi Gagal:<br>' . implode('<br>', $validator->errors()->all()))->withInput();
        }

        try {
            $nomorAntrian = $this->generateNomorAntrian();
            $data = $request->except(['ktp_pemohon', 'kartu_keluarga_pemohon', 'formulir_f201', 'surat_keterangan_kematian', 'ktp_almarhum', 'ktp_saksi1', 'ktp_saksi2', 'foto_wajah']);
            
            $data['status'] = 'Dokumen Diterima';
            $data['nomor_antrian'] = $nomorAntrian; 

            // Simpan PDF ke Disk Private
            $fileFields = ['ktp_pemohon', 'kartu_keluarga_pemohon', 'formulir_f201', 'surat_keterangan_kematian', 'ktp_almarhum', 'ktp_saksi1', 'ktp_saksi2'];
            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $data[$field] = $request->file($field)->store('akte_kematian/dokumen', 'private');
                }
            }

            // Simpan Foto Wajah Base64 ke Disk Private
            if ($request->filled('foto_wajah')) {
                $base64   = preg_replace('/^data:image\/\w+;base64,/', '', $request->foto_wajah);
                $decoded  = base64_decode($base64);
                $filename = 'wajah_' . uniqid() . '_' . time() . '.jpg';
                Storage::disk('private')->put("akte_kematian/wajah/{$filename}", $decoded);
                $data['foto_wajah'] = "akte_kematian/wajah/{$filename}";
            }

            $akteKematian = AkteKematian::create($data);

            $antrian = Antrian_Online_Model::create([
                'layanan_id' => $request->layanan_id,
                'nomor_antrian' => $nomorAntrian,
                'nama_lengkap' => $request->nama_pemohon, 
                'nik' => $request->nik_pemohon,
                'alamat' => $request->alamat_pemohon, 
                'status_antrian' => 'Menunggu',
            ]);

            $akteKematian->update(['antrian_online_id' => $antrian->antrian_online_id]);
            
            Lacak_Berkas_Model::create([
                'antrian_online_id' => $antrian->antrian_online_id,
                'status'            => 'Dokumen Diterima',
                'tanggal'           => now()->toDateString(),
                'keterangan'        => 'Permohonan Akte Kematian diterima dan sedang menunggu verifikasi.',
            ]);
            
            return redirect()->back()->with('success', 'Berhasil dikirim! No Antrian: ' . $nomorAntrian);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Sistem Error: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
        }
    }

    private function generateNomorAntrian() {
        $huruf = 'AKT'; $hari = str_pad(date('z') + 1, 3, '0', STR_PAD_LEFT); 
        $count = AkteKematian::whereDate('created_at', now())->count() + 1;
        return $huruf . '-' . $hari . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
    }

    // FUNGSI INI SEBELUMNYA TERHAPUS
    public function daftar(Request $request)
    {
        $query = AkteKematian::query();
        if ($request->status) $query->where('status', $request->status);
        $dataKematian = $query->latest()->get();
        $jumlah = AkteKematian::count();
        $menungguVerifikasi = AkteKematian::where('status', 'Dokumen Diterima')->count();
        $dalamProses = AkteKematian::where('status', 'Proses Cetak')->count();
        $selesai = AkteKematian::where('status', 'Siap Pengambilan')->count();

        return view('admin.penerbitan_akte_kematian', compact('dataKematian', 'jumlah', 'menungguVerifikasi', 'dalamProses', 'selesai'));
    }

    // FUNGSI INI SEBELUMNYA TERHAPUS
    public function detail($uuid) {
        $berkas = AkteKematian::where('uuid', $uuid)->firstOrFail();
        return view('admin.penerbitan_akte_kematian_detail', compact('berkas'));
    }

    // FUNGSI INI SEBELUMNYA TERHAPUS
    public function updateStatus(Request $request, $uuid)
    {
        $kematian = AkteKematian::where('uuid', $uuid)->firstOrFail();
        $kematian->status = $request->status;
        if ($request->status == 'Tolak') {
            $kematian->alasan_penolakan = $request->input('alasan_penolakan');
        } else {
            $kematian->alasan_penolakan = null;
        }
        $kematian->save();
        return redirect()->back()->with('success', 'Status berhasil diperbarui');
    }

    public function lihatBerkas($uuid, $field) {
        $berkas = AkteKematian::where('uuid', $uuid)->firstOrFail();
        $path = $berkas->$field;
        if (!$path || !Storage::disk('private')->exists($path)) abort(404);
        return Storage::disk('private')->response($path);
    }
}