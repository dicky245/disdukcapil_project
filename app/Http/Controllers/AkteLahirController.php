<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AkteLahir;

class AkteLahirController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'layanan_id' => 'required|integer',
            'nomor_registrasi' => 'required|string',
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'fotokopi_buku_nikah' => 'required|file|mimes:pdf',
            'surat_bidan' => 'required|file|mimes:pdf',
            'ktp_orangtua' => 'required|file|mimes:pdf',
            'fotokopi_kk' => 'required|file|mimes:pdf',
            'identitas_saksi' => 'required|string',
            'status' => 'nullable|string'
        ]);
        $data = $request->all();
        $data['status'] = 'Dokumen Diterima';
        $data = $request->all();

        if($request->hasFile('fotokopi_buku_nikah')){
            $data['fotokopi_buku_nikah'] = $request->file('fotokopi_buku_nikah')->store('aktelahir','public');
        }

        if($request->hasFile('surat_bidan')){
            $data['surat_bidan'] =
                $request->file('surat_bidan')->store('aktelahir','public');
        }

        if($request->hasFile('ktp_orangtua')){
            $data['ktp_orangtua'] =
                $request->file('ktp_orangtua')->store('aktelahir','public');
        }

        if($request->hasFile('fotokopi_kk')){
            $data['fotokopi_kk'] =
                $request->file('fotokopi_kk')->store('aktelahir','public');
        }
        AkteLahir::create($data);
        return redirect()->route('layanan-mandiri')->with('success','Berhasil Ditambahkan');
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
