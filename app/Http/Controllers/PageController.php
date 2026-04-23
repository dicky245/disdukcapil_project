<?php

namespace App\Http\Controllers;

use App\Models\Berita_Model;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Halaman Beranda / Home
     */
    public function index()
    {
        $beritas = Berita_Model::query()
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->limit(12)
            ->get();

        $newsForModal = $beritas->keyBy->id->map(function ($b) {
            $tanggal = ($b->published_at ?? $b->created_at)->locale('id')->translatedFormat('d F Y');

            return [
                'category' => $b->judul,
                'date' => $tanggal,
                'title' => $b->judul,
                'content' => $b->konten,
            ];
        });

        return view('pages.index', compact('beritas', 'newsForModal'));
    }

    /**
     * Halaman Layanan Mandiri
     */
    public function layananMandiri()
    {
                return response()
            ->view('pages.layanan-mandiri')
            ->header('Permissions-Policy', 'camera=(self)')
            ->header('Feature-Policy', 'camera *');
    }

public function unduhFormulir()
    {
        return view('pages.unduh-formulir');
    }
    /**
     * Form Layanan Mandiri per jenis
     */
    public function formLayanan($jenis_layanan)
    {
        $services = [
            'ktp' => 'KTP Elektronik',
            'kk' => 'Kartu Keluarga',
            'akta-lahir' => 'Akta Kelahiran',
            'akta-kematian' => 'Akta Kematian',
            'kia' => 'Kartu Identitas Anak',
            'pindah' => 'Surat Pindah',
            'kawin' => 'Akta Perkawinan',
            'cerai' => 'Akta Perceraian',
        ];

        if (!isset($services[$jenis_layanan])) {
            abort(404);
        }

        return view('pages.form-layanan', [
            'jenis_layanan' => $jenis_layanan,
            'nama_layanan' => $services[$jenis_layanan]
        ]);
    }

    /**
     * Submit Layanan Mandiri
     */
    public function submitLayanan(Request $request, $jenis_layanan)
    {
        // Validate request
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|size:16',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);

        // Simpan logic ke database disini
        // ...

        return redirect()->route('layanan-mandiri')
            ->with('success', 'Pengajuan layanan berhasil dikirim. Silakan pantau status secara berkala.');
    }

    /**
     * Halaman Statistik / Visualisasi Data
     */
    public function statistik()
    {
        // Data statistik
        $stats = [
            'total_penduduk' => 250487,
            'ktp_elektronik' => 238210,
            'kartu_keluarga' => 78456,
            'kia_anak' => 45234
        ];

        $districts = [
            ['name' => 'Kec. Balige', 'penduduk' => 45234, 'kk' => 12456, 'ktp' => 43120, 'percentage' => 95],
            ['name' => 'Kec. Borbor', 'penduduk' => 28456, 'kk' => 7890, 'ktp' => 27340, 'percentage' => 92],
            ['name' => 'Kec. Laguboti', 'penduduk' => 35678, 'kk' => 9234, 'ktp' => 34120, 'percentage' => 94],
        ];

        return view('pages.statistik', compact('stats', 'districts'));
    }
}
