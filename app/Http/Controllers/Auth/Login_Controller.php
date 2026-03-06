<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class Login_Controller extends Controller
{
    /**
     * Tampilkan form login
     */
    public function tampilkan_form_login()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return response()
            ->view('auth.login', ['isAdmin' => false])
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    }

    /**
     * Proses login
     */
    public function proses_login(Request $request)
    {
        // Validation
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Log untuk debugging
        Log::info('Login attempt for username: ' . $request->username);

        // Cari user berdasarkan username
        $user = User::where('username', $request->username)->first();

        // Cek apakah user ada
        if (!$user) {
            Log::warning('Login failed - user not found: ' . $request->username);
            return back()->withErrors([
                'username' => 'Username atau password salah.',
            ])->onlyInput('username');
        }

        // Verifikasi password
        if (!Hash::check($request->password, $user->password)) {
            Log::warning('Login failed - invalid password for: ' . $request->username);
            return back()->withErrors([
                'username' => 'Username atau password salah.',
            ])->onlyInput('username');
        }

        // Login user
        Auth::login($user);
        $request->session()->regenerate();

        Log::info('Login successful for: ' . $user->username . ' (ID: ' . $user->id . ')');

        // Redirect berdasarkan role
        if ($user->hasRole('Admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('Keagamaan')) {
            return redirect()->route('keagamaan.dashboard');
        }

        return redirect()->route('home');
    }

    /**
     * Tampilkan form login admin
     */
    public function adminLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login', ['isAdmin' => true]);
    }

    /**
     * Proses login admin
     */
    public function adminLogin(Request $request)
    {
        // Validation
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cari user berdasarkan username
        $user = User::where('username', $request->username)->first();

        // Cek apakah user ada
        if (!$user) {
            return back()->withErrors([
                'login_error' => 'Username atau password salah!',
            ])->onlyInput('username');
        }

        // Verifikasi password
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'login_error' => 'Username atau password salah!',
            ])->onlyInput('username');
        }

        // Cek apakah user adalah admin
        if (!$user->hasRole('Admin')) {
            return back()->withErrors([
                'login_error' => 'Anda tidak memiliki akses ke panel admin.',
            ])->onlyInput('username');
        }

        // Login user
        Auth::login($user);
        $request->session()->regenerate();

        // Redirect ke dashboard admin
        return redirect()->route('admin.dashboard')->with('success', 'Selamat datang, ' . $user->name);
    }

    /**
     * Proses logout
     */
    public function proses_logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }
}
