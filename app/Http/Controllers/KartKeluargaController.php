<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KartuKeluarga;
use App\Models\GantiKepalaKK;
use App\Models\KKHilangRusak;
use App\Models\PisahKK;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class KartKeluargaController extends Controller
{
    // Untuk User Mengurus KK Ganti Data 
    public function store_perubahan_data(Request $request)
    {
        $request->validate([
            'layanan_id' => 'required|integer',
            'nomor_registrasi' => 'required|string',
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'nik' => 'required|digits:16',
            'formulir_f102' => 'required|file|mimes:pdf|max:500',
            'kk_lama' => 'required|file|mimes:pdf|max:500',
            'formulir_f106' => 'required|file|mimes:pdf|max:500',
            'surat_keterangan_perubahan' => 'required|file|mimes:pdf|max:500',
            'pernyataan_pindah_kk' => 'nullable|file|mimes:pdf|max:500',
            'status' => 'nullable|string'
        ]);
        $data = $request->except([
            'formulir_f102', 'kk_lama', 'formulir_f106', 
            'surat_keterangan_perubahan', 'pernyataan_pindah_kk'
        ]);
        $data['status'] = 'Dokumen Diterima';
        $fileFields = [
            'formulir_f102', 
            'kk_lama', 
            'formulir_f106', 
            'surat_keterangan_perubahan', 
            'pernyataan_pindah_kk'
        ];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('ubah_data_kk', 'private');
            }
        }
        KartuKeluarga::create($data);
        return redirect()->route('layanan-mandiri')
                        ->with('success', 'Data dan dokumen berhasil dikirim.');
    }
    // Untuk user yang berganti kepala keluarga
    public function store_ganti_kepala_kk(Request $request)
    {
        $request->validate([
            'layanan_id' => 'required|integer',
            'nomor_registrasi' => 'required|string',
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'nik' => 'required|digits:16',
            'formulir_f102' => 'required|file|mimes:pdf|max:500',
            'fotokopi_akta_kematian' => 'required|file|mimes:pdf|max:500',
            'kk_lama' => 'required|file|mimes:pdf|max:500',
            'surat_pernyataan_wali' => 'nullable|file|mimes:pdf|max:500',
            'status' => 'nullable|string'
        ]);
        $data = $request->except([
            'formulir_f102','fotokopi_akta_kematian', 'kk_lama','surat_pernyataan_wali'
        ]);
        $data['status'] = 'Dokumen Diterima';
        $fileFields = [
            'formulir_f102', 
            'fotokopi_akta_kematian',
            'kk_lama', 
            'surat_pernyataan_wali'
        ];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('ganti_kepala_kk', 'private');
            }
        }
        GantiKepalaKK::create($data);
        return redirect()->route('layanan-mandiri')
                        ->with('success', 'Data dan dokumen berhasil dikirim.');
    }

    // Untuk user yang berganti kepala keluarga
    public function store_kk_hilang_rusak(Request $request)
    {
        $request->validate([
            'layanan_id' => 'required|integer',
            'nomor_registrasi' => 'required|string',
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'nik' => 'required|digits:16',
            'fotokopi_ktp' => 'required|file|mimes:pdf|max:500',
            'fotokopi_izin_tinggal' => 'nullable|file|mimes:pdf|max:500',
            'suket_hilang_rusak' => 'required|file|mimes:pdf|max:500',
            'status' => 'nullable|string'
        ]);
        $data = $request->except([
            'fotokopi_ktp','fotokopi_izin_tinggal', 'suket_hilang_rusak'
        ]);
        $data['status'] = 'Dokumen Diterima';
        $fileFields = [
            'fotokopi_ktp', 
            'fotokopi_izin_tinggal',
            'suket_hilang_rusak', 
        ];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('kk_hilang_rusak', 'private');
            }
        }
        KKHilangRusak::create($data);
        return redirect()->route('layanan-mandiri')
                        ->with('success', 'Data dan dokumen berhasil dikirim.');
    }

    // Untuk user yang berganti kepala keluarga
    public function store_pisah_kk(Request $request)
    {
        $request->validate([
            'layanan_id' => 'required|integer',
            'nomor_registrasi' => 'required|string',
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'nik' => 'required|digits:16',
            'formulir_f102' => 'required|file|mimes:pdf|max:500',
            'fotokopi_buku_nikah' => 'required|file|mimes:pdf|max:500',
            'kk_lama' => 'required|file|mimes:pdf|max:500',
            'status' => 'nullable|string'
        ]);
        $data = $request->except([
            'formulir_f102','fotokopi_buku_nikah', 'kk_lama'
        ]);
        $data['status'] = 'Dokumen Diterima';
        $fileFields = [
            'formulir_f102', 
            'fotokopi_buku_nikah',
            'kk_lama',
        ];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('pisah_kk', 'private');
            }
        }
        PisahKK::create($data);
        return redirect()->route('layanan-mandiri')
                        ->with('success', 'Data dan dokumen berhasil dikirim.');
    }
    // Admin
    public function daftar_kk(Request $request)
    {
        $kk1 = KartuKeluarga::select('uuid','nama','alamat','status')
            ->addSelect(\DB::raw("'Perubahan Data' as jenis"));

        $kk2 = GantiKepalaKK::select('uuid','nama','alamat','status')
            ->addSelect(\DB::raw("'Ganti Kepala' as jenis"));

        $kk3 = KKHilangRusak::select('uuid','nama','alamat','status')
            ->addSelect(\DB::raw("'Hilang/Rusak' as jenis"));

        $kk4 = PisahKK::select('uuid','nama','alamat','status')
            ->addSelect(\DB::raw("'Pisah KK' as jenis"));
        $query = $kk1
            ->unionAll($kk2)
            ->unionAll($kk3)
            ->unionAll($kk4);
        $datakk = \DB::table(\DB::raw("({$query->toSql()}) as kk"))
            ->mergeBindings($query->getQuery())
            ->when($request->status, function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->get();

        // Statistik
        $jumlahkk = $datakk->count();
        $menungguVerifikasi = $datakk->where('status','Dokumen Diterima')->count();
        $dalamProses = $datakk->where('status','Proses Cetak')->count();
        $selesai = $datakk->where('status','Siap Pengambilan')->count();

        return view('admin.penerbitan_kk', compact(
            'datakk','jumlahkk','menungguVerifikasi','dalamProses','selesai'
        ));
    }

    public function detail(Request $request, $uuid, $jenis)
    {
        switch ($jenis) {
            case 'Perubahan Data':
                $berkas = KartuKeluarga::where('uuid', $uuid)->firstOrFail();
                break;
            case 'Ganti Kepala':
                $berkas = GantiKepalaKK::where('uuid', $uuid)->firstOrFail();
                break;
            case 'Hilang/Rusak':
                $berkas = KKHilangRusak::where('uuid', $uuid)->firstOrFail();
                break;
            case 'Pisah KK':
                $berkas = PisahKK::where('uuid', $uuid)->firstOrFail();
                break;
            default:
                abort(404);
        }
        return view('admin.penerbitan_kk_detail', compact('berkas','jenis'));
    }

    public function updateStatus(Request $request, $uuid, $jenis)
    {
        switch ($jenis) {
            case 'Perubahan Data':
                $kk = KartuKeluarga::where('uuid', $uuid)->firstOrFail();
                break;
            case 'Ganti Kepala':
                $kk = GantiKepalaKK::where('uuid', $uuid)->firstOrFail();
                break;
            case 'Hilang/Rusak':
                $kk = KKHilangRusak::where('uuid', $uuid)->firstOrFail();
                break;
            case 'Pisah KK':
                $kk = PisahKK::where('uuid', $uuid)->firstOrFail();
                break;
            default:
                abort(404);
        }
        $kk->status = $request->status;
        if ($request->status == 'Tolak') {
            $kk->alasan_penolakan = $request->alasan;
        } else {
            $kk->alasan_penolakan = null;
        }
        $kk->save();
        return redirect()->back()->with('success','Status berhasil diperbarui');
    }

    public function lihatBerkas($uuid, $jenis, $field)
    {
        switch ($jenis) {
            case 'Perubahan Data':
                $berkas = KartuKeluarga::where('uuid', $uuid)->firstOrFail();
                break;
            case 'Ganti Kepala':
                $berkas = GantiKepalaKK::where('uuid', $uuid)->firstOrFail();
                break;
            case 'Hilang/Rusak':
                $berkas = KKHilangRusak::where('uuid', $uuid)->firstOrFail();
                break;
            case 'Pisah KK':
                $berkas = PisahKK::where('uuid', $uuid)->firstOrFail();
                break;
            default:
                abort(404);
        }
        $path = $berkas->$field;
        if (!$path || !Storage::disk('private')->exists($path)) {
            abort(404);
        }
        return Storage::disk('private')->response($path);
    }
}
