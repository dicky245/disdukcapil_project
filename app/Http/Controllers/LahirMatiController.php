<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LahirMati;

class LahirMatiController extends Controller
{
    /**
     * Simpan permohonan lahir mati dari layanan mandiri
     */
    public function store(Request $request)
    {
        $request->validate([
            'layanan_id'    => 'required|integer',
            'nama_bayi'     => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tgl_lahir'     => 'required|date',
            'tempat_lahir'  => 'required|string',
            'nama_ayah'     => 'required|string',
            'nik_ayah'      => 'required|string|digits:16',
            'nama_ibu'      => 'required|string',
            'nik_ibu'       => 'required|string|digits:16',
            'keterangan'    => 'nullable|string',
            'surat_keterangan_lahir_mati' => 'nullable|file|max:5120',
            'ktp_ayah'      => 'nullable|file|max:5120',
            'ktp_ibu'       => 'nullable|file|max:5120',
        ]);

        $data = $request->all();
        $data['status'] = 'Dokumen Diterima';

        if ($request->hasFile('surat_keterangan_lahir_mati')) {
            $data['surat_keterangan_lahir_mati'] = $request->file('surat_keterangan_lahir_mati')->store('lahir_mati', 'public');
        }
        if ($request->hasFile('ktp_ayah')) {
            $data['ktp_ayah'] = $request->file('ktp_ayah')->store('lahir_mati', 'public');
        }
        if ($request->hasFile('ktp_ibu')) {
            $data['ktp_ibu'] = $request->file('ktp_ibu')->store('lahir_mati', 'public');
        }

        LahirMati::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Permohonan lahir mati berhasil dikirim',
            'nomor_registrasi' => 'LM-' . date('Ymd') . '-' . rand(100, 999),
        ]);
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
    public function detail($id)
    {
        $berkas = LahirMati::findOrFail($id);
        return view('admin.penerbitan_lahir_mati_detail', compact('berkas'));
    }

    /**
     * Update status permohonan
     */
    public function updateStatus(Request $request, $id)
    {
        $lahirMati = LahirMati::findOrFail($id);
        $lahirMati->status = $request->status;
        $lahirMati->save();
        return redirect()->back()->with('success', 'Status berhasil diperbarui');
    }

}