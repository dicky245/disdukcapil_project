<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SecurityQuestion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    /**
     * Tampilkan form registrasi admin
     */
    public function showRegistrationForm()
    {
        // Cek apakah sudah ada user dengan role Admin
        $adminExists = User::whereHas('roles', function($query) {
            $query->where('name', 'Admin');
        })->exists();

        // Jika sudah ada admin, redirect ke login
        if ($adminExists) {
            return redirect()->route('admin.login')
                ->with('info', 'Registrasi sudah dilakukan. Silakan login dengan akun yang sudah terdaftar.');
        }

        // Ambil semua pertanyaan keamanan
        $securityQuestions = SecurityQuestion::all();

        return view('auth.register', compact('securityQuestions'));
    }

    /**
     * Proses registrasi admin
     */
    public function register(Request $request)
    {
        // Cek apakah sudah ada user dengan role Admin
        $adminExists = User::whereHas('roles', function($query) {
            $query->where('name', 'Admin');
        })->exists();

        // Jika sudah ada admin, kembalikan error
        if ($adminExists) {
            return redirect()->route('admin.login')
                ->with('warning', 'Registrasi sudah dilakukan sebelumnya. Hanya boleh ada satu admin.');
        }

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:8|confirmed',
            'security_question_id' => 'required|exists:security_questions,id',
            'security_answer' => 'required|string|min:2',
        ], [
            'name.required' => 'Nama lengkap harus diisi.',
            'username.required' => 'Username harus diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'security_question_id.required' => 'Silakan pilih pertanyaan keamanan.',
            'security_question_id.exists' => 'Pertanyaan keamanan tidak valid.',
            'security_answer.required' => 'Jawaban pertanyaan keamanan harus diisi.',
            'security_answer.min' => 'Jawaban terlalu pendek.',
        ]);

        try {
            DB::beginTransaction();

            // Buat role Admin jika belum ada
            $adminRole = Role::firstOrCreate(['name' => 'Admin']);

            // Enkripsi jawaban pertanyaan keamanan
            $encryptedAnswer = Crypt::encrypt($request->security_answer);

            // Buat user admin baru
            $admin = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'security_question_id' => $request->security_question_id,
                'security_question_answer' => $encryptedAnswer,
            ]);

            // Assign role Admin ke user
            $admin->assignRole($adminRole);

            DB::commit();

            Log::info('Admin registered successfully', [
                'username' => $admin->username,
                'id' => $admin->id,
            ]);

            return redirect()->route('admin.login')
                ->with('success', 'Registrasi berhasil! Silakan login dengan akun admin Anda.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Admin registration failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.']);
        }
    }

    /**
     * Verifikasi jawaban pertanyaan keamanan
     */
    public function verifySecurityQuestion(Request $request)
    {
        // Validasi input
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'security_answer' => 'required|string',
        ]);

        // Cari user berdasarkan ID
        $user = User::find($request->user_id);

        if (!$user) {
            return redirect()->route('admin.login')
                ->withErrors(['login_error' => 'User tidak ditemukan.']);
        }

        try {
            // Dekripsi jawaban yang tersimpan
            $decryptedAnswer = Crypt::decrypt($user->security_question_answer);

            // Bandingkan jawaban (case-insensitive)
            if (strcasecmp(trim($request->security_answer), trim($decryptedAnswer)) === 0) {
                // Jawaban benar - login user
                Auth::login($user);
                $request->session()->regenerate();

                Log::info('Admin login successful with security question', [
                    'username' => $user->username,
                    'id' => $user->id,
                ]);

                return redirect()->route('admin.dashboard')
                    ->with('success', 'Selamat datang, ' . $user->name);
            } else {
                // Jawaban salah
                Log::warning('Security question verification failed', [
                    'username' => $user->username,
                    'id' => $user->id,
                ]);

                return redirect()->back()
                    ->withInput()
                    ->withErrors([
                        'security_answer' => 'Jawaban pertanyaan keamanan salah. Silakan coba lagi.'
                    ]);
            }
        } catch (\Exception $e) {
            Log::error('Security question verification error', [
                'error' => $e->getMessage(),
                'user_id' => $user->id,
            ]);

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat verifikasi. Silakan coba lagi.']);
        }
    }
}
