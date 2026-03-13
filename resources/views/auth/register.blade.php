<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Admin - Disdukcapil Kabupaten Toba</title>

    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo_toba.jpeg') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        emerald: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #0052CC;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #0047B3;
        }

        /* Animated Background */
        .bg-animated {
            background: linear-gradient(-45deg, #0052CC, #0066FF, #0047B3, #003D9A);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Float Animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .float-animation {
            animation: float 6s ease-in-out infinite;
        }

        /* Input Focus Animation */
        .input-group {
            position: relative;
        }

        .input-group input:focus ~ label,
        .input-group input:not(:placeholder-shown) ~ label,
        .input-group select:focus ~ label,
        .input-group select:valid ~ label {
            transform: translateY(-24px) scale(0.85);
            color: #0052CC;
        }

        .input-group label {
            transition: all 0.3s ease;
        }

        /* Button Ripple */
        .btn-ripple {
            position: relative;
            overflow: hidden;
        }

        .btn-ripple::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-ripple:active::after {
            width: 300px;
            height: 300px;
        }

        /* Password Strength Indicator */
        .strength-meter {
            height: 4px;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .strength-weak { background: #ef4444; width: 33%; }
        .strength-medium { background: #f59e0b; width: 66%; }
        .strength-strong { background: #10b981; width: 100%; }
    </style>
</head>
<body class="bg-animated min-h-screen flex items-center justify-center p-4">

    <!-- Background Particles -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute w-64 h-64 bg-white/10 rounded-full -top-32 -left-32 float-animation"></div>
        <div class="absolute w-96 h-96 bg-white/10 rounded-full -bottom-48 -right-48 float-animation" style="animation-delay: 2s;"></div>
        <div class="absolute w-48 h-48 bg-white/10 rounded-full top-1/4 right-1/4 float-animation" style="animation-delay: 4s;"></div>
    </div>

    <!-- Register Container -->
    <div class="relative z-10 w-full max-w-md">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-white rounded-2xl shadow-xl mb-4 float-animation overflow-hidden border-4 border-white/30">
                <img src="{{ asset('images/logo_toba.jpeg') }}" alt="Logo Kabupaten Toba" class="w-full h-full object-contain">
            </div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-2">Disdukcapil Toba</h1>
            <p class="text-blue-100 text-lg">Registrasi Admin</p>
        </div>

        <!-- Register Card -->
        <div class="bg-white rounded-3xl shadow-2xl p-8">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-1">Buat Akun Admin</h2>
                <p class="text-gray-600">Registrasi hanya dapat dilakukan sekali</p>
            </div>

            <!-- Info Message -->
            @if (session('info'))
                <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-xl mb-4">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-info-circle"></i>
                        <span>{{ session('info') }}</span>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.register.submit') }}" class="space-y-5" id="registerForm">
                @csrf

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Name Input -->
                <div class="input-group">
                    <input type="text" id="name" name="name" required placeholder=" "
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition peer"
                           value="{{ old('name') }}">
                    <label for="name" class="absolute left-4 top-3 text-gray-400 pointer-events-none">
                        <i class="fas fa-user mr-2"></i>Nama Lengkap
                    </label>
                </div>

                <!-- Username Input -->
                <div class="input-group">
                    <input type="text" id="username" name="username" required placeholder=" "
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition peer"
                           value="{{ old('username') }}">
                    <label for="username" class="absolute left-4 top-3 text-gray-400 pointer-events-none">
                        <i class="fas fa-at mr-2"></i>Username
                    </label>
                </div>

                <!-- Password Input -->
                <div class="input-group">
                    <div class="relative">
                        <input type="password" id="password" name="password" required placeholder=" "
                               class="w-full px-4 py-3 pr-12 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition peer">
                        <label for="password" class="absolute left-4 top-3 text-gray-400 pointer-events-none">
                            <i class="fas fa-lock mr-2"></i>Password
                        </label>
                        <button type="button" onclick="togglePassword('password', 'eyeIcon1')" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye" id="eyeIcon1"></i>
                        </button>
                    </div>
                    <!-- Password Strength Indicator -->
                    <div class="mt-2 h-1 bg-gray-200 rounded-full overflow-hidden">
                        <div id="strengthMeter" class="strength-meter"></div>
                    </div>
                    <p id="strengthText" class="text-xs mt-1 text-gray-500"></p>
                </div>

                <!-- Confirm Password Input -->
                <div class="input-group">
                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation" required placeholder=" "
                               class="w-full px-4 py-3 pr-12 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition peer">
                        <label for="password_confirmation" class="absolute left-4 top-3 text-gray-400 pointer-events-none">
                            <i class="fas fa-lock mr-2"></i>Konfirmasi Password
                        </label>
                        <button type="button" onclick="togglePassword('password_confirmation', 'eyeIcon2')" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye" id="eyeIcon2"></i>
                        </button>
                    </div>
                </div>

                <!-- Security Question Select -->
                <div class="input-group">
                    <select id="security_question_id" name="security_question_id" required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition peer appearance-none bg-white">
                        <option value="" disabled selected></option>
                        @foreach($securityQuestions as $question)
                            <option value="{{ $question->id }}" {{ old('security_question_id') == $question->id ? 'selected' : '' }}>
                                {{ $question->question }}
                            </option>
                        @endforeach
                    </select>
                    <label for="security_question_id" class="absolute left-4 top-3 text-gray-400 pointer-events-none">
                        <i class="fas fa-shield-alt mr-2"></i>Pilih Pertanyaan Keamanan
                    </label>
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>

                <!-- Security Answer Input -->
                <div class="input-group">
                    <input type="text" id="security_answer" name="security_answer" required placeholder=" "
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition peer"
                           value="{{ old('security_answer') }}">
                    <label for="security_answer" class="absolute left-4 top-3 text-gray-400 pointer-events-none">
                        <i class="fas fa-key mr-2"></i>Jawaban Pertanyaan Keamanan
                    </label>
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="fas fa-info-circle mr-1"></i>
                        Jawaban akan dienkripsi untuk keamanan
                    </p>
                </div>

                <!-- Warning Message -->
                <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-xl">
                    <div class="flex items-start gap-2">
                        <i class="fas fa-exclamation-triangle mt-0.5"></i>
                        <p class="text-sm">
                            <strong>PENTING:</strong> Registrasi hanya dapat dilakukan sekali. Pastikan Anda mengingat username, password, dan jawaban pertanyaan keamanan dengan baik.
                        </p>
                    </div>
                </div>

                <!-- Register Button -->
                <button type="submit" class="w-full py-4 bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded-xl font-bold text-lg hover:from-blue-700 hover:to-cyan-700 transition-all transform hover:scale-[1.02] shadow-lg btn-ripple flex items-center justify-center gap-2">
                    <i class="fas fa-user-plus"></i>
                    Daftar Sekarang
                </button>
            </form>

            <!-- Divider -->
            <div class="flex items-center gap-4 my-6">
                <div class="flex-1 h-px bg-gray-200"></div>
                <span class="text-sm text-gray-400">atau</span>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>

            <!-- Back to Login -->
            <div class="text-center">
                <a href="{{ route('admin.login') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-blue-600 font-medium transition">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Login
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6 text-blue-100 text-sm">
            <p>&copy; 2025 Disdukcapil Kabupaten Toba</p>
        </div>
    </div>

    <script>
        // Toggle Password Visibility
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(iconId);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }

        // Password Strength Checker
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthMeter = document.getElementById('strengthMeter');
            const strengthText = document.getElementById('strengthText');

            let strength = 0;

            // Check password length
            if (password.length >= 8) strength++;
            if (password.length >= 12) strength++;

            // Check for lowercase
            if (/[a-z]/.test(password)) strength++;

            // Check for uppercase
            if (/[A-Z]/.test(password)) strength++;

            // Check for numbers
            if (/[0-9]/.test(password)) strength++;

            // Check for special characters
            if (/[^A-Za-z0-9]/.test(password)) strength++;

            // Update strength meter
            strengthMeter.className = 'strength-meter';

            if (strength <= 2) {
                strengthMeter.classList.add('strength-weak');
                strengthText.textContent = 'Lemah - Tambahkan karakter, angka, dan simbol';
                strengthText.className = 'text-xs mt-1 text-red-500';
            } else if (strength <= 4) {
                strengthMeter.classList.add('strength-medium');
                strengthText.textContent = 'Sedang - Bisa lebih kuat';
                strengthText.className = 'text-xs mt-1 text-yellow-500';
            } else {
                strengthMeter.classList.add('strength-strong');
                strengthText.textContent = 'Kuat - Password yang baik!';
                strengthText.className = 'text-xs mt-1 text-green-500';
            }
        });

        // Auto-hide flash messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const flashMessages = document.querySelectorAll('.bg-blue-50, .bg-green-50, .bg-yellow-50, .bg-red-50');
            flashMessages.forEach(function(message) {
                setTimeout(function() {
                    message.style.opacity = '0';
                    message.style.transition = 'opacity 0.5s ease';
                    setTimeout(function() {
                        message.remove();
                    }, 500);
                }, 5000);
            });
        });
    </script>
</body>
</html>
