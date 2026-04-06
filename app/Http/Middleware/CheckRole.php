<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  $role
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Anda harus login terlebih dahulu.');
        }

        $user = Auth::user();

        if (!$user->hasRole($role)) {
            Log::warning('Unauthorized access attempt - wrong role', [
                'user_id' => $user->id,
                'required_role' => $role,
                'user_roles' => $user->roles->pluck('name'),
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
            ]);

            return redirect()->route('login')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
