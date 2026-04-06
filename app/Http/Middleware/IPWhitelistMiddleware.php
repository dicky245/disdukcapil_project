<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class IPWhitelistMiddleware
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
        $ip = $request->ip();

        // Check if IP is blacklisted
        if ($this->isIPBlacklisted($ip)) {
            Log::alert('Akses ditolak: IP ada di blacklist', [
                'ip' => $ip,
                'url' => $request->fullUrl(),
                'user_agent' => $request->userAgent(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak. IP Anda telah diblokir.',
            ], 403);
        }

        // Check if IP whitelist is enabled for admin
        if ($this->isAdminRoute($request) && config('security.ip.enable_ip_check', false)) {
            $whitelist = config('security.ip.admin_whitelist', []);

            if (!empty($whitelist) && !$this->isIPWhitelisted($ip, $whitelist)) {
                Log::warning('Akses admin ditolak: IP tidak ada di whitelist', [
                    'ip' => $ip,
                    'url' => $request->fullUrl(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak. IP Anda tidak diizinkan untuk mengakses halaman ini.',
                ], 403);
            }
        }

        return $next($request);
    }

    /**
     * Check if IP is blacklisted
     *
     * @param  string  $ip
     * @return bool
     */
    protected function isIPBlacklisted(string $ip): bool
    {
        // Check cache blacklist (temporary blocks)
        $cacheKey = 'ip_blacklist:' . $ip;
        if (Cache::has($cacheKey)) {
            return true;
        }

        // Check permanent blacklist
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
    protected function isIPWhitelisted(string $ip, array $whitelist): bool
    {
        if (empty($whitelist)) {
            return true; // No whitelist configured
        }

        return in_array($ip, $whitelist);
    }

    /**
     * Check if the current route is an admin route
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function isAdminRoute(Request $request): bool
    {
        return str_starts_with($request->path(), 'admin/');
    }
}
