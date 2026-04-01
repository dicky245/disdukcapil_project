<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Illuminate\Support\Facades\Log;

class VerifyCsrfTokenCustom extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // Routes that don't need CSRF protection
        // Add OCR API endpoint if needed (though recommended to use token-based auth)
        // 'api/ocr/extract-ktp',
    ];

    /**
     * Handle CSRF token mismatch
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, \Closure $next)
    {
        try {
            return parent::handle($request, $next);
        } catch (\Illuminate\Session\TokenMismatchException $e) {
            // Log CSRF attempt
            Log::warning('CSRF token mismatch detected', [
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'user_agent' => $request->userAgent(),
                'user_id' => auth()->id(),
            ]);

            // Check if request expects JSON
            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sesi Anda telah berakhir. Silakan refresh halaman dan coba lagi.',
                    'error_type' => 'csrf_mismatch',
                ], 419);
            }

            // Redirect back with error
            return back()
                ->withInput()
                ->with('error', 'Sesi Anda telah berakhir. Silakan coba lagi.');
        }
    }

    /**
     * Determine if the request has a valid CSRF token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function tokensMatch($request)
    {
        // Get tokens
        $sessionToken = $request->session()->token();
        $requestToken = $request->input('_token') ?: $request->header('X-CSRF-TOKEN');

        if (! $requestToken) {
            return false;
        }

        // Use hash_equals to prevent timing attacks
        return hash_equals($sessionToken, $requestToken);
    }
}
