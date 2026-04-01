<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpFoundation\Response;

class RateLimitingMiddleware
{
    /**
     * The rate limiter instance.
     *
     * @var \Illuminate\Cache\RateLimiter
     */
    protected $limiter;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Cache\RateLimiter  $limiter
     * @return void
     */
    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  $type
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ?string $type = null): Response
    {
        if (!config('security.rate_limiting.enabled', true)) {
            return $next($request);
        }

        $type = $type ?: $this->determineType($request);

        $key = $this->resolveRequestSignature($request, $type);

        $limit = config("security.rate_limiting.{$type}.max_requests", 60);
        $decay = config("security.rate_limiting.{$type}.decay_minutes", 1);

        if ($this->limiter->tooManyAttempts($key, $limit)) {
            $this->logRateLimitExceeded($request, $type);

            throw new ThrottleRequestsException(
                'Terlalu banyak permintaan. Silakan coba lagi dalam ' .
                $this->limiter->availableIn($key) . ' detik.'
            );
        }

        $this->limiter->hit($key, $decay * 60);

        $response = $next($request);

        // Add rate limit headers
        $response->headers->set('X-RateLimit-Limit', $limit);
        $response->headers->set('X-RateLimit-Remaining', $this->limiter->remaining($key, $limit));
        $response->headers->set('X-RateLimit-Reset', $this->limiter->availableIn($key));

        return $response;
    }

    /**
     * Determine the rate limit type based on the route
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function determineType(Request $request): string
    {
        $route = $request->route();

        if ($route) {
            $routeName = $route->getName() ?? '';
            $routeUri = $request->path();

            // Auth endpoints
            if (str_contains($routeUri, 'login') ||
                str_contains($routeUri, 'register') ||
                str_contains($routeUri, 'password')) {
                return 'auth';
            }

            // Upload endpoints
            if (str_contains($routeUri, 'upload') ||
                str_contains($routeUri, 'ocr') ||
                $request->hasFile('file')) {
                return 'upload';
            }

            // OCR endpoints
            if (str_contains($routeUri, 'ocr')) {
                return 'ocr';
            }

            // API endpoints
            if (str_starts_with($routeUri, 'api/')) {
                return 'api';
            }
        }

        return 'api';
    }

    /**
     * Resolve request signature.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $type
     * @return string
     */
    protected function resolveRequestSignature(Request $request, string $type): string
    {
        $userId = $request->user()?->id ?? 'guest';
        $ip = $request->ip();

        return sha1($type . '|' . $userId . '|' . $ip . '|' . $request->route()?->getName());
    }

    /**
     * Log rate limit exceeded event
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $type
     * @return void
     */
    protected function logRateLimitExceeded(Request $request, string $type): void
    {
        if (config('security.audit.enabled', true)) {
            \Log::warning('Rate limit terlampaui', [
                'type' => $type,
                'ip' => $request->ip(),
                'user_id' => $request->user()?->id,
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        // Optionally block IP after repeated violations
        $this->checkAndBlockIP($request, $type);
    }

    /**
     * Check and block IP if there are repeated violations
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $type
     * @return void
     */
    protected function checkAndBlockIP(Request $request, string $type): void
    {
        $ip = $request->ip();
        $key = 'rate_limit_violations:' . $ip . ':' . $type;
        $maxViolations = config('security.blocking.max_failed_attempts', 5);

        $violations = cache()->get($key, 0) + 1;
        cache()->put($key, $violations, now()->addMinutes(15));

        if ($violations >= $maxViolations) {
            // Add to temporary blacklist
            $blacklistKey = 'ip_blacklist:' . $ip;
            cache()->put($blacklistKey, true, now()->addMinutes(30));

            \Log::alert('IP ditambahkan ke blacklist karena repeated rate limit violations', [
                'ip' => $ip,
                'violations' => $violations,
            ]);
        }
    }
}
