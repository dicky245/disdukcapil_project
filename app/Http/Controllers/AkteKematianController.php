<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AkteKematian;
use App\Models\Antrian_Online_Model;
use App\Models\Lacak_Berkas_Model;
use Illuminate\Support\Str;

class AkteKematianController extends Controller
{
    /**
     * Simpan permohonan akte kematian dari layanan mandiri dengan sinkronisasi antrian online
     */
    public function store(Request $request)
    {
        // 1. Validasi disesuaikan dengan 'name' ACTUAL yang dikirim dari form (Berdasarkan Log)
        $request->validate([
            'layanan_id'                => 'required|integer',
            'nomor_registrasi'          => 'nullable|string',
            'nama_almarhum'             => 'required|string',
            'nik_almarhum'              => 'nullable|string|digits:16',
            'tgl_meninggal'             => 'required|date',
            'tempat_meninggal'          => 'required|string',
            'sebab_meninggal'           => 'nullable|string',
            'yang_menerangkan'          => 'nullable|string',
            'nik_pelapor'               => 'required|string|digits:16',
            'nomor_kk_pelapor'          => 'nullable|string',
            'nama_pelapor'              => 'required|string',
            'hubungan_pelapor'          => 'required|string',
            'nik_saksi_1'               => 'nullable|string|digits:16',
            'nama_saksi_1'              => 'nullable|string',
            'nik_saksi_2'               => 'nullable|string|digits:16',
            'nama_saksi_2'              => 'nullable|string',
            
            // File validation disesuaikan dengan input name dari form
            'surat_keterangan_kematian' => 'nullable|file|mimes:pdf|max:5120',
            'ktp_almarhum'              => 'nullable|file|mimes:pdf|max:5120',
            'kartu_keluarga'            => 'nullable|file|mimes:pdf|max:5120',
            'dokumen_perjalanan'        => 'nullable|file|mimes:pdf|max:5120',
        ]);

        try {
            // 2. Ambil semua data request
            $data = $request->except(['surat_keterangan_kematian', 'ktp_almarhum', 'kartu_keluarga', 'dokumen_perjalanan']);
            $data['status'] = 'Dokumen Diterima';

            // 3. Handle file uploads (Simpan ke storage/app/public/akte_kematian)
            if ($request->hasFile('surat_keterangan_kematian')) {
                $data['surat_keterangan_kematian'] = $request->file('surat_keterangan_kematian')->store('akte_kematian/surat', 'public');
            }
            if ($request->hasFile('ktp_almarhum')) {
                $data['ktp_almarhum'] = $request->file('ktp_almarhum')->store('akte_kematian/identitas', 'public');
            }
            if ($request->hasFile('kartu_keluarga')) {
                $data['kartu_keluarga'] = $request->file('kartu_keluarga')->store('akte_kematian/kk', 'public');
            }
            if ($request->hasFile('dokumen_perjalanan')) {
                $data['dokumen_perjalanan'] = $request->file('dokumen_perjalanan')->store('akte_kematian/dokumen', 'public');
            }

            // 4. Simpan ke database Akte Kematian
            // (Karena nama input dari form sudah SAMA PERSIS dengan nama kolom DB, kita bisa langsung pakai $data)
            $akteKematian = AkteKematian::create($data);

            // 5. Generate nomor antrian
            $nomorAntrian = $this->generateNomorAntrian();

            // 6. Create antrian online record
            $antrian = Antrian_Online_Model::create([
                'layanan_id'     => $request->layanan_id,
                'nomor_antrian'  => $nomorAntrian,
                'nama_lengkap'   => $request->nama_pelapor,
                'nik'            => $request->nik_pelapor,
                'alamat'         => 'Belum diisi',
                'tanggal_lahir'  => null,
                'status_antrian' => 'Menunggu',
            ]);

            // 7. Update akte kematian dengan ID relasi antrian
            $akteKematian->update([
                'antrian_online_id' => $antrian->antrian_online_id,
            ]);

            // 8. Create lacak berkas record
            Lacak_Berkas_Model::create([
                'antrian_online_id' => $antrian->antrian_online_id,
                'status'            => 'Dokumen Diterima',
                'tanggal'           => now()->toDateString(),
                'keterangan'        => 'Permohonan Akte Kematian diterima dan sedang menunggu verifikasi.',
            ]);

            // 9. Kembalikan ke halaman User dengan pesan sukses
            return redirect()->back()->with('success', 'Permohonan Akte Kematian berhasil dikirim! Nomor Antrian Anda: ' . $nomorAntrian);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Generate nomor antrian unik
     */
    private function generateNomorAntrian()
    {
        $prefix = 'AK-' . date('Ymd');
        $count = AkteKematian::whereDate('created_at', now())->count() + 1;
        return $prefix . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
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
        $berkas = AkteKematian::where('uuid', $uuid)->firstOrFail();
        return view('admin.penerbitan_akte_kematian_detail', compact('berkas'));
    }

    /**
     * Update status permohonan
     */
    public function updateStatus(Request $request, $uuid)
    {
        $kematian = AkteKematian::where('uuid', $uuid)->firstOrFail();
        $kematian->status = $request->status;
        if ($request->status == 'Tolak') {
            $kematian->alasan_penolakan = $request->input('alasan_penolakan');
        }
        $kematian->save();
        return redirect()->back()->with('success', 'Status berhasil diperbarui');
    }
}