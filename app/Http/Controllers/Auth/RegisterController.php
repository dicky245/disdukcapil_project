<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SecurityQuestion;
use App\Models\User;
use App\Exceptions\DatabaseException;
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
        $adminRole = Role::where('name', 'Admin')->first();
        $adminExists = $adminRole && $adminRole->users()->exists();

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
        $adminRole = Role::where('name', 'Admin')->first();
        $adminExists = $adminRole && $adminRole->users()->exists();

        // Jika sudah ada admin, kembalikan error
        if ($adminExists) {
            return redirect()->route('admin.login')
                ->with('warning', 'Registrasi sudah dilakukan sebelumnya. Hanya boleh ada satu admin.');
        }

        // Validasi input
        $validated = $request->validate([
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

            // Enkripsi jawaban pertanyaan keamanan
            $encryptedAnswer = Crypt::encrypt($validated['security_answer']);

            // Buat user admin baru
            $admin = User::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'password' => Hash::make($validated['password']),
                'security_question_id' => $validated['security_question_id'],
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
                ->with('success', 'Registrasi berhasil! Akun admin telah berhasil dibuat. Username: ' . $admin->username . '. Silakan login untuk melanjutkan.');

        } catch (\Exception $e) {
            DB::rollBack();

            // Format error untuk user
            $errorInfo = DatabaseException::formatForUser($e);

            Log::error('Admin registration failed', [
                'error_code' => $errorInfo['error_code'],
                'error' => $e->getMessage(),
                'location' => $errorInfo['location'],
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->withInput()
                ->withErrors(['registration_error' => $errorInfo['user_message']])
                ->with('error', $errorInfo['user_message'])
                ->with('error_detail', $errorInfo['technical_detail'])
                ->with('error_location', $errorInfo['location'])
                ->with('error_solution', $errorInfo['solution'])
                ->with('error_code', $errorInfo['error_code']);
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
                    ->with('success', 'Login berhasil! Selamat datang, ' . $user->name . '. Verifikasi pertanyaan keamanan telah berhasil.');
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
