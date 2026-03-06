<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KartuKeluarga;

class KartKeluargaController extends Controller
{
    public function store(Request $request)
    {
        $request -> validate([
            'layanan_id'=>'integer|required',
            'nomor_registrasi'=>'string|required',
            'nama'=>'string|required',
            'alamat'=>'string|required',
            'kutipan_perkawinan'=>'string|required',
            'keterangan_pindah'=>'string|nullable',
            'kk_lama'=>'string|required',
            'surat_keterangan_pengganti'=>'string|nullable',
            'salinan_kepres'=>'string|required',
            'izin_tinggal_asing'=>'string|nullable',
            'status'=>'string|required',
            'deleted_at'    
        ]);
        KartuKeluarga::create([
            'layanan_id'=>$request->layanan_id,
            'nomor_registrasi'=>$request->nomor_registrasi,
            'nama'=>$request->nama,
            'alamat'=>$request->alamat,
            'kutipan_perkawinan'=>$request->kutipan_perkawinan,
            'keterangan_pindah'=>$request->keterangan_pindah,
            'kk_lama'=>$request->kk_lama,
            'surat_keterangan_pengganti'=>$request->surat_keterangan_pengganti,
            'salinan_kepres'=>$request->salinan_kepres,
            'izin_tinggal_asing'=>$request->izin_tinggal_asing,
            'status'=>$request->status,
            'deleted_at'
        ]);
        return redirect()->route('Layanan_Mandiri')->with('success','Berhasil Ditambahkan');
    }
}
