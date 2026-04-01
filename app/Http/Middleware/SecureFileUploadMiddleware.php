<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SecureFileUploadMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->hasFile('file') || $request->hasFile('ktp_image')) {
            $file = $request->file('file') ?? $request->file('ktp_image');

            if (!$this->validateFileUpload($file, $request)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi file upload gagal. Periksa tipe dan ukuran file.',
                ], 422);
            }

            // Log successful file upload
            Log::info('File upload berhasil', [
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'ip' => $request->ip(),
                'user_id' => $request->user()?->id,
            ]);
        }

        return $next($request);
    }

    /**
     * Validate file upload
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function validateFileUpload($file, Request $request): bool
    {
        // Check file size
        $maxSize = config('security.file_upload.max_size', 5242880); // 5MB
        if ($file->getSize() > $maxSize) {
            Log::warning('Ukuran file terlalu besar', [
                'file_size' => $file->getSize(),
                'max_size' => $maxSize,
                'ip' => $request->ip(),
            ]);
            return false;
        }

        // Check MIME type
        $allowedMimes = config('security.file_upload.allowed_mime_types', [
            'image/jpeg',
            'image/jpg',
            'image/png',
            'application/pdf',
        ]);

        $mimeType = $file->getMimeType();
        if (!in_array($mimeType, $allowedMimes)) {
            Log::warning('Tipe file tidak diizinkan', [
                'mime_type' => $mimeType,
                'allowed' => $allowedMimes,
                'ip' => $request->ip(),
            ]);
            return false;
        }

        // Check file extension
        $allowedExtensions = config('security.file_upload.allowed_extensions', ['jpg', 'jpeg', 'png', 'pdf']);
        $extension = strtolower($file->getClientOriginalExtension());

        if (!in_array($extension, $allowedExtensions)) {
            Log::warning('Ekstensi file tidak diizinkan', [
                'extension' => $extension,
                'allowed' => $allowedExtensions,
                'ip' => $request->ip(),
            ]);
            return false;
        }

        // Check for double extension
        if (preg_match('/\.(php|phtml|php3|php4|php5|php7|phps)/i', $file->getClientOriginalName())) {
            Log::warning('Deteksi double extension yang berbahaya', [
                'file_name' => $file->getClientOriginalName(),
                'ip' => $request->ip(),
            ]);
            return false;
        }

        // Validate actual file content
        if (!$this->validateFileContent($file)) {
            Log::warning('Validasi konten file gagal', [
                'file_name' => $file->getClientOriginalName(),
                'ip' => $request->ip(),
            ]);
            return false;
        }

        return true;
    }

    /**
     * Validate actual file content (not just extension)
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @return bool
     */
    protected function validateFileContent($file): bool
    {
        // Get file signature (magic bytes)
        $handle = fopen($file->getRealPath(), 'rb');
        $bytes = fread($handle, 8);
        fclose($handle);

        // Check for common file signatures
        $signatures = [
            // JPEG
            'ffd8ff' => 'image/jpeg',
            // PNG
            '89504e470d0a1a0a' => 'image/png',
            // PDF
            '25504446' => 'application/pdf',
        ];

        $hex = bin2hex($bytes);
        $expectedMime = $file->getMimeType();

        foreach ($signatures as $signature => $mime) {
            if (str_starts_with($hex, $signature) && $mime !== $expectedMime) {
                return false; // Signature doesn't match declared MIME type
            }
        }

        return true;
    }

    /**
     * Generate secure filename
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @return string
     */
    public static function generateSecureFilename($file): string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $random = Str::random(40);
        $timestamp = now()->format('YmdHis');

        return "{$timestamp}_{$random}.{$extension}";
    }
}
