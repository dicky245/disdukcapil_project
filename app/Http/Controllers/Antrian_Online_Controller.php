<?php

namespace App\Http\Controllers;

use App\Exceptions\KtpOcrException;
use App\Models\Antrian_Online_Model;
use App\Models\AntrianOnline;
use App\Models\Lacak_Berkas_Model;
use App\Models\Layanan_Model;
use App\Services\FileEncryptionService;
use App\Services\KtpOcrService;
use App\Services\EasyOcrService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Antrian_Online_Controller extends Controller
{
    private FileEncryptionService $fileEncryption;

    private KtpOcrService $ktpOcrService;

    private EasyOcrService $easyOcrService;

    /**
     * Lifetime sesi draft sebelum dianggap expired (detik).
     */
    private const DRAFT_TTL_SECONDS = 1800; // 30 menit

    public function __construct(
        FileEncryptionService $fileEncryption, 
        KtpOcrService $ktpOcrService,
        EasyOcrService $easyOcrService
    )
    {
        $this->fileEncryption = $fileEncryption;
        $this->ktpOcrService = $ktpOcrService;
        $this->easyOcrService = $easyOcrService;
    }

    /**
     * Tampilkan halaman antrian online
     */
    public function Tampil_Antrian()
    {
        $data_layanan = Layanan_Model::all();
        $jam_kerja = $this->Get_Jam_Kerja_Info();
        
        // Konfigurasi OCR untuk client-side
        // EasyOCR adalah metode utama untuk extract data KTP
        $ocrClientConfig = [
            // Endpoint untuk proses OCR dengan EasyOCR
            'easyOcrEnabled' => true,
            'easyOcrUploadUrl' => url('/api/ocr/process'),
            // Endpoint untuk simpan antrian
            'storeUrl' => route('antrian.store'),
        ];

        return view('pages.antrian-online', compact('data_layanan', 'jam_kerja', 'ocrClientConfig'));
    }

    /**
     * Get jam kerja information untuk display
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
                'next_open' => $next_monday->format('l, d F Y H:i').' WIB',
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
                    'next_open' => $today_open->format('H:i').' WIB',
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
                    'next_open' => $next_monday->format('l, d F Y H:i').' WIB',
                ];
            }

            // Dalam jam kerja Jumat
            $close_time = clone $waktu;
            $close_time->setTime(14, 0, 0);

            return [
                'is_working_hours' => true,
                'message' => 'Layanan tersedia. Jam operasional hari Jumat: 08.00 - 14.00 WIB.',
                'jam_kerja' => $this->Get_Jam_Kerja_Info(),
                'will_close_at' => $close_time->format('H:i').' WIB',
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
                'next_open' => $today_open->format('H:i').' WIB',
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
                'next_open' => $next_day->format('l, d F Y H:i').' WIB',
            ];
        }

        // Dalam jam kerja Senin - Kamis
        $close_time = clone $waktu;
        $close_time->setTime(16, 0, 0);

        return [
            'is_working_hours' => true,
            'message' => 'Layanan tersedia. Jam operasional hari ini: 08.00 - 16.00 WIB.',
            'jam_kerja' => $this->Get_Jam_Kerja_Info(),
            'will_close_at' => $close_time->format('H:i').' WIB',
        ];
    }

    /**
     * Tambah antrian online baru
     */
    public function Tambah_Antrian(Request $request)
    {
        try {
            // Cek jam kerja terlebih dahulu
            // $jam_kerja_check = $this->Cek_Jam_Kerja();

            // if (! $jam_kerja_check['is_working_hours']) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => $jam_kerja_check['message'],
            //         'error' => 'OUTSIDE_WORKING_HOURS',
            //         'jam_kerja' => $jam_kerja_check['jam_kerja'],
            //         'next_open' => $jam_kerja_check['next_open'] ?? null,
            //     ], 403);
            // }

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
                \Log::warning('Validasi gagal saat membuat antrian', [
                    'errors' => $validator->errors()->toArray(),
                    'input' => $request->all(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Gunakan database transaction untuk memastikan atomicity
            return \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
                // Generate nomor antrian dengan format ABC-123-456
                $nomor_antrian = $this->Generate_Nomor_Antrian();

                \Log::info('Generated nomor antrian: '.$nomor_antrian);

                // Cek apakah nomor antrian sudah ada
                $maxAttempts = 10;
                $attempts = 0;

                while (Antrian_Online_Model::where('nomor_antrian', $nomor_antrian)->exists()) {
                    $nomor_antrian = $this->Generate_Nomor_Antrian();
                    $attempts++;

                    if ($attempts >= $maxAttempts) {
                        throw new \Exception('Gagal generate nomor antrian unik setelah '.$maxAttempts.' percobaan');
                    }
                }

                \Log::info('Final nomor antrian: '.$nomor_antrian.' (length: '.strlen($nomor_antrian).')');

                // Persiapkan data untuk create
                $data_antrian = [
                    'nomor_antrian' => $nomor_antrian,
                    'nik' => $request->nik,
                    'nama_lengkap' => $request->nama_lengkap,
                    'alamat' => $request->alamat,
                    'layanan_id' => $request->layanan_id,
                    'status_antrian' => 'Menunggu',
                ];

                \Log::info('Data antrian yang akan disimpan:', $data_antrian);

                // Buat antrian baru
                $antrian = Antrian_Online_Model::create($data_antrian);

                \Log::info('Antrian berhasil dibuat dengan ID: '.$antrian->antrian_online_id);

                // Buat status awal lacak berkas
                Lacak_Berkas_Model::create([
                    'antrian_online_id' => $antrian->antrian_online_id,
                    'status' => 'Menunggu',
                    'tanggal' => date('Y-m-d'),
                    'keterangan' => 'Antrian berhasil dibuat. Menunggu dokumen diterima oleh admin.',
                ]);

                // Load relasi layanan untuk response
                $antrian->load('layanan');

                \Log::info('Response yang akan dikirim:', [
                    'nomor_antrian' => $antrian->nomor_antrian,
                    'nama_lengkap' => $antrian->nama_lengkap,
                    'layanan' => $antrian->layanan->nama_layanan,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Antrian berhasil dibuat',
                    'data' => [
                        'nomor_antrian' => $nomor_antrian,
                        'nama_lengkap' => $antrian->nama_lengkap,
                        'layanan' => $antrian->layanan->nama_layanan,
                    ],
                    'redirect' => route('antrian-online').'?success='.urlencode('Antrian berhasil dibuat!'),
                ], 201);
            });

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error creating antrian', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat membuat antrian: '.$e->getMessage(),
                'error' => 'SYSTEM_ERROR',
            ], 500);
        }
    }

    /**
     * Cari antrian berdasarkan nama dan/atau nomor antrian
     */
    public function Cari_Antrian(Request $request)
    {
        $query = Antrian_Online_Model::query();

        if ($request->has('nama_lengkap')) {
            $searchTerm = $request->nama_lengkap;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama_lengkap', 'like', '%'.$searchTerm.'%')
                    ->orWhere('nomor_antrian', 'like', '%'.$searchTerm.'%');
            });
        }

        if ($request->has('nomor_antrian')) {
            $query->where('nomor_antrian', $request->nomor_antrian);
        }

        if ($request->has('layanan_id') && $request->layanan_id) {
            $query->where('layanan_id', $request->layanan_id);
        }

        $data_antrian = $query->with(['layanan', 'lacak_berkas'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
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

        if (! $antrian) {
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

        $antrian = Antrian_Online_Model::with(['layanan', 'lacak_berkas' => function ($q) {
            $q->orderBy('created_at', 'asc');
        }])
            ->where(function ($q) use ($search) {
                $q->where('nomor_antrian', 'like', '%'.$search.'%')
                    ->orWhere('nama_lengkap', 'like', '%'.$search.'%');
            })
            ->first();

        if (! $antrian) {
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
     * STEP 1A — OCR dengan EasyOCR (prioritas utama).
     * 
     * Endpoint: POST /api/ocr/process
     * Body multipart: ktp_image, antrian_id (optional)
     */
    public function Proses_Ocr_Easy(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'ktp_image' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'antrian_id' => 'nullable|string|exists:antrian_online,antrian_online_id',
        ], [
            'ktp_image.required' => 'Gambar KTP wajib diunggah.',
            'ktp_image.image' => 'File harus berupa gambar.',
            'ktp_image.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
            'ktp_image.max' => 'Ukuran gambar maksimal 5 MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $file = $request->file('ktp_image');
        $antrianId = $request->input('antrian_id');

        Log::info('Antrian_Online_Controller: EasyOCR processing started', [
            'antrian_id' => $antrianId,
            'file_size' => $file->getSize(),
        ]);

        try {
            // Proses dengan EasyOCR
            $result = $this->easyOcrService->processKtpImage($file, $antrianId);

            if (!$result['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'] ?? 'Gagal memproses OCR',
                    'errors' => ['ocr' => $result['message'] ?? 'OCR processing failed'],
                ], 422);
            }

            // Ekstrak data dari hasil OCR
            $ocrData = $result['data'] ?? [];
            $confidence = $result['confidence'] ?? 0;
            $fieldConfidence = $ocrData['field_confidence'] ?? [];

            Log::info('Antrian_Online_Controller: EasyOCR completed', [
                'antrian_id' => $antrianId,
                'confidence' => $confidence,
                'has_nik' => !empty($ocrData['nik']),
                'has_nama' => !empty($ocrData['nama_lengkap']),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'OCR berhasil diproses',
                'data' => [
                    'antrian_id' => $antrianId,
                    'nik' => $ocrData['nik'] ?? '',
                    'nama_lengkap' => $ocrData['nama_lengkap'] ?? '',
                    'tempat_lahir' => $ocrData['tempat_lahir'] ?? '',
                    'tanggal_lahir' => $ocrData['tanggal_lahir'] ?? '',
                    'jenis_kelamin' => $ocrData['jenis_kelamin'] ?? '',
                    'gol_darah' => $ocrData['gol_darah'] ?? '',
                    'alamat' => $ocrData['alamat'] ?? '',
                    'rt_rw' => $ocrData['rt_rw'] ?? '',
                    'kel_desa' => $ocrData['kel_desa'] ?? '',
                    'kec' => $ocrData['kec'] ?? '',
                    'kab_kota' => $ocrData['kab_kota'] ?? '',
                    'provinsi' => $ocrData['provinsi'] ?? '',
                    'agama' => $ocrData['agama'] ?? '',
                    'status_perkawinan' => $ocrData['status_perkawinan'] ?? '',
                    'pekerjaan' => $ocrData['pekerjaan'] ?? '',
                    'kewarganegaraan' => $ocrData['kewarganegaraan'] ?? '',
                    'berlaku_hingga' => $ocrData['berlaku_hingga'] ?? '',
                    'confidence' => $confidence,
                    'field_confidence' => $fieldConfidence,
                    'ocr_source' => 'easyocr',
                ],
                'confidence' => $confidence,
            ], 200);

        } catch (\Throwable $e) {
            Log::error('Antrian_Online_Controller: EasyOCR error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses OCR: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * STEP 1B — OCR dengan Google Vision (fallback).
     * 
     * Endpoint: POST /api/ocr/process-vision
     */
    public function Proses_Ocr_Vision(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'ktp_image' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'antrian_id' => 'nullable|string|exists:antrian_online,antrian_online_id',
        ], [
            'ktp_image.required' => 'Gambar KTP wajib diunggah.',
            'ktp_image.image' => 'File harus berupa gambar.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $file = $request->file('ktp_image');
        $antrianId = $request->input('antrian_id');

        try {
            // Gunakan KtpOcrService untuk Google Vision
            $result = $this->ktpOcrService->uploadToGcp($antrianId ?? 'temp_' . time(), $file);

            if (($result['status'] ?? '') === 'processed') {
                $parsed = $result['raw']['parsed'] ?? [];
                $confidence = $result['raw']['confidence'] ?? 0.9;

                return response()->json([
                    'success' => true,
                    'message' => 'OCR berhasil diproses',
                    'data' => [
                        'antrian_id' => $antrianId,
                        'nik' => $parsed['nik'] ?? '',
                        'nama_lengkap' => $parsed['nama_lengkap'] ?? '',
                        'alamat' => $parsed['alamat'] ?? '',
                        'confidence' => $confidence,
                        'field_confidence' => [
                            'nik' => !empty($parsed['nik']) ? 0.95 : 0,
                            'nama_lengkap' => !empty($parsed['nama_lengkap']) ? 0.90 : 0,
                            'alamat' => !empty($parsed['alamat']) ? 0.90 : 0,
                        ],
                        'ocr_source' => 'google_vision',
                    ],
                    'confidence' => $confidence,
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'OCR belum selesai diproses',
            ], 202);

        } catch (\Throwable $e) {
            Log::error('Antrian_Online_Controller: Google Vision OCR error', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses dengan Google Vision: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * STEP 1 — Buat draft antrian + kirim KTP ke GCP OCR.
     *
     * Endpoint: POST /antrian-online/draft
     * Body multipart: layanan_id, ktp_image
     *
     * Flow:
     *  1. Validasi input.
     *  2. Buat baris antrian_online (status=Menunggu, nama placeholder, NIK/alamat null).
     *  3. Buat lacak_berkas awal.
     *  4. Kirim KTP ke Cloud Function http-ktp via KtpOcrService.
     *  5. Status pindah ke 'Verifikasi Data'.
     *  6. Simpan ID draft ke session untuk proteksi polling/finalize.
     */
    public function Buat_Draft_Antrian(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'layanan_id' => 'required|string|exists:layanan,layanan_id',
            'ktp_image' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ], [
            'layanan_id.required' => 'Layanan wajib dipilih.',
            'layanan_id.exists' => 'Layanan tidak ditemukan.',
            'ktp_image.required' => 'Gambar KTP wajib diunggah.',
            'ktp_image.image' => 'File harus berupa gambar.',
            'ktp_image.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
            'ktp_image.max' => 'Ukuran gambar maksimal 5 MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'data' => ['errors' => $validator->errors()],
            ], 422);
        }

        $file = $request->file('ktp_image');
        $layananId = (string) $request->input('layanan_id');

        $antrian = null;

        try {
            $antrian = DB::transaction(function () use ($layananId): AntrianOnline {
                $nomor = $this->Generate_Nomor_Antrian();
                $maxAttempts = 10;
                $attempts = 0;
                while (AntrianOnline::query()->where('nomor_antrian', $nomor)->exists()) {
                    $nomor = $this->Generate_Nomor_Antrian();
                    if (++$attempts >= $maxAttempts) {
                        throw new \RuntimeException('Gagal generate nomor antrian unik.');
                    }
                }

                $draft = AntrianOnline::create([
                    'antrian_online_id' => (string) Str::uuid(),
                    'nomor_antrian' => $nomor,
                    'nama_lengkap' => 'Menunggu OCR',
                    'nik' => null,
                    'alamat' => null,
                    'layanan_id' => $layananId,
                    'status_antrian' => AntrianOnline::STATUS_MENUNGGU,
                ]);

                Lacak_Berkas_Model::create([
                    'antrian_online_id' => $draft->antrian_online_id,
                    'status' => 'Menunggu',
                    'tanggal' => date('Y-m-d'),
                    'keterangan' => 'Draft dibuat, KTP sedang diunggah ke layanan OCR.',
                ]);

                return $draft;
            });

            $uploadResult = $this->ktpOcrService->uploadToGcp($antrian->antrian_online_id, $file);

            if (($uploadResult['status'] ?? '') !== 'processed') {
                $antrian->status_antrian = AntrianOnline::STATUS_VERIFIKASI;
                $antrian->save();
            } else {
                $antrian->refresh();
            }

            session()->put('ktp_draft_id', $antrian->antrian_online_id);
            session()->put('ktp_draft_expires_at', now()->addSeconds(self::DRAFT_TTL_SECONDS)->getTimestamp());

            Log::info('Antrian_Online_Controller: draft created and KTP sent to GCP.', [
                'antrian_online_id' => $antrian->antrian_online_id,
                'gcs_path' => $uploadResult['gcs_path'] ?? null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Draft antrian dibuat. KTP sedang diproses oleh layanan OCR.',
                'data' => [
                    'antrian_online_id' => $antrian->antrian_online_id,
                    'nomor_antrian' => $antrian->nomor_antrian,
                    'status_antrian' => $antrian->status_antrian,
                    'file_id' => $uploadResult['file_id'] ?? null,
                ],
            ], 202);
        } catch (KtpOcrException $e) {
            $this->Hapus_Draft_Sementara($antrian);

            Log::error('Antrian_Online_Controller: gagal upload KTP ke GCP.', [
                'antrian_online_id' => optional($antrian)->antrian_online_id,
                'error' => $e->getMessage(),
                'context' => $e->context(),
            ]);

            $payload = [
                'error_code' => 'GCP_UPLOAD_FAILED',
            ];
            if (config('app.debug')) {
                $payload['diagnostic'] = array_merge(
                    ['exception_message' => $e->getMessage()],
                    $e->context()
                );
            }

            $userMessage = 'Gagal memproses OCR KTP dengan Google Vision. Silakan coba lagi.';
            $ctx = $e->context();
            if (isset($ctx['vision_error_code']) || isset($ctx['vision_error_message'])) {
                $userMessage .= ' (Periksa kredensial service account, Vision API, dan izin akses.)';
            }

            return response()->json([
                'success' => false,
                'message' => $userMessage,
                'data' => $payload,
            ], 502);
        } catch (\Throwable $e) {
            $this->Hapus_Draft_Sementara($antrian);

            Log::error('Antrian_Online_Controller: error tak terduga saat membuat draft.', [
                'antrian_online_id' => optional($antrian)->antrian_online_id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan. Silakan coba lagi.',
                'data' => null,
            ], 500);
        }
    }

    /**
     * STEP 2 — Polling status OCR untuk draft.
     *
     * Endpoint: GET /antrian-online/draft/{antrian_online_id}/ocr-status
     *
     * NIK dikembalikan APA ADANYA (tanpa masking) karena pemilik sesi
     * sedang melakukan verifikasi data dirinya sendiri.
     */
    public function Get_Ocr_Status_Draft(string $antrianId): JsonResponse
    {
        if (! $this->Pemilik_Draft_Valid($antrianId)) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi draft antrian tidak valid atau sudah kedaluwarsa.',
                'data' => null,
            ], 403);
        }

        /** @var AntrianOnline|null $antrian */
        $antrian = AntrianOnline::query()->where('antrian_online_id', $antrianId)->first();
        if ($antrian === null) {
            return response()->json([
                'success' => false,
                'message' => 'Draft antrian tidak ditemukan.',
                'data' => null,
            ], 404);
        }

        $hasNik = $antrian->nik !== null && $antrian->nik !== '';
        $hasNama = $antrian->nama_lengkap !== null
            && $antrian->nama_lengkap !== ''
            && $antrian->nama_lengkap !== 'Menunggu OCR';
        $hasAlamat = $antrian->alamat !== null && trim((string) $antrian->alamat) !== '';

        $dokumenDariOcr = $antrian->status_antrian === AntrianOnline::STATUS_DOKUMEN_DITERIMA;
        $ready = $dokumenDariOcr && ($hasNik || $hasNama || $hasAlamat);

        $ocrMeta = Cache::get(KtpOcrService::OCR_META_CACHE_PREFIX.$antrianId);

        return response()->json([
            'success' => true,
            'message' => $ready ? 'OCR selesai.' : 'OCR masih diproses.',
            'data' => [
                'ready' => $ready,
                'antrian_online_id' => $antrian->antrian_online_id,
                'status_antrian' => $antrian->status_antrian,
                'nik' => $hasNik ? $antrian->nik : null,
                'nama_lengkap' => $hasNama ? $antrian->nama_lengkap : null,
                'alamat' => $hasAlamat ? $antrian->alamat : null,
                'ocr' => is_array($ocrMeta) ? $ocrMeta : null,
            ],
        ]);
    }

    /**
     * STEP 3 — Finalisasi draft menjadi antrian definitif.
     *
     * Endpoint: POST /antrian-online/finalize/{antrian_online_id}
     *
     * Body JSON: nik (16 digit), nama_lengkap, alamat
     * (data sudah diverifikasi/diedit user di Step 2).
     */
    public function Finalisasi_Antrian(Request $request, string $antrianId): JsonResponse
    {
        if (! $this->Pemilik_Draft_Valid($antrianId)) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi draft antrian tidak valid atau sudah kedaluwarsa.',
                'data' => null,
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|digits:16',
            'nama_lengkap' => [
                'required',
                'string',
                'max:100',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if (strcasecmp(trim((string) $value), 'Menunggu OCR') === 0) {
                        $fail('Nama tidak boleh berupa placeholder sistem; isi sesuai KTP.');
                    }
                },
            ],
            'alamat' => 'required|string|max:500',
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus 16 digit angka.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_lengkap.max' => 'Nama lengkap maksimal 100 karakter.',
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.max' => 'Alamat maksimal 500 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'data' => ['errors' => $validator->errors()],
            ], 422);
        }

        try {
            $antrian = DB::transaction(function () use ($antrianId, $request): AntrianOnline {
                /** @var AntrianOnline $draft */
                $draft = AntrianOnline::query()
                    ->lockForUpdate()
                    ->where('antrian_online_id', $antrianId)
                    ->firstOrFail();

                $draft->nik = (string) $request->input('nik');
                $draft->nama_lengkap = mb_substr((string) $request->input('nama_lengkap'), 0, 100);
                $draft->alamat = (string) $request->input('alamat');
                $draft->status_antrian = AntrianOnline::STATUS_DOKUMEN_DITERIMA;
                $draft->save();

                Lacak_Berkas_Model::create([
                    'antrian_online_id' => $draft->antrian_online_id,
                    'status' => AntrianOnline::STATUS_DOKUMEN_DITERIMA,
                    'tanggal' => date('Y-m-d'),
                    'keterangan' => 'Data KTP diverifikasi pengunjung dan antrian dikonfirmasi.',
                ]);

                return $draft;
            });

            session()->forget(['ktp_draft_id', 'ktp_draft_expires_at']);
            KtpOcrService::forgetOcrMetaCache($antrianId);

            $antrian->load('layanan');

            return response()->json([
                'success' => true,
                'message' => 'Antrian berhasil dikonfirmasi.',
                'data' => [
                    'antrian_online_id' => $antrian->antrian_online_id,
                    'nomor_antrian' => $antrian->nomor_antrian,
                    'nama_lengkap' => $antrian->nama_lengkap,
                    'status_antrian' => $antrian->status_antrian,
                    'layanan' => $antrian->layanan?->nama_layanan ?? '-',
                ],
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            return response()->json([
                'success' => false,
                'message' => 'Draft antrian tidak ditemukan.',
                'data' => null,
            ], 404);
        } catch (\Throwable $e) {
            Log::error('Antrian_Online_Controller: gagal finalisasi antrian.', [
                'antrian_online_id' => $antrianId,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyelesaikan antrian.',
                'data' => null,
            ], 500);
        }
    }

    /**
     * Validasi sesi: ID draft harus cocok dengan yang tersimpan
     * di session dan belum melewati TTL.
     */
    private function Pemilik_Draft_Valid(string $antrianId): bool
    {
        $sessionId = session('ktp_draft_id');
        $expiresAt = (int) session('ktp_draft_expires_at', 0);

        if ($sessionId !== $antrianId) {
            return false;
        }
        if ($expiresAt > 0 && $expiresAt < now()->getTimestamp()) {
            session()->forget(['ktp_draft_id', 'ktp_draft_expires_at']);

            return false;
        }

        return true;
    }

    /**
     * Bersihkan draft yang gagal dibuat: hapus baris antrian + lacak_berkas.
     */
    private function Hapus_Draft_Sementara(?AntrianOnline $antrian): void
    {
        if ($antrian === null || empty($antrian->antrian_online_id)) {
            return;
        }

        try {
            DB::transaction(function () use ($antrian): void {
                Lacak_Berkas_Model::where('antrian_online_id', $antrian->antrian_online_id)->delete();
                AntrianOnline::where('antrian_online_id', $antrian->antrian_online_id)->delete();
            });
            KtpOcrService::forgetOcrMetaCache($antrian->antrian_online_id);
            session()->forget(['ktp_draft_id', 'ktp_draft_expires_at']);
        } catch (\Throwable $e) {
            Log::warning('Hapus_Draft_Sementara: gagal cleanup draft.', [
                'antrian_online_id' => $antrian->antrian_online_id,
                'error' => $e->getMessage(),
            ]);
        }
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

        $nomor_antrian = "{$huruf}-{$angka1}-{$angka2}";

        // Debug log untuk memastikan format benar
        \Log::info('Generated nomor antrian: '.$nomor_antrian.' (length: '.strlen($nomor_antrian).')');

        return $nomor_antrian;
    }

    /**
     * Get data antrian by nomor antrian untuk auto-fill form layanan
     *
     * GET /antrian-online/get-data/{nomor_antrian}
     *
     * @param  string  $nomor_antrian
     * @return \Illuminate\Http\JsonResponse
     */
    public function Get_Data_Antrian($nomor_antrian)
    {
        $antrian = Antrian_Online_Model::where('nomor_antrian', $nomor_antrian)->first();

        if (! $antrian) {
            return response()->json([
                'success' => false,
                'message' => 'Antrian tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'nama_lengkap' => $antrian->nama_lengkap,
                'alamat' => $antrian->alamat,
            ],
        ]);
    }

    /**
     * Cari Antrian (POST) - untuk AJAX request dari halaman antrian-online
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function Cari_Antrian_Post(Request $request)
    {
        $search = trim($request->input('nama', ''));
        $layananId = $request->input('layanan_id', '');

        if (empty($search)) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan masukkan nama lengkap atau nomor antrian untuk mencari',
            ], 400);
        }

        $query = Antrian_Online_Model::with(['layanan'])
            ->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%'.$search.'%')
                    ->orWhere('nomor_antrian', 'like', '%'.$search.'%');
            });

        if (! empty($layananId)) {
            $query->where('layanan_id', $layananId);
        }

        $data_antrian = $query->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $formatted_data = $data_antrian->map(function ($item) {
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
                ? 'Tidak ditemukan antrian dengan "'.$search.'"'
                : 'Ditemukan '.$formatted_data->count().' antrian untuk "'.$search.'"',
        ]);
    }

    /**
     * Lacak Berkas (POST) - untuk AJAX request dari halaman antrian-online
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function Lacak_Berkas_Post(Request $request)
    {
        $search = $request->input('search', '');
        $layananId = $request->input('layanan_id', '');

        if (empty($search)) {
            return response()->json([
                'success' => false,
                'message' => 'Masukkan nama atau nomor antrian untuk melacak berkas',
            ], 400);
        }

        // Cari berdasarkan nomor antrian atau nama lengkap dengan filter layanan
        $query = Antrian_Online_Model::with(['layanan', 'lacak_berkas' => function ($q) {
            $q->orderBy('created_at', 'asc');
        }])
            ->where(function ($q) use ($search) {
                $q->where('nomor_antrian', 'like', '%'.$search.'%')
                    ->orWhere('nama_lengkap', 'like', '%'.$search.'%');
            });

        // Terapkan filter layanan jika layanan_id diberikan
        if (!empty($layananId)) {
            $query->where('layanan_id', $layananId);
        }

        $antrian = $query->first();

        if (! $antrian) {
            return response()->json([
                'success' => false,
                'message' => 'Data antrian tidak ditemukan. Silakan periksa kembali nama atau nomor antrian Anda.',
            ], 404);
        }

        // Format riwayat untuk timeline
        $riwayat = $antrian->lacak_berkas->map(function ($item) {
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
            ],
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

    /**
     * Diagnostic endpoint untuk OCR system
     * GET /api/ocr/diagnose
     */
    public function Diagnose_Ocr(): JsonResponse
    {
        try {
            $diagnostic = $this->easyOcrService->diagnose();
            
            return response()->json([
                'success' => true,
                'message' => 'OCR diagnostic completed',
                'data' => $diagnostic,
            ]);
        } catch (\Throwable $e) {
            Log::error('OCR Diagnostic error', [
                'error' => $e->getMessage(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Diagnostic failed: ' . $e->getMessage(),
            ], 500);
        }
    }
}
