<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Cek role dan redirect ke dashboard yang sesuai
                $user = Auth::guard($guard)->user();

                if ($user->hasRole('Admin')) {
                    return redirect()->route('admin.dashboard');
                } elseif ($user->hasRole('Keagamaan')) {
                    return redirect()->route('keagamaan.dashboard');
                } elseif ($user->hasRole('Operator')) {
                    return redirect()->route('operator.dashboard');
                } elseif ($user->hasRole('Guru')) {
                    return redirect()->route('guru.dashboard');
                } elseif ($user->hasRole('Siswa')) {
                    return redirect()->route('siswa.dashboard');
                }

                // Default redirect ke home
                return redirect()->route('home');
            }
        }

        return $next($request);
    }
}
