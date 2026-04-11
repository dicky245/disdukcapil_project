<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AkteLahir;
use Illuminate\Support\Str;

class AkteLahirController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'layanan_id' => 'required|exists:layanan,layanan_id',
            'nomor_registrasi' => 'required|string',

            'nama_pelapor' => 'required|string',
            'nik_pelapor' => 'required|digits:16',
            'nomor_dokumen' => 'required|string',
            'nomor_kk' => 'required|string',
            'kewarganegaraan_pelapor' => 'required|string',

            'nama_saksi1' => 'required|string',
            'nik_saksi1' => 'required|digits:16',
            'nomor_kk_saksi1' => 'required|string',
            'kewarganegaraan_saksi1' => 'required|string',

            'nama_saksi2' => 'required|string',
            'nik_saksi2' => 'required|digits:16',
            'nomor_kk_saksi2' => 'required|string',
            'kewarganegaraan_saksi2' => 'required|string',

            'nama_ayah' => 'required|string',
            'nik_ayah' => 'required|digits:16',
            'tempat_lahir_ayah' => 'required|string',
            'tanggal_lahir_ayah' => 'required|string',
            'kewarganegaraan_ayah' => 'required|string',

            'nama_ibu' => 'required|string',
            'nik_ibu' => 'required|digits:16',
            'tempat_lahir_ibu' => 'required|string',
            'tanggal_lahir_ibu' => 'required|string',
            'kewarganegaraan_ibu' => 'required|string',

            'nama_anak' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'tempat_dilahirkan' => 'required|string',
            'tempat_kelahiran' => 'required|string',
            'hari_tanggal_lahir' => 'required|string',
            'pukul' => 'required|string',
            'jenis_kelahiran' => 'required|string',
            'kelahiran_ke' => 'required|string',
            'penolong' => 'required|string',
            'berat_bayi' => 'required|string',
            'panjang_bayi' => 'required|string',

            'file_surat_lahir' => 'required|file|mimes:pdf',
            'file_buku_nikah' => 'required|file|mimes:pdf',
            'file_kk' => 'required|file|mimes:pdf',
            'file_sptjm_kelahiran' => 'nullable|file|mimes:pdf',
            'file_sptjm_pasutri' => 'nullable|file|mimes:pdf',
            'file_berita_acara_polisi' => 'nullable|file|mimes:pdf',
        ]);

        $data = $request->all();
        $data['uuid'] = Str::uuid();
        $data['status'] = 'Dokumen Diterima';
        $data['file_surat_lahir'] = $request->file('file_surat_lahir')->store('aktelahir', 'public');
        $data['file_buku_nikah'] = $request->file('file_buku_nikah')->store('aktelahir', 'public');
        $data['file_kk'] = $request->file('file_kk')->store('aktelahir', 'public');
        if ($request->hasFile('file_sptjm_kelahiran')) {
            $data['file_sptjm_kelahiran'] = $request->file('file_sptjm_kelahiran')->store('aktelahir', 'public');
        }
        if ($request->hasFile('file_sptjm_pasutri')) {
            $data['file_sptjm_pasutri'] = $request->file('file_sptjm_pasutri')->store('aktelahir', 'public');
        }
        if ($request->hasFile('file_berita_acara_polisi')) {
            $data['file_berita_acara_polisi'] = $request->file('file_berita_acara_polisi')->store('aktelahir', 'public');
        }
        AkteLahir::create($data);
        return redirect()->route('layanan-mandiri')
            ->with('success', 'Berhasil Ditambahkan');
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
}
