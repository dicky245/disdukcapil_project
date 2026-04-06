<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeadersMiddleware
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
        $response = $next($request);

        $headers = config('security.headers', []);

        // X-Frame-Options - Prevent Clickjacking
        if (isset($headers['x-frame-options'])) {
            $response->headers->set('X-Frame-Options', $headers['x-frame-options']);
        }

        // X-Content-Type-Options - Prevent MIME Sniffing
        if (isset($headers['x-content-type-options'])) {
            $response->headers->set('X-Content-Type-Options', $headers['x-content-type-options']);
        }

        // X-XSS-Protection - XSS Protection
        if (isset($headers['x-xss-protection'])) {
            $response->headers->set('X-XSS-Protection', $headers['x-xss-protection']);
        }

        // Strict-Transport-Security - Force HTTPS
        if (isset($headers['strict-transport-security']) && app()->environment('production')) {
            $response->headers->set('Strict-Transport-Security', $headers['strict-transport-security']);
        }

        // Referrer-Policy
        if (isset($headers['referrer-policy'])) {
            $response->headers->set('Referrer-Policy', $headers['referrer-policy']);
        }

        // Permissions-Policy
        if (isset($headers['permissions-policy'])) {
            $response->headers->set('Permissions-Policy', $headers['permissions-policy']);
        }

        // Content-Security-Policy
        if (config('security.csp.enabled', true)) {
            $csp = $this->buildCSP();
            if ($csp) {
                $headerName = config('security.csp.report_only', false)
                    ? 'Content-Security-Policy-Report-Only'
                    : 'Content-Security-Policy';
                $response->headers->set($headerName, $csp);
            }
        }

        // Remove server information
        $response->headers->remove('X-Powered-By');
        $response->headers->set('Server', 'SecureServer');

        return $response;
    }

    /**
     * Build Content Security Policy string
     *
     * @return string
     */
    private function buildCSP(): string
    {
        $directives = config('security.csp.directives', []);
        $policies = [];

        foreach ($directives as $directive => $values) {
            if (is_array($values) && count($values) > 0) {
                $policies[] = $directive . ' ' . implode(' ', $values);
            }
        }

        $csp = implode('; ', $policies);

        // Add report-uri if configured
        $reportUri = config('security.csp.report_uri');
        if ($reportUri) {
            $csp .= '; report-uri ' . $reportUri;
        }

        return $csp;
    }
}
