<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class SecurityHelper
{
    /**
     * Mask sensitive data
     *
     * @param  string  $data
     * @param  int  $showChars
     * @return string
     */
    public static function maskSensitiveData(string $data, int $showChars = 4): string
    {
        if (empty($data)) {
            return '';
        }

        $length = strlen($data);

        if ($length <= $showChars) {
            return str_repeat('*', $length);
        }

        $prefix = substr($data, 0, $showChars);
        $suffix = substr($data, -$showChars);
        $maskedLength = $length - ($showChars * 2);

        return $prefix . str_repeat('*', $maskedLength) . $suffix;
    }

    /**
     * Sanitize input from XSS
     *
     * @param  string  $input
     * @return string
     */
    public static function sanitizeInput(string $input): string
    {
        $patterns = [
            '/<script\b[^>]*>(.*?)<\/script>/is',
            '/<iframe\b[^>]*>(.*?)<\/iframe>/is',
            '/javascript:/i',
            '/vbscript:/i',
            '/on\w+\s*=/i',
        ];

        $sanitized = $input;

        foreach ($patterns as $pattern) {
            $sanitized = preg_replace($pattern, '', $sanitized);
        }

        return htmlspecialchars($sanitized, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * Generate secure random token
     *
     * @param  int  $length
     * @return string
     */
    public static function generateToken(int $length = 32): string
    {
        return Str::random($length);
    }

    /**
     * Encrypt sensitive data
     *
     * @param  string  $data
     * @return string
     */
    public static function encrypt(string $data): string
    {
        return Crypt::encryptString($data);
    }

    /**
     * Decrypt sensitive data
     *
     * @param  string  $encryptedData
     * @return string
     */
    public static function decrypt(string $encryptedData): string
    {
        try {
            return Crypt::decryptString($encryptedData);
        } catch (\Exception $e) {
            \Log::error('Gagal mendekripsi data', [
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Check for SQL injection patterns
     *
     * @param  string  $input
     * @return bool
     */
    public static function detectSQLInjection(string $input): bool
    {
        $patterns = [
            '/\b(OR|AND)\s+\d+\s*=\s*\d+/i',
            '/\bUNION\b.*\bSELECT\b/i',
            '/\bDROP\b.*\bTABLE\b/i',
            '/\bINSERT\b.*\bINTO\b/i',
            '/\bDELETE\b.*\bFROM\b/i',
            '/--/',
            '/\/\*/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $input)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Validate password strength
     *
     * @param  string  $password
     * @return array
     */
    public static function validatePasswordStrength(string $password): array
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
     * Generate secure filename
     *
     * @param  string  $originalName
     * @param  string  $extension
     * @return string
     */
    public static function generateSecureFilename(string $originalName, string $extension): string
    {
        $timestamp = now()->format('YmdHis');
        $random = Str::random(40);

        return "{$timestamp}_{$random}.{$extension}";
    }

    /**
     * Check if file extension is allowed
     *
     * @param  string  $extension
     * @return bool
     */
    public static function isAllowedExtension(string $extension): bool
    {
        $allowed = config('security.file_upload.allowed_extensions', []);
        return in_array(strtolower($extension), $allowed);
    }

    /**
     * Check if MIME type is allowed
     *
     * @param  string  $mimeType
     * @return bool
     */
    public static function isAllowedMimeType(string $mimeType): bool
    {
        $allowed = config('security.file_upload.allowed_mime_types', []);
        return in_array($mimeType, $allowed);
    }

    /**
     * Sanitize filename
     *
     * @param  string  $filename
     * @return string
     */
    public static function sanitizeFilename(string $filename): string
    {
        // Remove any directory traversal attempts
        $filename = str_replace(['..', '/', '\\'], '', $filename);

        // Remove special characters except dots, hyphens, and underscores
        $filename = preg_replace('/[^a-zA-Z0-9._-]/', '', $filename);

        return $filename;
    }

    /**
     * Get client IP address
     *
     * @return string
     */
    public static function getClientIP(): string
    {
        $request = request();

        // Check for forwarded IP
        if ($request->hasHeader('X-Forwarded-For')) {
            return $request->header('X-Forwarded-For');
        }

        // Check for real IP
        if ($request->hasHeader('X-Real-IP')) {
            return $request->header('X-Real-IP');
        }

        return $request->ip();
    }

    /**
     * Check if IP is blacklisted
     *
     * @param  string  $ip
     * @return bool
     */
    public static function isIPBlacklisted(string $ip): bool
    {
        $cacheKey = 'ip_blacklist:' . $ip;

        if (cache()->has($cacheKey)) {
            return true;
        }

        $blacklist = config('security.ip.blacklist', []);
        return in_array($ip, $blacklist);
    }

    /**
     * Check if IP is whitelisted
     *
     * @param  string  $ip
     * @param  array  $whitelist
     * @return bool
     */
    public static function isIPWhitelisted(string $ip, array $whitelist = []): bool
    {
        if (empty($whitelist)) {
            return true;
        }

        return in_array($ip, $whitelist);
    }

    /**
     * Log security event
     *
     * @param  string  $event
     * @param  array  $context
     * @return void
     */
    public static function logSecurityEvent(string $event, array $context = []): void
    {
        \Log::warning('Security Event: ' . $event, array_merge($context, [
            'ip' => self::getClientIP(),
            'user_agent' => request()->userAgent(),
            'user_id' => auth()->id(),
        ]));
    }

    /**
     * Generate CSRF token for AJAX
     *
     * @return string
     */
    public static function getCsrfToken(): string
    {
        return csrf_token();
    }

    /**
     * Validate CSRF token
     *
     * @param  string  $token
     * @return bool
     */
    public static function validateCsrfToken(string $token): bool
    {
        return hash_equals(self::getCsrfToken(), $token);
    }

    /**
     * Sanitize URL to prevent redirect attacks
     *
     * @param  string  $url
     * @return bool
     */
    public static function isSafeUrl(string $url): bool
    {
        // Only allow relative URLs or same domain
        $parsed = parse_url($url);

        // If no scheme, it's relative (safe)
        if (!isset($parsed['scheme'])) {
            return true;
        }

        // Check if it's same domain
        $allowedHosts = [
            parse_url(config('app.url'), PHP_URL_HOST),
            'localhost',
        ];

        return in_array($parsed['host'] ?? '', $allowedHosts);
    }

    /**
     * Get user agent string
     *
     * @return string
     */
    public static function getUserAgent(): string
    {
        return request()->userAgent() ?? 'Unknown';
    }

    /**
     * Detect suspicious activity
     *
     * @param  string  $type
     * @return bool
     */
    public static function detectSuspiciousActivity(string $type = 'general'): bool
    {
        $ip = self::getClientIP();
        $key = 'suspicious_activity:' . $type . ':' . $ip;

        $count = cache()->get($key, 0) + 1;
        cache()->put($key, $count, now()->addMinutes(5));

        $threshold = config('security.monitoring.suspicious_threshold', 10);

        if ($count >= $threshold) {
            self::logSecurityEvent('Suspicious activity detected', [
                'type' => $type,
                'count' => $count,
            ]);

            // Add to temporary blacklist
            self::blacklistIP($ip, 30);

            return true;
        }

        return false;
    }

    /**
     * Add IP to blacklist
     *
     * @param  string  $ip
     * @param  int  $minutes
     * @return void
     */
    public static function blacklistIP(string $ip, int $minutes = 30): void
    {
        $cacheKey = 'ip_blacklist:' . $ip;
        cache()->put($cacheKey, true, now()->addMinutes($minutes));

        self::logSecurityEvent('IP blacklisted', [
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
    public static function unblacklistIP(string $ip): void
    {
        $cacheKey = 'ip_blacklist:' . $ip;
        cache()->forget($cacheKey);

        self::logSecurityEvent('IP removed from blacklist', [
            'ip' => $ip,
        ]);
    }

    /**
     * Check for brute force attempts
     *
     * @param  string  $identifier
     * @return bool
     */
    public static function isBruteForceAttempt(string $identifier): bool
    {
        $key = 'failed_attempts:' . $identifier;
        $maxAttempts = config('security.blocking.max_failed_attempts', 5);

        $attempts = cache()->get($key, 0);

        return $attempts >= $maxAttempts;
    }

    /**
     * Record failed attempt
     *
     * @param  string  $identifier
     * @return int
     */
    public static function recordFailedAttempt(string $identifier): int
    {
        $key = 'failed_attempts:' . $identifier;
        $decayMinutes = config('security.blocking.lockout_duration', 15);

        $attempts = cache()->get($key, 0) + 1;
        cache()->put($key, $attempts, now()->addMinutes($decayMinutes));

        return $attempts;
    }

    /**
     * Clear failed attempts
     *
     * @param  string  $identifier
     * @return void
     */
    public static function clearFailedAttempts(string $identifier): void
    {
        $key = 'failed_attempts:' . $identifier;
        cache()->forget($key);
    }
}
