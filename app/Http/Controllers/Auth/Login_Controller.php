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
    public function tampilkan_form_login()
    {
        $adminExists = User::whereHas('roles', function ($query) {
            $query->where('name', 'Admin');
        })->exists();

        return response()
            ->view('auth.login', [
                'isAdmin' => false,
                'adminExists' => $adminExists,
            ])
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    }

    /**
     * Proses login (Gabungan: Petugas Keagamaan & Admin dengan Security Question)
     */
    public function proses_login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        Log::info('Login attempt for username: '.$request->username);

        $user = User::where('username', $request->username)->first();

        if (! $user) {
            Log::warning('Login failed - user not found: '.$request->username);

            return back()->withErrors([
                'username' => 'Username atau password salah.',
            ])->onlyInput('username');
        }

        if (! Hash::check($request->password, $user->password)) {
            Log::warning('Login failed - invalid password for: '.$request->username);

            return back()->withErrors([
                'username' => 'Username atau password salah.',
            ])->onlyInput('username');
        }

        // Cek apakah akun aktif (untuk Petugas Keagamaan)
        $userWithDetail = User::with(['detail_keagamaan', 'roles'])->where('username', $request->username)->first();
        $status = $userWithDetail->detail_keagamaan?->status ?? 'aktif';
        if ($status !== 'aktif') {
            return back()->withErrors(['username' => 'Akun dinonaktifkan.']);
        }

        // Jika Admin, cek security question
        if ($user->hasRole('Admin')) {
            $user->load('securityQuestion');

            if (! $user->securityQuestion || ! $user->security_question_id || ! $user->security_question_answer) {
                Log::warning('Admin login failed - no security question', [
                    'username' => $request->username,
                    'id' => $user->id,
                ]);

                return back()->withErrors([
                    'username' => 'Akun Anda belum lengkap. Silakan hubungi administrator.',
                ])->onlyInput('username');
            }

            if (Auth::check()) {
                Log::info('User already logged in, clearing session for admin login', [
                    'current_user_id' => Auth::id(),
                    'target_user_id' => $user->id,
                ]);
                Auth::logout();
            }

            $request->session()->forget('security_question_attempts');
            $request->session()->forget('security_question_user_id');
            $request->session()->put('security_question_user_id', $user->id);

            Log::info('Admin credentials verified, redirecting to security question', [
                'username' => $user->username,
                'id' => $user->id,
                'session_id' => $request->session()->getId(),
            ]);

            return redirect()->route('admin.verify.question', ['user_id' => $user->id])
                ->with('info', 'Username dan password benar. Silakan verifikasi dengan pertanyaan keamanan.');
        }

        // Login untuk user biasa atau Petugas Keagamaan
        Auth::login($user);
        $request->session()->regenerate(true);

        Log::info('Login successful for: '.$user->username.' (ID: '.$user->id.')');

        if ($user->hasRole('Keagamaan')) {
            return redirect()->route('keclesiastical.dashboard')
                ->with('success', 'Selamat datang kembali, '.$user->name.'. Anda berhasil login sebagai Petugas Keagamaan.');
        }

        return redirect()->route('admin.dashboard')
            ->with('info', 'Selamat datang, '.$user->name.'.');
    }

    public function adminLoginForm()
    {
        $adminExists = User::whereHas('roles', function ($query) {
            $query->where('name', 'Admin');
        })->exists();

        if (! $adminExists) {
            return redirect()->route('admin.register')
                ->with('info', 'Silakan lakukan registrasi admin pertama kali.');
        }

        return response()
            ->view('auth.login', [
                'isAdmin' => true,
                'adminExists' => $adminExists,
            ])
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }

    /**
     * Proses login admin (dengan logging lengkap)
     */
    public function adminLogin(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.max' => 'Username terlalu panjang.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $username = trim($request->username);

        $user = User::where('username', $username)->first();

        if (! $user) {
            Log::warning('Admin login failed - user not found', [
                'username' => $username,
                'ip' => $request->ip(),
            ]);

            return back()->withErrors([
                'login_error' => 'Username atau password salah!',
            ])->onlyInput('username');
        }

        if (! Hash::check($request->password, $user->password)) {
            Log::warning('Admin login failed - invalid password', [
                'username' => $username,
                'ip' => $request->ip(),
            ]);

            return back()->withErrors([
                'login_error' => 'Username atau password salah!',
            ])->onlyInput('username');
        }

        if (! $user->hasRole('Admin')) {
            Log::warning('Admin login failed - not admin role', [
                'username' => $username,
                'ip' => $request->ip(),
            ]);

            return back()->withErrors([
                'login_error' => 'Anda tidak memiliki akses ke panel admin.',
            ])->onlyInput('username');
        }

        $user->load('securityQuestion');

        if (! $user->securityQuestion || ! $user->security_question_id || ! $user->security_question_answer) {
            Log::warning('Admin login failed - no security question', [
                'username' => $username,
                'ip' => $request->ip(),
                'has_question' => ! empty($user->security_question_id),
                'has_answer' => ! empty($user->security_question_answer),
            ]);

            return back()->withErrors([
                'login_error' => 'Akun Anda belum lengkap. Silakan hubungi administrator.',
            ])->onlyInput('username');
        }

        $request->session()->forget('security_question_attempts');
        $request->session()->forget('security_question_user_id');

        Log::info('Admin login passed credentials', [
            'username' => $user->username,
            'id' => $user->id,
            'ip' => $request->ip(),
        ]);

        Log::info('Redirecting to security question verification', [
            'route' => 'admin.verify.question',
            'user_id' => $user->id,
        ]);

        return redirect()->route('admin.verify.question', ['user_id' => $user->id])
            ->with('info', 'Verifikasi pertanyaan keamanan diperlukan.');
    }

    public function showVerifyQuestion(Request $request, $user_id)
    {
        $user = User::find($user_id);

        if (! $user) {
            Log::warning('Security question page - user not found', [
                'user_id' => $user_id,
            ]);

            return redirect()->route('admin.login')
                ->withErrors(['login_error' => 'Sesi telah kedaluwarsa. Silakan login kembali.']);
        }

        $currentUser = $request->session()->get('security_question_user_id');

        if ($currentUser !== $user_id) {
            Log::warning('Security question page - session mismatch', [
                'session_user_id' => $currentUser,
                'requested_user_id' => $user_id,
            ]);

            return redirect()->route('admin.login')
                ->withErrors(['login_error' => 'Sesi tidak valid. Silakan login kembali.']);
        }

        $user->load('securityQuestion');

        if (! $user->securityQuestion) {
            Log::error('Security question page - no question found', [
                'user_id' => $user->id,
                'username' => $user->username,
            ]);

            return redirect()->route('admin.login')
                ->withErrors(['login_error' => 'Pertanyaan keamanan tidak ditemukan.']);
        }

        return view('auth.verify-question', compact('user'));
    }

    /**
     * Proses logout
     */
    public function proses_logout(Request $request)
    {
        $userName = Auth::user()?->name ?? 'Pengguna';

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->flush();

        return redirect()->route('login')
            ->with('success', 'Terima kasih, '.$userName.'. Anda telah berhasil logout dari sistem.');
    }
}
