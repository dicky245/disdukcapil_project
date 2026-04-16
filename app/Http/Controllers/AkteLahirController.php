<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AkteLahir;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AkteLahirController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'layanan_id' => 'required|exists:layanan,layanan_id',
            'nomor_registrasi' => 'required|string',
            'nama_pemohon' => 'required|string',
            'nik_pemohon' => 'required|digits:16',
            'nomor_kk_pemohon' => 'required|string',
            'alamat' => 'required|string',
            'formulir_f201' => 'required|file|mimes:pdf',
            'ktp_pemohon' => 'required|file|mimes:pdf',
            'ktp_saksi1' => 'required|file|mimes:pdf',
            'ktp_saksi2' => 'required|file|mimes:pdf',
            'kk_pemohon' => 'required|file|mimes:pdf',
            'file_surat_lahir' => 'required|file|mimes:pdf',
            'file_buku_nikah' => 'required|file|mimes:pdf',
            'file_sptjm_kelahiran' => 'nullable|file|mimes:pdf',
            'file_sptjm_pasutri' => 'nullable|file|mimes:pdf',
            'file_berita_acara_polisi' => 'nullable|file|mimes:pdf',
        ]);

        $data = $request->all();
        $data['uuid'] = Str::uuid();
        $data['status'] = 'Dokumen Diterima';
        $data = $request->except([
            'formulir_f201', 'ktp_pemohon','ktp_saksi1','ktp_saksi2','kk_pemohon', 'file_surat_lahir','file_buku_nikah','file_sptjm_kelahiran','file_sptjm_pasutri','file_berita_acara_polisi'
        ]);
        $fileFields = [
            'formulir_f201', 
            'ktp_pemohon',
            'ktp_saksi1',
            'ktp_saksi2',
            'kk_pemohon', 
            'file_surat_lahir',
            'file_buku_nikah',
            'file_sptjm_kelahiran',
            'file_sptjm_pasutri',
            'file_berita_acara_polisi'
        ];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('akte_lahir', 'private');
            }
        }
        AkteLahir::create($data);
        return redirect()->route('layanan-mandiri')
            ->with('success', 'Data dan dokumen berhasil dikirim.');
    }

    public function daftar_aktelahir(Request $request)
    {
        $query = AkteLahir::query();
        if ($request->status) {
            $query->where('status', $request->status);
        }
        $dataAkteLahir = $query->get();
        $jumlahAkteLahir = AkteLahir::count();
        $menungguVerifikasi = AkteLahir::where('status','Dokumen Diterima')->count();
        $dalamProses = AkteLahir::where('status','Proses Cetak')->count();
        $selesai = AkteLahir::where('status','Siap Pengambilan')->count();
        return view('admin.penerbitan_akte_lahir', compact('dataAkteLahir','jumlahAkteLahir','menungguVerifikasi','dalamProses','selesai'));
    }
    public function detail($uuid){
        $berkas = AkteLahir::where('uuid', $uuid)->firstOrFail();
        return view('admin.penerbitan_akte_lahir_detail', compact('berkas'));
    }
    public function updateStatus(Request $request, $uuid)
    {
        $akteLahir = AkteLahir::where('uuid', $uuid)->firstOrFail();
        $akteLahir->status = $request->status;
        if ($request->status == 'Tolak') {
            $akteLahir->alasan_penolakan = $request->alasan;
        } else {
            $akteLahir->alasan_penolakan = null;
        }
        $akteLahir->save();
        return redirect()->back()->with('success','Status berhasil diperbarui');
    }
    public function lihatBerkas($uuid, $field)
    {
        $berkas = AkteLahir::where('uuid', $uuid)->firstOrFail();
        $path = $berkas->$field;
        if (!$path || !Storage::disk('private')->exists($path)) {
            abort(404);
        }
        return Storage::disk('private')->response($path);
    }
}
