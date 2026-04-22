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
        $adminExists = User::whereHas('roles', function ($query) {
            $query->where('name', 'Admin');
        })->exists();

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
     * Proses login (Untuk Petugas Keagamaan & Admin)
     */
    public function proses_login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        // Cari user dengan eager load detail_keagamaan dan roles
        $user = User::with(['detail_keagamaan', 'roles'])->where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Cek apakah akun aktif
            $status = $user->detail_keagamaan?->status ?? 'aktif';
            if ($status !== 'aktif') {
                return back()->withErrors(['username' => 'Akun dinonaktifkan.']);
            }

            Auth::login($user);
            
            // Redirect ke dashboard sesuai role
            if ($user->hasRole('Admin')) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->hasRole('Keagamaan')) {
                return redirect()->route('keagamaan.dashboard');
            }
            
            return redirect()->intended('/');
        }

        return back()->withErrors(['username' => 'Username atau Password salah.']);
    }

    /**
     * Tampilkan form login admin
     */
    public function adminLoginForm()
    {
        $adminExists = User::whereHas('roles', function ($query) {
            $query->where('name', 'Admin');
        })->exists();

        if (!$adminExists) {
            return redirect()->route('admin.register')
                ->with('info', 'Silakan lakukan registrasi admin pertama kali.');
        }

        return response()
            ->view('auth.login', [
                'isAdmin' => true,
                'adminExists' => $adminExists
            ])
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }

    /**
     * Proses login admin
     */
    public function adminLogin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'login_error' => 'Username atau password salah!',
            ])->onlyInput('username');
        }

        // Cek Role Admin
        if (!$user->hasRole('Admin')) {
            return back()->withErrors([
                'login_error' => 'Anda tidak memiliki akses ke panel admin.',
            ])->onlyInput('username');
        }

        // Redirect ke verifikasi pertanyaan keamanan
        return redirect()->route('admin.verify.question', ['user_id' => $user->id])
            ->with('info', 'Verifikasi pertanyaan keamanan diperlukan.');
    }

    /**
     * Tampilkan halaman verifikasi pertanyaan keamanan
     */
    public function showVerifyQuestion($user_id)
    {
        $user = User::where('id', $user_id)->first();

        if (!$user) {
            return redirect()->route('admin.login')->withErrors(['login_error' => 'User tidak ditemukan.']);
        }

        $user->load('securityQuestion');

        return view('auth.verify-question', compact('user'));
    }

    /**
     * Proses logout
     */
    public function proses_logout(Request $request)
    {
        $userName = auth()->user()->name ?? 'Pengguna';

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->flush();

        return redirect()->route('login')
            ->with('success', 'Terima kasih, ' . $userName . '. Anda telah logout.');
    }
}
