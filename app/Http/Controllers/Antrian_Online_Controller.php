<?php

namespace App\Http\Controllers;

use App\Models\Antrian_Online_Model;
use App\Models\Layanan_Model;
use App\Models\Lacak_Berkas_Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Antrian_Online_Controller extends Controller
{

    /**
     * Tampilkan halaman antrian online
     */
    public function Tampil_Antrian()
    {
        $data_layanan = Layanan_Model::all();
        $jam_kerja = $this->Get_Jam_Kerja_Info();
        return view('pages.antrian-online', compact('data_layanan', 'jam_kerja'));
    }

    /**
     * Get jam kerja information untuk display
     *
     * @return array
     */
    private function Get_Jam_Kerja_Info(): array
    {
        return [
            'senin_kamis' => '08.00 - 16.00 WIB',
            'jumat' => '08.00 - 14.00 WIB',
            'sabtu_minggu' => 'Tutup',
        ];
    }

    /**
     * Cek apakah waktu sekarang dalam jam kerja
     *
     * @return array ['is_working_hours' => bool, 'message' => string, 'next_open' => string]
     */
    private function Cek_Jam_Kerja(): array
    {
        // Set timezone ke WIB (UTC+7)
        $waktu = new \DateTime('now', new \DateTimeZone('Asia/Jakarta'));
        $hari = $waktu->format('N'); // 1 (Senin) sampai 7 (Minggu)
        $jam = $waktu->format('H:i');
        $timestamp = $waktu->getTimestamp();

        // Jam kerja
        $jam_buka_senin_kamis = '08:00';
        $jam_tutup_senin_kamis = '16:00';
        $jam_buka_jumat = '08:00';
        $jam_tutup_jumat = '14:00';

        // Cek Sabtu & Minggu (6 & 7)
        if ($hari == 6 || $hari == 7) {
            $next_monday = clone $waktu;
            $next_monday->modify('next monday');
            $next_monday->setTime(8, 0, 0);

            return [
                'is_working_hours' => false,
                'message' => 'Maaf, layanan antrian online tidak tersedia pada hari Sabtu & Minggu.',
                'jam_kerja' => $this->Get_Jam_Kerja_Info(),
                'next_open' => $next_monday->format('l, d F Y H:i') . ' WIB',
            ];
        }

        // Cek Jumat (5)
        if ($hari == 5) {
            if ($jam < $jam_buka_jumat) {
                // Belum buka
                $today_open = clone $waktu;
                $today_open->setTime(8, 0, 0);

                return [
                    'is_working_hours' => false,
                    'message' => 'Maaf, layanan belum dibuka. Jam operasional hari Jumat: 08.00 - 14.00 WIB.',
                    'jam_kerja' => $this->Get_Jam_Kerja_Info(),
                    'next_open' => $today_open->format('H:i') . ' WIB',
                ];
            } elseif ($jam >= $jam_tutup_jumat) {
                // Sudah tutup
                $next_monday = clone $waktu;
                $next_monday->modify('next monday');
                $next_monday->setTime(8, 0, 0);

                return [
                    'is_working_hours' => false,
                    'message' => 'Maaf, layanan telah ditutup. Jam operasional hari Jumat: 08.00 - 14.00 WIB.',
                    'jam_kerja' => $this->Get_Jam_Kerja_Info(),
                    'next_open' => $next_monday->format('l, d F Y H:i') . ' WIB',
                ];
            }

            // Dalam jam kerja Jumat
            $close_time = clone $waktu;
            $close_time->setTime(14, 0, 0);

            return [
                'is_working_hours' => true,
                'message' => 'Layanan tersedia. Jam operasional hari Jumat: 08.00 - 14.00 WIB.',
                'jam_kerja' => $this->Get_Jam_Kerja_Info(),
                'will_close_at' => $close_time->format('H:i') . ' WIB',
            ];
        }

        // Cek Senin - Kamis (1 - 4)
        if ($jam < $jam_buka_senin_kamis) {
            // Belum buka
            $today_open = clone $waktu;
            $today_open->setTime(8, 0, 0);

            return [
                'is_working_hours' => false,
                'message' => 'Maaf, layanan belum dibuka. Jam operasional hari ini: 08.00 - 16.00 WIB.',
                'jam_kerja' => $this->Get_Jam_Kerja_Info(),
                'next_open' => $today_open->format('H:i') . ' WIB',
            ];
        } elseif ($jam >= $jam_tutup_senin_kamis) {
            // Sudah tutup
            $next_day = clone $waktu;
            $next_day->modify('tomorrow');
            $next_day->setTime(8, 0, 0);

            return [
                'is_working_hours' => false,
                'message' => 'Maaf, layanan telah ditutup. Jam operasional hari ini: 08.00 - 16.00 WIB.',
                'jam_kerja' => $this->Get_Jam_Kerja_Info(),
                'next_open' => $next_day->format('l, d F Y H:i') . ' WIB',
            ];
        }

        // Dalam jam kerja Senin - Kamis
        $close_time = clone $waktu;
        $close_time->setTime(16, 0, 0);

        return [
            'is_working_hours' => true,
            'message' => 'Layanan tersedia. Jam operasional hari ini: 08.00 - 16.00 WIB.',
            'jam_kerja' => $this->Get_Jam_Kerja_Info(),
            'will_close_at' => $close_time->format('H:i') . ' WIB',
        ];
    }

    /**
     * Tambah antrian online baru
     */
    public function Tambah_Antrian(Request $request)
    {
        // VALIDASI JAM KERJA
        $cek_jam_kerja = $this->Cek_Jam_Kerja();

        if (!$cek_jam_kerja['is_working_hours']) {
            return response()->json([
                'success' => false,
                'message' => 'Di Luar Jam Kerja',
                'errors' => [
                    'jam_kerja' => $cek_jam_kerja['message'],
                ],
                'jam_kerja_info' => $cek_jam_kerja['jam_kerja'],
                'next_open' => $cek_jam_kerja['next_open'] ?? null,
            ], 422);
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|digits:16',
            'layanan_id' => 'required|exists:layanan,layanan_id',
            'nama_lengkap' => 'required|string|max:100',
            'alamat' => 'required|string',
        ], [
            'nik.required' => 'NIK wajib diisi',
            'nik.digits' => 'NIK harus 16 digit',
            'layanan_id.required' => 'Layanan wajib dipilih',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Generate nomor antrian dengan format ABC-123-456
        $nomor_antrian = $this->Generate_Nomor_Antrian();

        // Cek apakah nomor antrian sudah ada
        while (Antrian_Online_Model::where('nomor_antrian', $nomor_antrian)->exists()) {
            $nomor_antrian = $this->Generate_Nomor_Antrian();
        }

        // Buat antrian baru
        $antrian = Antrian_Online_Model::create([
            'nomor_antrian' => $nomor_antrian,
            'nik' => $request->nik, // NIK akan di-encrypt oleh model trait
            'nama_lengkap' => $request->nama_lengkap,
            'alamat' => $request->alamat,
            'layanan_id' => $request->layanan_id,
            'status_antrian' => 'Menunggu',
        ]);

        // Buat status awal lacak berkas
        Lacak_Berkas_Model::create([
            'antrian_online_id' => $antrian->antrian_online_id,
            'status' => 'Menunggu',
            'tanggal' => date('Y-m-d'),
            'keterangan' => 'Antrian berhasil dibuat. Menunggu dokumen diterima oleh admin.',
        ]);

        // Load relasi layanan untuk response
        $antrian->load('layanan');

        return response()->json([
            'success' => true,
            'message' => 'Antrian berhasil dibuat',
            'data' => [
                'nomor_antrian' => $nomor_antrian,
                'nama_lengkap' => $antrian->nama_lengkap,
                'layanan' => $antrian->layanan->nama_layanan,
            ],
            'redirect' => route('antrian-online') . '?success=' . urlencode('Antrian berhasil dibuat!'),
        ], 201);
    }

    /**
     * Cari antrian berdasarkan nama dan/atau nomor antrian
     */
    public function Cari_Antrian(Request $request)
    {
        $query = Antrian_Online_Model::query();

        if ($request->has('nama_lengkap')) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_lengkap . '%');
        }

        if ($request->has('nomor_antrian')) {
            $query->where('nomor_antrian', $request->nomor_antrian);
        }

        if ($request->has('layanan_id')) {
            $query->where('layanan_id', $request->layanan_id);
        }

        $data_antrian = $query->with(['layanan', 'lacak_berkas'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data_antrian,
        ]);
    }

    /**
     * Get detail antrian
     */
    public function Get_Detail_Antrian($nomor_antrian)
    {
        $antrian = Antrian_Online_Model::with(['layanan', 'lacak_berkas'])
            ->where('nomor_antrian', $nomor_antrian)
            ->first();

        if (!$antrian) {
            return response()->json([
                'success' => false,
                'message' => 'Antrian tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $antrian,
        ]);
    }

    /**
     * Get statistik antrian hari ini
     */
    public function Get_Statistik_Antrian()
    {
        $hari_ini = date('Y-m-d');

        $total_antrian = Antrian_Online_Model::whereDate('created_at', $hari_ini)->count();

        // Antrian menunggu
        $antrian_menunggu = Antrian_Online_Model::whereDate('created_at', $hari_ini)
            ->where('status_antrian', 'Menunggu')
            ->count();

        // Antrian diproses (semua status kecuali Menunggu, Ditolak, Dibatalkan, Siap Pengambilan)
        $status_diproses = ['Dokumen Diterima', 'Verifikasi Data', 'Proses Cetak'];
        $antrian_diproses = Antrian_Online_Model::whereDate('created_at', $hari_ini)
            ->whereIn('status_antrian', $status_diproses)
            ->count();

        // Antrian selesai (Siap Pengambilan)
        $antrian_selesai = Antrian_Online_Model::whereDate('created_at', $hari_ini)
            ->where('status_antrian', 'Siap Pengambilan')
            ->count();

        return response()->json([
            'success' => true,
            'data' => [
                'total_antrian' => $total_antrian,
                'antrian_menunggu' => $antrian_menunggu,
                'antrian_diproses' => $antrian_diproses,
                'antrian_selesai' => $antrian_selesai,
            ],
        ]);
    }

    /**
     * Get semua layanan
     */
    public function Get_Layanan()
    {
        $data_layanan = Layanan_Model::all();

        return response()->json([
            'success' => true,
            'data' => $data_layanan,
        ]);
    }

    /**
     * Lacak berkas berdasarkan nomor antrian atau nama lengkap
     */
    public function Lacak_Berkas(Request $request)
    {
        // Cari berdasarkan nomor antrian atau nama lengkap
        $search = $request->input('search', '');

        if (empty($search)) {
            return response()->json([
                'success' => false,
                'message' => 'Masukkan nomor antrian atau nama lengkap untuk melacak berkas',
            ], 400);
        }

        $antrian = Antrian_Online_Model::with(['layanan', 'lacak_berkas' => function($q) {
            $q->orderBy('created_at', 'asc');
        }])
        ->where(function($q) use ($search) {
            $q->where('nomor_antrian', 'like', '%' . $search . '%')
              ->orWhere('nama_lengkap', 'like', '%' . $search . '%');
        })
        ->first();

        if (!$antrian) {
            return response()->json([
                'success' => false,
                'message' => 'Data antrian tidak ditemukan. Silakan periksa kembali nomor antrian atau nama lengkap Anda.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'antrian_online_id' => $antrian->antrian_online_id,
                'nomor_antrian' => $antrian->nomor_antrian,
                'nama_lengkap' => $antrian->nama_lengkap,
                'status_antrian' => $antrian->status_antrian,
                'layanan' => $antrian->layanan ? $antrian->layanan->nama_layanan : '-',
                'created_at' => $antrian->created_at,
                'riwayat' => $antrian->lacak_berkas,
            ],
        ]);
    }

    /**
     * Generate nomor antrian dengan format ABC-123-456
     */
    private function Generate_Nomor_Antrian()
    {
        // Generate 3 huruf acak
        $huruf = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3));

        // Generate 3 angka acak untuk bagian pertama
        $angka1 = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);

        // Generate 3 angka acak untuk bagian kedua
        $angka2 = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);

        return "{$huruf}-{$angka1}-{$angka2}";
    }

    /**
     * Get data antrian by nomor antrian untuk auto-fill form layanan
     *
     * GET /antrian-online/get-data/{nomor_antrian}
     *
     * @param string $nomor_antrian
     * @return \Illuminate\Http\JsonResponse
     */
    public function Get_Data_Antrian($nomor_antrian)
    {
        $antrian = Antrian_Online_Model::where('nomor_antrian', $nomor_antrian)->first();

        if (!$antrian) {
            return response()->json([
                'success' => false,
                'message' => 'Antrian tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'nama_lengkap' => $antrian->nama_lengkap,
                'alamat' => $antrian->alamat,
            ]
        ]);
    }

    /**
     * Cari Antrian (POST) - untuk AJAX request dari halaman antrian-online
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Cari_Antrian_Post(Request $request)
    {
        $nama = $request->input('nama', '');

        if (empty($nama)) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan masukkan nama lengkap untuk mencari antrian',
            ], 400);
        }

        // Cari berdasarkan nama lengkap
        $data_antrian = Antrian_Online_Model::with(['layanan'])
            ->where('nama_lengkap', 'like', '%' . $nama . '%')
            ->orderBy('created_at', 'desc')
            ->limit(10) // Batasi hasil agar tidak terlalu banyak
            ->get();

        // Format data untuk response
        $formatted_data = $data_antrian->map(function($item) {
            return [
                'antrian_online_id' => $item->antrian_online_id,
                'nomor_antrian' => $item->nomor_antrian,
                'nama_lengkap' => $item->nama_lengkap,
                'status_antrian' => $item->status_antrian,
                'nama_layanan' => $item->layanan ? $item->layanan->nama_layanan : '-',
                'created_at' => $item->created_at->format('d M Y H:i'),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $formatted_data,
            'message' => $formatted_data->isEmpty()
                ? 'Tidak ditemukan antrian dengan nama "' . $nama . '"'
                : 'Ditemukan ' . $formatted_data->count() . ' antrian untuk nama "' . $nama . '"',
        ]);
    }

    /**
     * Lacak Berkas (POST) - untuk AJAX request dari halaman antrian-online
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Lacak_Berkas_Post(Request $request)
    {
        $search = $request->input('search', '');

        if (empty($search)) {
            return response()->json([
                'success' => false,
                'message' => 'Masukkan nama atau nomor antrian untuk melacak berkas',
            ], 400);
        }

        // Cari berdasarkan nomor antrian atau nama lengkap
        $antrian = Antrian_Online_Model::with(['layanan', 'lacak_berkas' => function($q) {
            $q->orderBy('created_at', 'asc');
        }])
        ->where(function($q) use ($search) {
            $q->where('nomor_antrian', 'like', '%' . $search . '%')
              ->orWhere('nama_lengkap', 'like', '%' . $search . '%');
        })
        ->first();

        if (!$antrian) {
            return response()->json([
                'success' => false,
                'message' => 'Data antrian tidak ditemukan. Silakan periksa kembali nama atau nomor antrian Anda.',
            ], 404);
        }

        // Format riwayat untuk timeline
        $riwayat = $antrian->lacak_berkas->map(function($item) {
            return [
                'status' => $item->status,
                'keterangan' => $item->keterangan,
                'tanggal' => $item->created_at->format('d M Y H:i'),
            ];
        });

        // Tambahkan status awal "Menunggu" ke riwayat
        $riwayat_with_initial = collect([
            [
                'status' => 'Menunggu',
                'keterangan' => 'Antrian berhasil dibuat, menunggu verifikasi dokumen',
                'tanggal' => $antrian->created_at->format('d M Y H:i'),
            ]
        ])->merge($riwayat);

        return response()->json([
            'success' => true,
            'data' => [
                'antrian_online_id' => $antrian->antrian_online_id,
                'nomor_antrian' => $antrian->nomor_antrian,
                'nama_lengkap' => $antrian->nama_lengkap,
                'status_antrian' => $antrian->status_antrian,
                'nama_layanan' => $antrian->layanan ? $antrian->layanan->nama_layanan : '-',
                'riwayat' => $riwayat_with_initial,
            ],
        ]);
    }
}
