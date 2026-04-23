<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LahirMati;
use App\Models\Antrian_Online_Model;
use App\Models\Lacak_Berkas_Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class LahirMatiController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'layanan_id'                  => 'required|integer',
            'nomor_antrian'               => 'nullable|string',
            'nik_pemohon'                 => 'required|digits:16',
            'nomor_kk_pemohon'            => 'nullable|digits:16',
            'nama_pemohon'                => 'required|string',
            'alamat_pemohon'              => 'required|string',
            'hubungan_pemohon'            => 'required|string',
            'ktp_pemohon'                 => 'nullable|file|mimes:pdf|max:5120',
            'kartu_keluarga_pemohon'      => 'nullable|file|mimes:pdf|max:5120',
            'ktp_saksi1'                  => 'nullable|file|mimes:pdf|max:5120',
            'ktp_saksi2'                  => 'nullable|file|mimes:pdf|max:5120',
            'formulir_f201'               => 'nullable|file|mimes:pdf|max:5120',
            'surat_keterangan_lahir_mati' => 'nullable|file|mimes:pdf|max:5120',
            'foto_wajah'                  => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', 'Validasi Gagal:<br>' . implode('<br>', $validator->errors()->all()))
                ->withInput();
        }

        try {
            $nomorAntrian = $this->generateNomorAntrian();

            $data = $request->except([
                'ktp_pemohon', 'kartu_keluarga_pemohon', 'ktp_saksi1', 
                'ktp_saksi2', 'formulir_f201', 'surat_keterangan_lahir_mati', 'foto_wajah'
            ]);
            
            $data['status'] = 'Dokumen Diterima';
            $data['nomor_antrian'] = $nomorAntrian;

            $fileFields = [
                'ktp_pemohon', 'kartu_keluarga_pemohon', 'ktp_saksi1',
                'ktp_saksi2', 'formulir_f201', 'surat_keterangan_lahir_mati',
            ];

            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $data[$field] = $request->file($field)->store('lahir_mati/dokumen', 'private');
                }
            }

            if ($request->filled('foto_wajah')) {
                $base64   = preg_replace('/^data:image\/\w+;base64,/', '', $request->foto_wajah);
                $decoded  = base64_decode($base64);
                $filename = 'wajah_' . uniqid() . '_' . time() . '.jpg';
                Storage::disk('private')->put("lahir_mati/wajah/{$filename}", $decoded);
                $data['foto_wajah'] = "lahir_mati/wajah/{$filename}";
            }

            $lahirMati = LahirMati::create($data);

            $antrian = Antrian_Online_Model::create([
                'layanan_id'     => $request->layanan_id,
                'nomor_antrian'  => $nomorAntrian,
                'nama_lengkap'   => $request->nama_pemohon, 
                'nik'            => $request->nik_pemohon,
                'alamat'         => $request->alamat_pemohon,
                'tanggal_lahir'  => null,
                'status_antrian' => 'Menunggu',
            ]);

            $lahirMati->update(['antrian_online_id' => $antrian->antrian_online_id]);

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
        $huruf = 'LMT';
        $hariKe = str_pad(date('z') + 1, 3, '0', STR_PAD_LEFT); 
        $count = LahirMati::whereDate('created_at', now())->count() + 1;
        $urutan = str_pad($count, 3, '0', STR_PAD_LEFT);
        return "{$huruf}-{$hariKe}-{$urutan}";
    }

    // FUNGSI INI SEBELUMNYA TERHAPUS
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

    // FUNGSI INI SEBELUMNYA TERHAPUS
    public function detail($uuid)
    {
        $berkas = LahirMati::where('uuid', $uuid)->firstOrFail();
        return view('admin.penerbitan_lahir_mati_detail', compact('berkas'));
    }

    // FUNGSI INI SEBELUMNYA TERHAPUS
    public function updateStatus(Request $request, $uuid)
    {
        $lahirMati = LahirMati::where('uuid', $uuid)->firstOrFail();
        $lahirMati->status = $request->status;
        if ($request->status == 'Tolak') {
            $lahirMati->alasan_penolakan = $request->input('alasan_penolakan');
        } else {
            $lahirMati->alasan_penolakan = null;
        }
        $lahirMati->save();
        return redirect()->back()->with('success', 'Status berhasil diperbarui');
    }

    public function lihatBerkas($uuid, $field)
    {
        $berkas = LahirMati::where('uuid', $uuid)->firstOrFail();
        $path = $berkas->$field;
        
        if (!$path || !Storage::disk('private')->exists($path)) abort(404);
        return Storage::disk('private')->response($path);
    }
}