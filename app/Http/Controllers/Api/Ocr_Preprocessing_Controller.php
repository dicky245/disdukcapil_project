<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Image_Enhancement_Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Ocr_Preprocessing_Controller extends Controller
{
    protected Image_Enhancement_Service $imageService;

    public function __construct(Image_Enhancement_Service $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Handle document upload dan preprocessing
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Handle_Document_Upload(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'document_image' => 'required|file|mimes:png,jpg,jpeg|max:10240', // Max 10MB
            'options' => 'nullable|array',
            'options.grayscale' => 'nullable|boolean',
            'options.denoising' => 'nullable|boolean',
            'options.contrast' => 'nullable|boolean',
            'options.sharpen' => 'nullable|boolean',
            'options.threshold' => 'nullable|boolean',
            'options.blur_radius' => 'nullable|integer|min:1|max:5',
            'options.contrast_level' => 'nullable|integer|min:0|max:50',
            'options.threshold_level' => 'nullable|integer|min:0|max:255',
        ], [
            'document_image.required' => 'File dokumen harus diupload',
            'document_image.file' => 'File harus berupa file yang valid',
            'document_image.mimes' => 'Format file harus PNG, JPG, atau JPEG',
            'document_image.max' => 'Ukuran file maksimal 10MB',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $file = $request->file('document_image');
            $options = $request->input('options', []);

            // Security check
            if (!$file->isValid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'File upload tidak valid',
                ], 422);
            }

            // Get temporary path
            $tempPath = $file->getRealPath();

            // Process image
            Log::info('Starting OCR preprocessing', [
                'filename' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
            ]);

            $result = $this->imageService->Process_Image_For_Ocr($tempPath, $options);

            if (!$result['success']) {
                Log::error('OCR preprocessing failed', [
                    'error' => $result['error'],
                    'filename' => $file->getClientOriginalName(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memproses gambar',
                    'error' => $result['error'],
                ], 500);
            }

            // Cleanup old files
            $cleanedCount = $this->imageService->Cleanup_Temporary_Files(30);

            Log::info('OCR preprocessing completed', [
                'original_filename' => $file->getClientOriginalName(),
                'processed_path' => $result['path'],
                'metadata' => $result['metadata'],
                'cleaned_files' => $cleanedCount,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Gambar berhasil diproses untuk OCR',
                'data' => [
                    'original_filename' => $file->getClientOriginalName(),
                    'processed_path' => $result['path'],
                    'full_path' => $result['full_path'],
                    'download_url' => $result['url'],
                    'metadata' => $result['metadata'],
                ],
                'cleaned_files' => $cleanedCount,
            ], 200);

        } catch (\Exception $e) {
            Log::error('Unexpected error during OCR preprocessing', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan tak terduga',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Process image yang sudah ada di storage
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Process_From_Storage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image_path' => 'required|string',
            'disk' => 'nullable|string|in:public,secure_uploads,temporary',
            'options' => 'nullable|array',
        ], [
            'image_path.required' => 'Path gambar harus diisi',
            'disk.in' => 'Disk harus salah satu dari: public, secure_uploads, temporary',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $imagePath = $request->input('image_path');
            $disk = $request->input('disk', 'public');
            $options = $request->input('options', []);

            // Check if file exists
            if (!Storage::disk($disk)->exists($imagePath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'File tidak ditemukan',
                ], 404);
            }

            // Get full path
            $fullPath = Storage::disk($disk)->path($imagePath);

            // Process image
            $result = $this->imageService->Process_Image_For_Ocr($fullPath, $options);

            if (!$result['success']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memproses gambar',
                    'error' => $result['error'],
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Gambar berhasil diproses',
                'data' => [
                    'original_path' => $imagePath,
                    'processed_path' => $result['path'],
                    'download_url' => $result['url'],
                    'metadata' => $result['metadata'],
                ],
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error processing from storage', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get preprocessed image
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function Get_Preprocessed_Image(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'path' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $path = $request->input('path');

            if (!Storage::disk('temporary')->exists($path)) {
                return response()->json([
                    'success' => false,
                    'message' => 'File tidak ditemukan',
                ], 404);
            }

            $fullPath = Storage::disk('temporary')->path($path);

            return response()->file($fullPath);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Manual cleanup old files
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function Cleanup_Old_Files()
    {
        try {
            $count = $this->imageService->Cleanup_Temporary_Files(30);

            return response()->json([
                'success' => true,
                'message' => 'Cleanup berhasil',
                'data' => [
                    'deleted_files_count' => $count,
                ],
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Cleanup gagal',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
