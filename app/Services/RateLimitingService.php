<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class RateLimitingService
{
    /**
     * Check if rate limit is exceeded
     *
     * @param  string  $key
     * @param  int  $maxAttempts
     * @param  int  $decayMinutes
     * @return array
     */
    public function checkRateLimit(string $key, int $maxAttempts, int $decayMinutes): array
    {
        $attempts = Cache::get($key, 0);

        $remaining = max(0, $maxAttempts - $attempts);
        $retryAfter = null;

        if ($attempts >= $maxAttempts) {
            $ttl = Cache::get($key . ':ttl');
            if ($ttl) {
                $retryAfter = now()->diffInSeconds($ttl);
            }

            $this->logRateLimitExceeded($key, $attempts, $maxAttempts);

            return [
                'exceeded' => true,
                'attempts' => $attempts,
                'remaining' => 0,
                'retry_after' => $retryAfter,
            ];
        }

        return [
            'exceeded' => false,
            'attempts' => $attempts,
            'remaining' => $remaining,
            'retry_after' => null,
        ];
    }

    /**
     * Hit rate limiter
     *
     * @param  string  $key
     * @param  int  $decayMinutes
     * @return void
     */
    public function hitRateLimiter(string $key, int $decayMinutes): void
    {
        Cache::add($key . ':ttl', now()->addMinutes($decayMinutes), $decayMinutes * 60);

        Cache::increment($key);
        Cache::put($key, Cache::get($key, 0), now()->addMinutes($decayMinutes));
    }

    /**
     * Clear rate limiter
     *
     * @param  string  $key
     * @return void
     */
    public function clearRateLimiter(string $key): void
    {
        Cache::forget($key);
        Cache::forget($key . ':ttl');
    }

    /**
     * Log rate limit exceeded
     *
     * @param  string  $key
     * @param  int  $attempts
     * @param  int  $maxAttempts
     * @return void
     */
    protected function logRateLimitExceeded(string $key, int $attempts, int $maxAttempts): void
    {
        Log::warning('Rate limit exceeded', [
            'key' => $key,
            'attempts' => $attempts,
            'max_attempts' => $maxAttempts,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'user_id' => auth()->id(),
        ]);

        // Check if we should blacklist IP
        $this->checkAndBlacklist($key);
    }

    /**
     * Check and blacklist IP if needed
     *
     * @param  string  $key
     * @return void
     */
    protected function checkAndBlacklist(string $key): void
    {
        $violationKey = 'rate_limit_violations:' . $key;
        $maxViolations = config('security.blocking.max_failed_attempts', 5);

        $violations = Cache::get($violationKey, 0) + 1;
        Cache::put($violationKey, $violations, now()->addMinutes(15));

        if ($violations >= $maxViolations) {
            // Extract IP from key
            $parts = explode(':', $key);
            $ip = $parts[1] ?? request()->ip();

            // Blacklist IP
            SecurityHelper::blacklistIP($ip, 30);

            Log::alert('IP blacklisted due to repeated rate limit violations', [
                'ip' => $ip,
                'violations' => $violations,
            ]);
        }
    }

    /**
     * Get rate limit key for request
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $type
     * @return string
     */
    public function getRateLimitKey(Request $request, string $type = 'default'): string
    {
        $userId = $request->user()?->id ?? 'guest';
        $ip = $request->ip();

        return "rate_limit:{$type}:{$userId}:{$ip}";
    }

    /**
     * Check API rate limit
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function checkApiRateLimit(Request $request): array
    {
        $maxAttempts = config('security.rate_limiting.api.max_requests', 60);
        $decayMinutes = config('security.rate_limiting.api.decay_minutes', 1);

        $key = $this->getRateLimitKey($request, 'api');

        return $this->checkRateLimit($key, $maxAttempts, $decayMinutes);
    }

    /**
     * Hit API rate limiter
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function hitApiRateLimiter(Request $request): void
    {
        $decayMinutes = config('security.rate_limiting.api.decay_minutes', 1);
        $key = $this->getRateLimitKey($request, 'api');

        $this->hitRateLimiter($key, $decayMinutes);
    }

    /**
     * Check auth rate limit
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function checkAuthRateLimit(Request $request): array
    {
        $maxAttempts = config('security.rate_limiting.auth.max_requests', 5);
        $decayMinutes = config('security.rate_limiting.auth.decay_minutes', 1);

        $key = $this->getRateLimitKey($request, 'auth');

        return $this->checkRateLimit($key, $maxAttempts, $decayMinutes);
    }

    /**
     * Hit auth rate limiter
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function hitAuthRateLimiter(Request $request): void
    {
        $decayMinutes = config('security.rate_limiting.auth.decay_minutes', 1);
        $key = $this->getRateLimitKey($request, 'auth');

        $this->hitRateLimiter($key, $decayMinutes);
    }

    /**
     * Check upload rate limit
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function checkUploadRateLimit(Request $request): array
    {
        $maxAttempts = config('security.rate_limiting.upload.max_requests', 10);
        $decayMinutes = config('security.rate_limiting.upload.decay_minutes', 5);

        $key = $this->getRateLimitKey($request, 'upload');

        return $this->checkRateLimit($key, $maxAttempts, $decayMinutes);
    }

    /**
     * Hit upload rate limiter
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function hitUploadRateLimiter(Request $request): void
    {
        $decayMinutes = config('security.rate_limiting.upload.decay_minutes', 5);
        $key = $this->getRateLimitKey($request, 'upload');

        $this->hitRateLimiter($key, $decayMinutes);
    }

    /**
     * Check for DoS attack patterns
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function detectDoSAttack(Request $request): bool
    {
        $ip = $request->ip();
        $key = 'dos_detection:' . $ip;

        $requests = Cache::get($key, []);
        $now = now();

        // Clean old requests (older than 1 minute)
        $requests = array_filter($requests, function ($timestamp) use ($now) {
            return $now->diffInSeconds($timestamp) < 60;
        });

        // Add current request
        $requests[] = $now;

        // Check threshold
        $threshold = config('security.monitoring.suspicious_threshold', 100);

        if (count($requests) > $threshold) {
            Log::alert('Potential DoS attack detected', [
                'ip' => $ip,
                'requests_per_minute' => count($requests),
                'threshold' => $threshold,
            ]);

            // Blacklist IP
            SecurityHelper::blacklistIP($ip, 60);

            return true;
        }

        // Store updated requests
        Cache::put($key, $requests, now()->addMinutes(1));

        return false;
    }

    /**
     * Check for slowloris attack
     *
     * @param  string  $ip
     * @return bool
     */
    public function detectSlowlorisAttack(string $ip): bool
    {
        $key = 'slowloris:' . $ip;
        $connections = Cache::get($key, 0);

        if ($connections > 50) { // More than 50 concurrent connections
            Log::alert('Potential Slowloris attack detected', [
                'ip' => $ip,
                'connections' => $connections,
            ]);

            SecurityHelper::blacklistIP($ip, 60);

            return true;
        }

        return false;
    }

    /**
     * Increment connection count
     *
     * @param  string  $ip
     * @return void
     */
    public function incrementConnection(string $ip): void
    {
        $key = 'slowloris:' . $ip;
        Cache::increment($key);
        Cache::put($key, Cache::get($key, 0), now()->addMinutes(5));
    }

    /**
     * Decrement connection count
     *
     * @param  string  $ip
     * @return void
     */
    public function decrementConnection(string $ip): void
    {
        $key = 'slowloris:' . $ip;
        $connections = Cache::get($key, 0);

        if ($connections > 0) {
            Cache::decrement($key);
        }
    }

    /**
     * Get rate limit headers
     *
     * @param  array  $limitInfo
     * @return array
     */
    public function getRateLimitHeaders(array $limitInfo): array
    {
        return [
            'X-RateLimit-Limit' => $limitInfo['attempts'] + $limitInfo['remaining'],
            'X-RateLimit-Remaining' => $limitInfo['remaining'],
            'X-RateLimit-Reset' => $limitInfo['retry_after'] ?? 0,
        ];
    }
}
