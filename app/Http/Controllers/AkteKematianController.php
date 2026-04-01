<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AkteKematian;

class AkteKematianController extends Controller
{
    /**
     * Simpan permohonan akte kematian dari layanan mandiri
     */
    public function store(Request $request)
    {
        $request->validate([
            'layanan_id'        => 'required|integer',
            'nama_almarhum'     => 'required|string',
            'nik_almarhum'      => 'nullable|string|digits:16',
            'tgl_meninggal'     => 'required|date',
            'tempat_meninggal'  => 'required|string',
            'sebab_meninggal'   => 'nullable|string',
            'nik_pelapor'       => 'required|string|digits:16',
            'nama_pelapor'      => 'required|string',
            'hubungan_pelapor'  => 'required|string',
            'surat_keterangan_kematian' => 'nullable|file|max:5120',
            'ktp_almarhum'      => 'nullable|file|max:5120',
            'kartu_keluarga'    => 'nullable|file|max:5120',
        ]);

        $data = $request->all();
        $data['status'] = 'Dokumen Diterima';

        if ($request->hasFile('surat_keterangan_kematian')) {
            $data['surat_keterangan_kematian'] = $request->file('surat_keterangan_kematian')->store('akte_kematian', 'public');
        }
        if ($request->hasFile('ktp_almarhum')) {
            $data['ktp_almarhum'] = $request->file('ktp_almarhum')->store('akte_kematian', 'public');
        }
        if ($request->hasFile('kartu_keluarga')) {
            $data['kartu_keluarga'] = $request->file('kartu_keluarga')->store('akte_kematian', 'public');
        }

        AkteKematian::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Permohonan akte kematian berhasil dikirim',
            'nomor_registrasi' => 'AK-' . date('Ymd') . '-' . rand(100, 999),
        ]);
    }

    /**
     * Tampilkan daftar permohonan akte kematian (admin)
     */
    public function daftar(Request $request)
    {
        $query = AkteKematian::query();
        if ($request->status) {
            $query->where('status', $request->status);
        }
        $dataKematian = $query->latest()->get();
        $jumlah = AkteKematian::count();
        $menungguVerifikasi = AkteKematian::where('status', 'Dokumen Diterima')->count();
        $dalamProses = AkteKematian::where('status', 'Proses Cetak')->count();
        $selesai = AkteKematian::where('status', 'Siap Pengambilan')->count();

        return view('admin.penerbitan_akte_kematian', compact(
            'dataKematian', 'jumlah', 'menungguVerifikasi', 'dalamProses', 'selesai'
        ));
    }

    /**
     * Tampilkan detail permohonan
     */
    public function detail($uuid)
    {
        $berkas = AkteKematian::where('id', $uuid)->firstOrFail();
        return view('admin.penerbitan_akte_kematian_detail', compact('berkas'));
    }

    /**
     * Update status permohonan
     */
    public function updateStatus(Request $request, $uuid)
    {
        $kematian = AkteKematian::where('id', $uuid)->firstOrFail();
        $kematian->status = $request->status;
        $kematian->save();
        return redirect()->back()->with('success', 'Status berhasil diperbarui');
    }

    /**
     *
     * POST /akte-kematian/extract-ktp
     *
