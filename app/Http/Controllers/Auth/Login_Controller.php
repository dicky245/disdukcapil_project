<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Login_Controller extends Controller
{
    /**
     * Tampilkan form login
     */
    public function show_login_form()
    {
        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = [
            'email' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Redirect berdasarkan role user
            if ($user->hasRole('Admin')) {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($user->hasRole('Keagamaan')) {
                return redirect()->intended(route('keagamaan.dashboard'));
            } elseif ($user->hasRole('Operator')) {
                return redirect()->intended(route('operator.dashboard'));
            } elseif ($user->hasRole('Guru')) {
                return redirect()->intended(route('guru.dashboard'));
            } elseif ($user->hasRole('Siswa')) {
                return redirect()->intended(route('siswa.dashboard'));
            }

            // Default redirect
            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->withInput($request->only('username', 'remember'));
    }

    /**
     * Proses logout
     */
    public function logout(Request $request)
    {
        // Simpan nama user sebelum logout untuk pesan
        $userName = Auth::user()->name ?? 'Pengguna';

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', "Terima kasih, $userName! Anda telah berhasil logout.");
    }
}
