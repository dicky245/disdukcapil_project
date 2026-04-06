<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuditLogMiddleware
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
        if (!config('security.audit.enabled', true)) {
            return $next($request);
        }

        $response = $next($request);

        // Log the request after processing
        $this->logRequest($request, $response);

        return $response;
    }

    /**
     * Log request details
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     */
    protected function logRequest(Request $request, $response): void
    {
        $context = [
            'timestamp' => now()->toIso8601String(),
            'user_id' => Auth::id(),
            'user_email' => Auth::user()?->email,
            'ip' => $request->ip(),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'route' => $request->route()?->getName(),
            'status' => $response->getStatusCode(),
            'user_agent' => $request->userAgent(),
        ];

        // Log sensitive operations
        $sensitiveRoutes = [
            'admin.antrian-online.terima',
            'admin.antrian-online.verifikasi',
            'admin.antrian-online.cetak',
            'admin.antrian-online.selesai',
            'admin.antrian-online.tolak',
            'login',
            'register',
            'password.reset',
        ];

        $routeName = $request->route()?->getName();

        if (in_array($routeName, $sensitiveRoutes)) {
            Log::info('Sensitive operation performed', array_merge($context, [
                'operation' => $routeName,
                'data' => $this->sanitizeData($request->all()),
            ]));
        }

        // Log failed authentication attempts
        if ($response->getStatusCode() === 401 || $response->getStatusCode() === 403) {
            Log::warning('Authentication failed', $context);
        }

        // Log data modifications
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            Log::info('Data modification', array_merge($context, [
                'operation' => $request->method(),
                'data' => $this->sanitizeData($request->except(['password', 'password_confirmation', 'current_password'])),
            ]));
        }
    }

    /**
     * Sanitize sensitive data from logs
     *
     * @param  array  $data
     * @return array
     */
    protected function sanitizeData(array $data): array
    {
        $sensitiveKeys = [
            'password', 'password_confirmation', 'current_password',
            'pin', 'security_answer', 'token', 'api_key',
            'nik', 'nomor_kk', 'nomor_akta',
        ];

        foreach ($sensitiveKeys as $key) {
            if (isset($data[$key])) {
                $data[$key] = '***REDACTED***';
            }
        }

        return $data;
    }
}
