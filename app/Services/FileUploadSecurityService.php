<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class FileUploadSecurityService
{
    /**
     * Validate file upload security
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  array  $options
     * @return array
     */
    public function validateFile(UploadedFile $file, array $options = []): array
    {
        $result = [
            'valid' => true,
            'errors' => [],
        ];

        // Check file size
        $maxSize = $options['max_size'] ?? config('security.file_upload.max_size', 5242880);
        if ($file->getSize() > $maxSize) {
            $result['valid'] = false;
            $result['errors'][] = "Ukuran file maksimal " . ($maxSize / 1024 / 1024) . " MB";
        }

        // Check MIME type
        $allowedMimes = $options['allowed_mimes'] ?? config('security.file_upload.allowed_mime_types', []);
        $actualMime = $this->getActualMimeType($file);

        if (!in_array($actualMime, $allowedMimes)) {
            $result['valid'] = false;
            $result['errors'][] = "Tipe file tidak diizinkan. Tipe terdeteksi: {$actualMime}";
        }

        // Check file extension
        $allowedExtensions = $options['allowed_extensions'] ?? config('security.file_upload.allowed_extensions', []);
        $extension = strtolower($file->getClientOriginalExtension());

        if (!in_array($extension, $allowedExtensions)) {
            $result['valid'] = false;
            $result['errors'][] = "Ekstensi file tidak diizinkan";
        }

        // Check MIME and extension match
        if (!$this->validateMimeExtensionMatch($file, $actualMime, $extension)) {
            $result['valid'] = false;
            $result['errors'][] = "Tipe file dan ekstensi tidak cocok";
        }

        // Check for dangerous patterns in filename
        if ($this->hasDangerousFilename($file->getClientOriginalName())) {
            $result['valid'] = false;
            $result['errors'][] = "Nama file mengandung karakter yang berbahaya";
        }

        // Check for embedded threats
        if ($this->hasEmbeddedThreats($file)) {
            $result['valid'] = false;
            $result['errors'][] = "File mengandung konten yang berbahaya";
        }

        return $result;
    }

    /**
     * Get actual MIME type from file content
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @return string
     */
    protected function getActualMimeType(UploadedFile $file): string
    {
        // Use finfo if available
        if (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $file->getRealPath());
            finfo_close($finfo);
            return $mime;
        }

        // Fallback to getMimeType()
        return $file->getMimeType();
    }

    /**
     * Validate MIME type matches extension
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  string  $mime
     * @param  string  $extension
     * @return bool
     */
    protected function validateMimeExtensionMatch(UploadedFile $file, string $mime, string $extension): bool
    {
        $mimeMap = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'pdf' => 'application/pdf',
        ];

        $expectedMime = $mimeMap[$extension] ?? null;

        if ($expectedMime === null) {
            return true; // No mapping defined, allow
        }

        return $mime === $expectedMime;
    }

    /**
     * Check for dangerous filename patterns
     *
     * @param  string  $filename
     * @return bool
     */
    protected function hasDangerousFilename(string $filename): bool
    {
        $dangerousPatterns = [
            '/\.(php|phtml|php3|php4|php5|php7|phps|cgi|pl|py|jsp|asp|sh)/i',
            '/\.\./', // Directory traversal
            '/\.htaccess/i',
            '/\.htpasswd/i',
            '/\.ini/i',
            '/\.config/i',
            '/web\.config/i',
        ];

        foreach ($dangerousPatterns as $pattern) {
            if (preg_match($pattern, $filename)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check for embedded threats in file
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @return bool
     */
    protected function hasEmbeddedThreats(UploadedFile $file): bool
    {
        $path = $file->getRealPath();
        $handle = fopen($path, 'rb');

        if (!$handle) {
            return false;
        }

        // Read first 1KB for quick check
        $header = fread($handle, 1024);
        fclose($handle);

        // Check for PHP tags
        if (preg_match('/<\?php/i', $header)) {
            return true;
        }

        // Check for script tags in images
        $extension = strtolower($file->getClientOriginalExtension());
        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
            if (preg_match('/<script/i', $header)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Generate secure filename
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @return string
     */
    public function generateSecureFilename(UploadedFile $file): string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $timestamp = now()->format('YmdHis');
        $random = Str::random(40);

        return "{$timestamp}_{$random}.{$extension}";
    }

    /**
     * Sanitize filename
     *
     * @param  string  $filename
     * @return string
     */
    public function sanitizeFilename(string $filename): string
    {
        // Remove directory traversal attempts
        $filename = str_replace(['..', '/', '\\'], '', $filename);

        // Remove special characters except dots, hyphens, and underscores
        $filename = preg_replace('/[^a-zA-Z0-9._-]/', '', $filename);

        // Remove multiple dots
        $filename = preg_replace('/\.{2,}/', '.', $filename);

        return $filename;
    }

    /**
     * Store file securely
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  string  $disk
     * @param  string|null  $path
     * @return array
     */
    public function storeSecurely(UploadedFile $file, string $disk = 'secure_uploads', ?string $path = null): array
    {
        // Validate file
        $validation = $this->validateFile($file);

        if (!$validation['valid']) {
            return [
                'success' => false,
                'errors' => $validation['errors'],
            ];
        }

        // Generate secure filename
        $secureFilename = $this->generateSecureFilename($file);

        // Store file
        $storagePath = $path ? $path . '/' . $secureFilename : $secureFilename;

        try {
            $filePath = Storage::disk($disk)->putFileAs(
                $path ?? '',
                $file,
                $secureFilename
            );

            // Log successful upload
            Log::info('File uploaded securely', [
                'original_name' => $file->getClientOriginalName(),
                'secure_name' => $secureFilename,
                'disk' => $disk,
                'path' => $filePath,
                'size' => $file->getSize(),
                'mime' => $file->getMimeType(),
            ]);

            return [
                'success' => true,
                'filename' => $secureFilename,
                'path' => $filePath,
                'disk' => $disk,
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
            ];
        } catch (\Exception $e) {
            Log::error('File upload failed', [
                'error' => $e->getMessage(),
                'filename' => $file->getClientOriginalName(),
            ]);

            return [
                'success' => false,
                'errors' => ['Gagal mengupload file. Silakan coba lagi.'],
            ];
        }
    }

    /**
     * Delete file securely
     *
     * @param  string  $path
     * @param  string  $disk
     * @return bool
     */
    public function deleteSecurely(string $path, string $disk = 'secure_uploads'): bool
    {
        try {
            Storage::disk($disk)->delete($path);

            Log::info('File deleted securely', [
                'path' => $path,
                'disk' => $disk,
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('File deletion failed', [
                'error' => $e->getMessage(),
                'path' => $path,
            ]);

            return false;
        }
    }

    /**
     * Get file URL (only for public disk)
     *
     * @param  string  $path
     * @param  string  $disk
     * @return string|null
     */
    public function getFileUrl(string $path, string $disk = 'secure_uploads'): ?string
    {
        // Only allow public URLs for public disk
        if ($disk === 'public') {
            return Storage::disk($disk)->url($path);
        }

        // For secure disks, return null - should use controller to serve
        return null;
    }

    /**
     * Serve file securely
     *
     * @param  string  $path
     * @param  string  $disk
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|null
     */
    public function serveSecurely(string $path, string $disk = 'secure_uploads')
    {
        try {
            $fullPath = Storage::disk($disk)->path($path);

            if (!file_exists($fullPath)) {
                return null;
            }

            // Log file access
            Log::info('File accessed', [
                'path' => $path,
                'disk' => $disk,
                'user_id' => auth()->id(),
            ]);

            return response()->file($fullPath);
        } catch (\Exception $e) {
            Log::error('File serve failed', [
                'error' => $e->getMessage(),
                'path' => $path,
            ]);

            return null;
        }
    }

    /**
     * Scan file for malware (placeholder for integration with clamav etc)
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @return bool
     */
    public function scanForMalware(UploadedFile $file): bool
    {
        // Placeholder for anti-virus integration
        // Could integrate with ClamAV, etc.

        if (!config('security.file_upload.scan_uploads', false)) {
            return true; // Scanning disabled
        }

        // For now, just check for basic threats
        return !$this->hasEmbeddedThreats($file);
    }

    /**
     * Validate image file
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @return array
     */
    public function validateImage(UploadedFile $file): array
    {
        $result = $this->validateFile($file, [
            'allowed_mimes' => ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'],
            'allowed_extensions' => ['jpg', 'jpeg', 'png', 'gif'],
            'max_size' => 5242880, // 5MB
        ]);

        if (!$result['valid']) {
            return $result;
        }

        // Additional image validation
        try {
            $imageInfo = getimagesize($file->getRealPath());

            if ($imageInfo === false) {
                return [
                    'valid' => false,
                    'errors' => ['File bukan gambar yang valid'],
                ];
            }

            // Check image dimensions
            $maxWidth = config('security.file_upload.max_image_width', 4000);
            $maxHeight = config('security.file_upload.max_image_height', 4000);

            if ($imageInfo[0] > $maxWidth || $imageInfo[1] > $maxHeight) {
                return [
                    'valid' => false,
                    'errors' => ["Dimensi gambar maksimal {$maxWidth}x{$maxHeight} pixel"],
                ];
            }

        } catch (\Exception $e) {
            return [
                'valid' => false,
                'errors' => ['Gagal memvalidasi gambar'],
            ];
        }

        return $result;
    }

    /**
     * Get file info
     *
     * @param  string  $path
     * @param  string  $disk
     * @return array|null
     */
    public function getFileInfo(string $path, string $disk = 'secure_uploads'): ?array
    {
        try {
            $fullPath = Storage::disk($disk)->path($path);

            if (!file_exists($fullPath)) {
                return null;
            }

            return [
                'name' => basename($path),
                'path' => $path,
                'size' => filesize($fullPath),
                'modified' => filemtime($fullPath),
                'mime_type' => mime_content_type($fullPath),
            ];
        } catch (\Exception $e) {
            return null;
        }
    }
}
