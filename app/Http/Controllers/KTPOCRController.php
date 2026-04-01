<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

/**
 * KTPOCRController
 *
 * Controller untuk menangani OCR KTP extraction.
 * Berkomunikasi dengan Python OCR API service.
 *
 * Created by: Senior Full-stack Developer
 * Date: 2026-03-20
 */
class KTPOCRController extends Controller
{
    /**
     * URL Python OCR API Service
     *
     * @var string
     */
    protected $ocrApiUrl;

    /**
     * Constructor
     */
    public function __construct()
    {
        // URL Python OCR API (sesuaikan dengan deployment)
        $this->ocrApiUrl = env('OCR_API_URL', 'http://127.0.0.1:8000');
    }

    /**
     * Extract KTP data dari uploaded image
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function extract(Request $request)
    {
        try {
            // Validate request
            $validator = Validator::make($request->all(), [
                'ktp_image' => 'required|image|mimes:png,jpg,jpeg|max:5120', // Max 5MB
            ], [
                'ktp_image.required' => 'Gambar KTP harus diupload',
                'ktp_image.image' => 'File harus berupa gambar',
                'ktp_image.mimes' => 'Format gambar harus PNG, JPG, atau JPEG',
                'ktp_image.max' => 'Ukuran gambar maksimal 5MB',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Get uploaded file
            $file = $request->file('ktp_image');

            // Log request
            Log::info('KTP OCR Request', [
                'filename' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime' => $file->getMimeType(),
            ]);

            // Prepare multipart data
            $multipart = [
                [
                    'name' => 'file',
                    'contents' => fopen($file->getRealPath(), 'r'),
                    'filename' => $file->getClientOriginalName(),
                ]
            ];

            // Send request to Python OCR API
            $response = Http::timeout(30)->attach(
                'file',
                file_get_contents($file->getRealPath()),
                $file->getClientOriginalName()
            )->post($this->ocrApiUrl . '/api/extract-ktp');

            // Log response
            Log::info('KTP OCR Response', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            // Check if request was successful
            if ($response->successful()) {
                $data = $response->json();

                return response()->json([
                    'success' => true,
                    'message' => 'Data KTP berhasil diekstrak',
                    'data' => [
                        'nik' => $data['data']['nik'] ?? null,
                        'nama' => $data['data']['nama'] ?? null,
                        'tanggal_lahir' => $data['data']['tanggal_lahir'] ?? null,
                        'alamat' => $data['data']['alamat'] ?? null,
                    ],
                    'confidence' => $data['confidence'] ?? 0,
                    'raw_texts' => $data['raw_texts'] ?? [],
                ]);
            } else {
                // Handle API error
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengekstrak data KTP',
                    'error' => $response->json()['error'] ?? 'Unknown error',
                ], $response->status());
            }

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            // Connection error (Python API tidak running)
            Log::error('OCR API Connection Error', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'OCR Service tidak tersedia. Silakan hubungi admin.',
                'error' => 'connection_error',
            ], 503);

        } catch (\Exception $e) {
            // General error
            Log::error('KTP OCR Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem',
                'error' => 'system_error',
            ], 500);
        }
    }

    /**
     * Health check untuk OCR service
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function healthCheck()
    {
        try {
            $response = Http::timeout(5)->get($this->ocrApiUrl . '/health');

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'status' => 'healthy',
                    'ocr_service' => $response->json(),
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'status' => 'unhealthy',
                ], 503);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status' => 'unhealthy',
                'error' => $e->getMessage(),
            ], 503);
        }
    }
}
