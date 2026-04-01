<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SecurityService
{
    /**
     * Check if an IP is blacklisted
     *
     * @param  string  $ip
     * @return bool
     */
    public function isIPBlacklisted(string $ip): bool
    {
        $cacheKey = 'ip_blacklist:' . $ip;

        // Check temporary blacklist
        if (Cache::has($cacheKey)) {
            return true;
        }

        // Check permanent blacklist
        $blacklist = config('security.ip.blacklist', []);
        return in_array($ip, $blacklist);
    }

    /**
     * Add IP to temporary blacklist
     *
     * @param  string  $ip
     * @param  int  $minutes
     * @return void
     */
    public function blacklistIP(string $ip, int $minutes = 30): void
    {
        $cacheKey = 'ip_blacklist:' . $ip;
        Cache::put($cacheKey, true, now()->addMinutes($minutes));

        Log::alert('IP ditambahkan ke blacklist', [
            'ip' => $ip,
            'duration' => $minutes . ' minutes',
        ]);
    }

    /**
     * Remove IP from blacklist
     *
     * @param  string  $ip
     * @return void
     */
    public function unblacklistIP(string $ip): void
    {
        $cacheKey = 'ip_blacklist:' . $ip;
        Cache::forget($cacheKey);

        Log::info('IP dihapus dari blacklist', [
            'ip' => $ip,
        ]);
    }

    /**
     * Check if user has too many failed attempts
     *
     * @param  string  $identifier
     * @param  int  $maxAttempts
     * @return bool
     */
    public function hasTooManyFailedAttempts(string $identifier, int $maxAttempts = null): bool
    {
        $maxAttempts = $maxAttempts ?? config('security.blocking.max_failed_attempts', 5);
        $key = 'failed_attempts:' . $identifier;

        $attempts = Cache::get($key, 0);

        return $attempts >= $maxAttempts;
    }

    /**
     * Record a failed attempt
     *
     * @param  string  $identifier
     * @return int
     */
    public function recordFailedAttempt(string $identifier): int
    {
        $key = 'failed_attempts:' . $identifier;
        $decayMinutes = config('security.blocking.lockout_duration', 15);

        $attempts = Cache::get($key, 0) + 1;
        Cache::put($key, $attempts, now()->addMinutes($decayMinutes));

        Log::warning('Percobaan gagal tercatat', [
            'identifier' => $identifier,
            'attempts' => $attempts,
        ]);

        return $attempts;
    }

    /**
     * Clear failed attempts
     *
     * @param  string  $identifier
     * @return void
     */
    public function clearFailedAttempts(string $identifier): void
    {
        $key = 'failed_attempts:' . $identifier;
        Cache::forget($key);
    }

    /**
     * Get remaining lockout time in seconds
     *
     * @param  string  $identifier
     * @return int
     */
    public function getLockoutTime(string $identifier): int
    {
        $key = 'failed_attempts:' . $identifier;

        if (!Cache::has($key)) {
            return 0;
        }

        $decayMinutes = config('security.blocking.lockout_duration', 15);
        $ttl = Cache::get($key);

        return max(0, $decayMinutes * 60 - $ttl);
    }

    /**
     * Sanitize input from XSS
     *
     * @param  string  $input
     * @return string
     */
    public function sanitizeInput(string $input): string
    {
        // Remove potentially dangerous HTML
        $patterns = [
            '/<script\b[^>]*>(.*?)<\/script>/is',
            '/<iframe\b[^>]*>(.*?)<\/iframe>/is',
            '/<object\b[^>]*>(.*?)<\/object>/is',
            '/<embed\b[^>]*>/is',
            '/javascript:/i',
            '/vbscript:/i',
            '/on\w+\s*=/i', // Event handlers
        ];

        $sanitized = $input;

        foreach ($patterns as $pattern) {
            $sanitized = preg_replace($pattern, '', $sanitized);
        }

        return htmlspecialchars($sanitized, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * Validate password strength
     *
     * @param  string  $password
     * @return array
     */
    public function validatePasswordStrength(string $password): array
    {
        $errors = [];
        $config = config('security.password', []);

        if (strlen($password) < $config['min_length']) {
            $errors[] = "Password minimal {$config['min_length']} karakter";
        }

        if ($config['require_uppercase'] && !preg_match('/[A-Z]/', $password)) {
            $errors[] = "Password harus mengandung huruf kapital";
        }

        if ($config['require_lowercase'] && !preg_match('/[a-z]/', $password)) {
            $errors[] = "Password harus mengandung huruf kecil";
        }

        if ($config['require_number'] && !preg_match('/[0-9]/', $password)) {
            $errors[] = "Password harus mengandung angka";
        }

        if ($config['require_special_char'] && !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            $errors[] = "Password harus mengandung karakter khusus";
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors,
        ];
    }

    /**
     * Generate secure token
     *
     * @param  int  $length
     * @return string
     */
    public function generateSecureToken(int $length = 32): string
    {
        return Str::random($length);
    }

    /**
     * Encrypt PII data
     *
     * @param  string  $data
     * @return string
     */
    public function encryptPII(string $data): string
    {
        return encrypt($data);
    }

    /**
     * Decrypt PII data
     *
     * @param  string  $encryptedData
     * @return string
     */
    public function decryptPII(string $encryptedData): string
    {
        try {
            return decrypt($encryptedData);
        } catch (\Exception $e) {
            Log::error('Gagal mendekripsi data PII', [
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Mask sensitive data for logging
     *
     * @param  string  $data
     * @param  int  $showChars
     * @return string
     */
    public function maskSensitiveData(string $data, int $showChars = 4): string
    {
        if (strlen($data) <= $showChars) {
            return str_repeat('*', strlen($data));
        }

        $prefix = substr($data, 0, $showChars);
        $suffix = substr($data, -$showChars);
        $maskedLength = strlen($data) - ($showChars * 2);

        return $prefix . str_repeat('*', $maskedLength) . $suffix;
    }

    /**
     * Check for SQL injection patterns
     *
     * @param  string  $input
     * @return bool
     */
    public function detectSQLInjection(string $input): bool
    {
        $patterns = [
            '/\b(OR|AND)\s+\d+\s*=\s*\d+/i',
            '/\b(OR|AND)\s+["\'].*["\']\s*=\s*["\'].*["\']/i',
            '/\bUNION\b.*\bSELECT\b/i',
            '/\bDROP\b.*\bTABLE\b/i',
            '/\bINSERT\b.*\bINTO\b/i',
            '/\bDELETE\b.*\bFROM\b/i',
            '/\bEXEC\b|\bEXECUTE\b/i',
            '/--/',
            '/\/\*/',
            '/;\s*$/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $input)) {
                Log::warning('Pola SQL injection terdeteksi', [
                    'input' => $this->maskSensitiveData($input),
                ]);
                return true;
            }
        }

        return false;
    }

    /**
     * Validate file upload security
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @return array
     */
    public function validateFileUpload($file): array
    {
        $result = [
            'valid' => true,
            'errors' => [],
        ];

        // Check file size
        $maxSize = config('security.file_upload.max_size', 5242880);
        if ($file->getSize() > $maxSize) {
            $result['valid'] = false;
            $result['errors'][] = "Ukuran file maksimal " . ($maxSize / 1024 / 1024) . " MB";
        }

        // Check MIME type
        $allowedMimes = config('security.file_upload.allowed_mime_types', []);
        if (!in_array($file->getMimeType(), $allowedMimes)) {
            $result['valid'] = false;
            $result['errors'][] = "Tipe file tidak diizinkan";
        }

        // Check extension
        $allowedExtensions = config('security.file_upload.allowed_extensions', []);
        if (!in_array(strtolower($file->getClientOriginalExtension()), $allowedExtensions)) {
            $result['valid'] = false;
            $result['errors'][] = "Ekstensi file tidak diizinkan";
        }

        // Check for dangerous patterns in filename
        if (preg_match('/\.(php|phtml|php3|php4|php5|php7|phps)/i', $file->getClientOriginalName())) {
            $result['valid'] = false;
            $result['errors'][] = "Nama file mengandung ekstensi yang berbahaya";
        }

        return $result;
    }
}
