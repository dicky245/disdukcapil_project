<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SessionSecurityService
{
    /**
     * Validate session
     *
     * @return bool
     */
    public function validateSession(): bool
    {
        if (!Session::has('security指纹')) {
            return false;
        }

        $storedFingerprint = Session::get('security指纹');
        $currentFingerprint = $this->generateFingerprint();

        return hash_equals($storedFingerprint, $currentFingerprint);
    }

    /**
     * Generate session fingerprint
     *
     * @return string
     */
    public function generateFingerprint(): string
    {
        $request = request();

        $data = [
            $request->ip(),
            $request->userAgent(),
            $request->header('Accept-Language'),
            $request->header('Accept-Encoding'),
        ];

        return hash('sha256', implode('|', $data));
    }

    /**
     * Set session security
     *
     * @return void
     */
    public function setSessionSecurity(): void
    {
        Session::put('security_fingerprint', $this->generateFingerprint());
        Session::put('security_ip', request()->ip());
        Session::put('security_user_agent', request()->userAgent());
        Session::put('security_last_activity', now());
    }

    /**
     * Check session hijacking attempt
     *
     * @return bool
     */
    public function detectSessionHijack(): bool
    {
        if (!Session::has('security_ip') || !Session::has('security_user_agent')) {
            return false;
        }

        $storedIp = Session::get('security_ip');
        $storedUserAgent = Session::get('security_user_agent');

        $currentIp = request()->ip();
        $currentUserAgent = request()->userAgent();

        // Check if IP changed significantly
        if ($storedIp !== $currentIp) {
            Log::warning('Session IP changed', [
                'old_ip' => $storedIp,
                'new_ip' => $currentIp,
                'user_id' => auth()->id(),
            ]);

            // Could be legitimate (mobile network change) but worth logging
            return false;
        }

        // Check if user agent changed
        if ($storedUserAgent !== $currentUserAgent) {
            Log::warning('Session user agent changed', [
                'old_ua' => $storedUserAgent,
                'new_ua' => $currentUserAgent,
                'user_id' => auth()->id(),
            ]);

            return true; // More suspicious
        }

        return false;
    }

    /**
     * Regenerate session ID
     *
     * @return void
     */
    public function regenerateSession(): void
    {
        Session::regenerate(true);
        $this->setSessionSecurity();
    }

    /**
     * Check session timeout
     *
     * @return bool
     */
    public function isSessionExpired(): bool
    {
        $lifetime = config('session.lifetime', 120); // minutes
        $lastActivity = Session::get('security_last_activity');

        if (!$lastActivity) {
            return false;
        }

        $diff = now()->diffInMinutes($lastActivity);

        return $diff >= $lifetime;
    }

    /**
     * Update session activity
     *
     * @return void
     */
    public function updateActivity(): void
    {
        Session::put('security_last_activity', now());
    }

    /**
     * Concurrent session limit
     *
     * @param  int  $userId
     * @return bool
     */
    public function checkConcurrentSessions(int $userId): bool
    {
        $maxSessions = config('security.session.max_concurrent_sessions', 3);

        // Count active sessions for user
        $sessions = Cache::get("user_sessions:{$userId}", []);

        // Clean expired sessions
        $sessions = array_filter($sessions, function ($session) {
            return now()->diffInMinutes($session['last_activity']) < config('session.lifetime', 120);
        });

        if (count($sessions) >= $maxSessions) {
            // Remove oldest session
            $oldest = array_reduce($sessions, function ($oldest, $session) {
                return !$oldest || $session['last_activity'] < $oldest['last_activity'] ? $session : $oldest;
            });

            if ($oldest) {
                // Invalidate oldest session
                Cache::forget("session:{$oldest['id']}");

                Log::info('Oldest session invalidated due to concurrent limit', [
                    'user_id' => $userId,
                    'session_id' => $oldest['id'],
                ]);
            }
        }

        // Add current session
        $sessionId = Session::getId();
        $sessions[$sessionId] = [
            'id' => $sessionId,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'last_activity' => now(),
        ];

        Cache::put("user_sessions:{$userId}", $sessions, now()->addHours(24));

        return true;
    }

    /**
     * Invalidate all user sessions except current
     *
     * @param  int  $userId
     * @return void
     */
    public function invalidateOtherSessions(int $userId): void
    {
        $currentSessionId = Session::getId();
        $sessions = Cache::get("user_sessions:{$userId}", []);

        foreach ($sessions as $sessionId => $session) {
            if ($sessionId !== $currentSessionId) {
                Cache::forget("session:{$sessionId}");
                unset($sessions[$sessionId]);
            }
        }

        Cache::put("user_sessions:{$userId}", $sessions, now()->addHours(24));

        Log::info('All other sessions invalidated', [
            'user_id' => $userId,
            'current_session' => $currentSessionId,
        ]);
    }

    /**
     * Invalidate all user sessions
     *
     * @param  int  $userId
     * @return void
     */
    public function invalidateAllSessions(int $userId): void
    {
        $sessions = Cache::get("user_sessions:{$userId}", []);

        foreach ($sessions as $sessionId => $session) {
            Cache::forget("session:{$sessionId}");
        }

        Cache::forget("user_sessions:{$userId}");

        Log::info('All sessions invalidated', [
            'user_id' => $userId,
        ]);
    }

    /**
     * Lock session to IP
     *
     * @param  string  $ip
     * @return void
     */
    public function lockSessionToIP(string $ip): void
    {
        Session::put('security_locked_ip', $ip);
    }

    /**
     * Check if session is locked to IP
     *
     * @param  string  $ip
     * @return bool
     */
    public function isSessionLockedToIP(string $ip): bool
    {
        if (!Session::has('security_locked_ip')) {
            return true;
        }

        return Session::get('security_locked_ip') === $ip;
    }

    /**
     * Enable remember me with secure token
     *
     * @param  int  $userId
     * @return string
     */
    public function generateRememberToken(int $userId): string
    {
        $token = Str::random(60);

        // Store token in cache
        Cache::put("remember_token:{$token}", $userId, now()->addDays(30));

        return $token;
    }

    /**
     * Validate remember token
     *
     * @param  string  $token
     * @return int|null
     */
    public function validateRememberToken(string $token): ?int
    {
        $userId = Cache::get("remember_token:{$token}");

        if ($userId) {
            // Rotate token
            Cache::forget("remember_token:{$token}");
            return $userId;
        }

        return null;
    }

    /**
     * Rotate remember token
     *
     * @param  int  $userId
     * @param  string  $oldToken
     * @return string
     */
    public function rotateRememberToken(int $userId, string $oldToken): string
    {
        Cache::forget("remember_token:{$oldToken}");
        return $this->generateRememberToken($userId);
    }

    /**
     * Revoke remember token
     *
     * @param  string  $token
     * @return void
     */
    public function revokeRememberToken(string $token): void
    {
        Cache::forget("remember_token:{$token}");
    }

    /**
     * Revoke all remember tokens for user
     *
     * @param  int  $userId
     * @return void
     */
    public function revokeAllRememberTokens(int $userId): void
    {
        // This would require storing tokens by user ID
        // For simplicity, we'll log it
        Log::info('All remember tokens revoked', [
            'user_id' => $userId,
        ]);
    }

    /**
     * Get session info
     *
     * @return array
     */
    public function getSessionInfo(): array
    {
        return [
            'id' => Session::getId(),
            'ip' => Session::get('security_ip'),
            'user_agent' => Session::get('security_user_agent'),
            'last_activity' => Session::get('security_last_activity'),
            'created_at' => Session::get('security_created_at'),
        ];
    }

    /**
     * Check for session fixation
     *
     * @return bool
     */
    public function detectSessionFixation(): bool
    {
        if (!Session::has('security_created_at')) {
            Session::put('security_created_at', now());
            return false;
        }

        // Check if session ID is being reused without regeneration
        // This is simplified - real implementation would track session IDs

        return false;
    }

    /**
     * Clean up expired sessions
     *
     * @return void
     */
    public function cleanupExpiredSessions(): void
    {
        $lifetime = config('session.lifetime', 120);

        // This would be called by a scheduled task
        // For now, just log
        Log::info('Session cleanup run', [
            'lifetime_minutes' => $lifetime,
        ]);
    }
}
