<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserActivity
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
        if (Auth::check()) {
            $user = Auth::user();
            $sessionKey = 'last_activity_' . $user->id;
            $currentTime = now();

            // Get last activity from session
            $lastActivity = session()->get($sessionKey);

            // Check if session has expired
            if ($lastActivity && $currentTime->diffInMinutes($lastActivity) >= 10) {
                // Logout user
                Auth::logout();

                // Invalidate and regenerate session
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // Clear all session data
                $request->session()->flush();

                return redirect()->route('login')
                    ->with('warning', 'Anda telah logout secara otomatis karena tidak ada aktivitas selama 10 menit.');
            }

            // Update last activity timestamp
            session()->put($sessionKey, $currentTime);
        }

        return $next($request);
    }
}
