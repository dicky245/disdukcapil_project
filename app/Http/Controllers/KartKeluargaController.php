<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KartuKeluarga;

class KartKeluargaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'layanan_id' => 'required|integer',
            'nomor_registrasi' => 'required|string',
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'kutipan_perkawinan' => 'required|string',
            'keterangan_pindah' => 'nullable|string',
            'kk_lama' => 'required|file|mimes:pdf',
            'surat_keterangan_pengganti' => 'nullable|file|mimes:pdf',
            'salinan_kepres' => 'required|file|mimes:pdf',
            'izin_tinggal_asing' => 'nullable|file|mimes:pdf',
            'status' => 'nullable|string'
        ], [
            'kk_lama.required' => 'Kartu Keluarga Sebelumnya wajib diupload.',
            'kk_lama.mimes' => 'Kartu Keluarga Sebelumnya harus berformat PDF.',
            'surat_keterangan_pengganti.mimes' => 'Surat Keterangan Pengganti harus berformat PDF.',
            'salinan_kepres.required' => 'Salinan Kepres wajib diupload.',
            'salinan_kepres.mimes' => 'Salinan Kepres harus berformat PDF.',
            'izin_tinggal_asing.mimes' => 'Surat Izin Tinggal Asing harus berformat PDF.',
            'nomor_registrasi.required'=> 'Nomor Registrasi wajib diisi.',
            'nama.required' => 'Nama Kepala Keluarga wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'kutipan_perkawinan.required' => 'Kutipan Perkawinan wajib diisi.',
        ]);
        $data = $request->all();
        $data['status'] = 'Dokumen Diterima';
        $data = $request->all();

        if($request->hasFile('kk_lama')){
            $data['kk_lama'] = $request->file('kk_lama')->store('kk','public');
        }

        if($request->hasFile('surat_keterangan_pengganti')){
            $data['surat_keterangan_pengganti'] =
                $request->file('surat_keterangan_pengganti')->store('kk','public');
        }

        if($request->hasFile('salinan_kepres')){
            $data['salinan_kepres'] =
                $request->file('salinan_kepres')->store('kk','public');
        }

        if($request->hasFile('izin_tinggal_asing')){
            $data['izin_tinggal_asing'] =
                $request->file('izin_tinggal_asing')->store('kk','public');
        }
        KartuKeluarga::create($data);
        return redirect()->route('layanan-mandiri')->with('success','Berhasil Ditambahkan');
    }
    public function daftar_kk(Request $request)
    {
        $query = KartuKeluarga::query();
        if ($request->status) {
            $query->where('status', $request->status);
        }
        $datakk = $query->get();
        $jumlahkk = KartuKeluarga::count();
        $menungguVerifikasi = KartuKeluarga::where('status','Dokumen Diterima')->count();
        $dalamProses = KartuKeluarga::where('status','Proses Cetak')->count();
        $selesai = KartuKeluarga::where('status','Siap Pengambilan')->count();
        return view('admin.penerbitan_kk', compact(
            'datakk','jumlahkk','menungguVerifikasi','dalamProses','selesai'
        ));
    }
    public function detail($uuid){
        $berkas = KartuKeluarga::where('uuid', $uuid)->firstOrFail();
        return view('admin.penerbitan_kk_detail', compact('berkas'));
    }
    public function updateStatus(Request $request, $uuid)
    {  
        $kk = KartuKeluarga::where('uuid', $uuid)->firstOrFail();
        $kk->status = $request->status;
        if ($request->status == 'Tolak') {
            $kk->alasan_penolakan = $request->alasan;
        } else {
            $kk->alasan_penolakan = null;
        }
        $kk->save();
        return redirect()->back()->with('success','Status berhasil diperbarui');
    }
}
