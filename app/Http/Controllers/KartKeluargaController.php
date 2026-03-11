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
            'kk_lama' => 'required|file',
            'surat_keterangan_pengganti' => 'nullable|file',
            'salinan_kepres' => 'required|file',
            'izin_tinggal_asing' => 'nullable|file',
            'status' => 'nullable|string'
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
    public function detail($id){
        $berkas = KartuKeluarga::findOrFail($id);
        return view('admin.penerbitan_kk_detail', compact('berkas'));
    }
    public function updateStatus(Request $request, $id)
    {
        $kk = KartuKeluarga::findOrFail($id);
        $kk->status = $request->status;
        $kk->save();
        return redirect()->back()->with('success','Status berhasil diperbarui');
    }
}
