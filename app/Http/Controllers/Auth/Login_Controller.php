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
        // Jika user sudah login, tetap tampilkan halaman login dengan notifikasi
        // Jangan redirect agar user bisa memilih untuk logout atau melanjutkan ke dashboard

        // Cek apakah belum ada admin - jika belum, tampilkan pesan untuk registrasi
        $adminExists = User::whereHas('roles', function($query) {
            $query->where('name', 'Admin');
        })->exists();

        // Gunakan response() untuk menambahkan headers
        return response()
            ->view('auth.login', [
                'isAdmin' => false,
                'adminExists' => $adminExists
            ])
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

        // Redirect berdasarkan role dengan notifikasi sukses
        if ($user->hasRole('Admin')) {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Selamat datang kembali, ' . $user->name . '. Anda berhasil login sebagai Admin.');
        } elseif ($user->hasRole('Keagamaan')) {
            return redirect()->route('keagamaan.dashboard')
                ->with('success', 'Selamat datang kembali, ' . $user->name . '. Anda berhasil login sebagai Petugas Keagamaan.');
        }

        // Fallback (seharusnya tidak terjadi karena semua user harus punya role)
        return redirect()->route('admin.dashboard')
            ->with('info', 'Selamat datang, ' . $user->name . '.');
    }

    /**
     * Tampilkan form login admin
     */
    public function adminLoginForm()
    {
        // Jika user sudah login, tetap tampilkan halaman login dengan notifikasi
        // Jangan redirect agar user bisa memilih untuk logout atau melanjutkan ke dashboard

        // Cek apakah belum ada admin
        $adminExists = User::whereHas('roles', function($query) {
            $query->where('name', 'Admin');
        })->exists();

        // Jika belum ada admin, redirect ke registrasi
        if (!$adminExists) {
            return redirect()->route('admin.register')
                ->with('info', 'Silakan lakukan registrasi admin pertama kali.');
        }

        // Gunakan response() untuk menambahkan headers
        return response()
            ->view('auth.login', [
                'isAdmin' => true,
                'adminExists' => $adminExists
            ])
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    }

    /**
     * Proses login admin dengan verifikasi pertanyaan keamanan
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

        // Username dan password benar - redirect ke verifikasi pertanyaan keamanan
        return redirect()->route('admin.verify.question', ['user_id' => $user->id])
            ->with('info', 'Username dan password benar. Silakan verifikasi dengan pertanyaan keamanan.');
    }

    /**
     * Tampilkan halaman verifikasi pertanyaan keamanan
     */
    public function showVerifyQuestion($user_id)
    {
        $user = User::where('id', $user_id)->first();

        if (!$user) {
            return redirect()->route('admin.login')
                ->withErrors(['login_error' => 'User tidak ditemukan.']);
        }

        // Load pertanyaan keamanan
        $user->load('securityQuestion');

        if (!$user->securityQuestion) {
            return redirect()->route('admin.login')
                ->withErrors(['login_error' => 'Pertanyaan keamanan tidak ditemukan.']);
        }

        return view('auth.verify-question', compact('user'));
    }

    /**
     * Proses logout dengan notifikasi
     */
    public function proses_logout(Request $request)
    {
        // Ambil nama user sebelum logout untuk notifikasi
        $userName = auth()->user()->name ?? 'Pengguna';

        // Logout user
        Auth::logout();

        // Invalidate session
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();

        // Flush all session data
        $request->session()->flush();

        Log::info('User logged out', ['name' => $userName]);

        return redirect()->route('login')
            ->with('success', 'Terima kasih, ' . $userName . '. Anda telah berhasil logout dari sistem.');
    }
}
