<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Mandiri - Disdukcapil Kabupaten Toba</title>
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
                        blue: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#0052CC',
                            700: '#003d99',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        },
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
            scroll-behavior: smooth;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
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

        /* Stepper Progress */
        .stepper-line {
            position: absolute;
            top: 24px;
            left: 50%;
            transform: translateX(-50%);
            width: calc(100% - 48px);
            height: 4px;
            background: #e5e7eb;
            z-index: 0;
        }

        .stepper-line-fill {
            height: 100%;
            background: linear-gradient(90deg, #0052CC, #0047B3);
            transition: width 0.5s ease;
        }

        /* Reveal Animation */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease-out;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 16px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            animation: modalSlide 0.3s ease-out;
        }

        @keyframes modalSlide {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(-20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        /* Skeleton Loading */
        .skeleton {
            background: linear-gradient(90deg, #e5e7eb 25%, #f3f4f6 50%, #e5e7eb 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
            border-radius: 8px;
        }

        @keyframes shimmer {
            0% {
                background-position: 200% 0;
            }
            100% {
                background-position: -200% 0;
            }
        }

        .skeleton-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .skeleton-text {
            height: 16px;
            margin-bottom: 8px;
        }

        .skeleton-title {
            height: 24px;
            width: 60%;
            margin-bottom: 12px;
        }

        .skeleton-circle {
            border-radius: 50%;
        }

        .page-loading {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: #f9fafb;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .page-loading.hidden {
            display: none;
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Page Loading Skeleton -->
    <div id="pageLoading" class="page-loading">
        <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mb-4 skeleton">
            <span class="text-3xl">🏛️</span>
        </div>
        <div class="skeleton w-48 h-6 mb-4"></div>
        <div class="skeleton w-32 h-4"></div>
    </div>

    <!-- Header Navigation -->
    <header class="fixed top-0 left-0 right-0 bg-white/95 backdrop-blur-md shadow-sm z-50 transition-all duration-300" id="mainHeader">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="{{ route('home')}}" class="flex items-center gap-3 hover:scale-105 transition-transform">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center">
                        <span class="text-xl">🏛️</span>
                    </div>
                    <div>
                        <span class="text-lg font-bold text-gray-800">Disdukcapil Toba</span>
                        <p class="text-xs text-gray-500 -mt-1">Kabupaten Toba</p>
                    </div>
                </a>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center gap-1">
                    <a href="{{ route('home') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition">
                        <i class="fas fa-home mr-2"></i>Beranda
                    </a>
                    <a href="antrian_online.html" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition">
                        <i class="fas fa-ticket-alt mr-2"></i>Antrian Online
                    </a>
                    <a href="{{ route('layanan') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-blue-600 bg-blue-50">
                        <i class="fas fa-rocket mr-2"></i>Layanan Mandiri
                    </a>
                    <a href="visualisasi_data.html" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition">
                        <i class="fas fa-chart-line mr-2"></i>Statistik
                    </a>
                    <a href="login.html" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login
                    </a>
                </nav>

                <!-- Mobile Menu Button -->
                <button id="mobileMenuBtn" class="md:hidden p-2 rounded-lg hover:bg-gray-100">
                    <i class="fas fa-bars text-gray-600"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobileMenu" class="md:hidden hidden bg-white border-t">
            <nav class="px-4 py-3 space-y-1">
                <a href="user.html" class="block px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50">
                    <i class="fas fa-home mr-2"></i>Beranda
                </a>
                <a href="antrian_online.html" class="block px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50">
                    <i class="fas fa-ticket-alt mr-2"></i>Antrian Online
                </a>
                <a href="layanan_mandiri.html" class="block px-4 py-2 rounded-lg text-sm font-medium text-blue-600 bg-blue-50">
                    <i class="fas fa-rocket mr-2"></i>Layanan Mandiri
                </a>
                <a href="visualisasi_data.html" class="block px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50">
                    <i class="fas fa-chart-line mr-2"></i>Statistik
                </a>
                <a href="login.html" class="block px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login
                </a>
            </nav>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center">
                            <span class="text-2xl">🏛️</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">Disdukcapil Toba</h3>
                            <p class="text-gray-400 text-sm">Kabupaten Toba</p>
                        </div>
                    </div>
                    <p class="text-gray-400 mb-4">
                        Melayani dengan sepenuh hati untuk administrasi kependudukan yang tertib dan modern
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-blue-600 rounded-lg flex items-center justify-center transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-blue-600 rounded-lg flex items-center justify-center transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-blue-600 rounded-lg flex items-center justify-center transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-blue-600 rounded-lg flex items-center justify-center transition">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Layanan</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="antrian_online.html" class="hover:text-blue-400 transition">Antrian Online</a></li>
                        <li><a href="layanan_mandiri.html" class="hover:text-blue-400 transition">Layanan Mandiri</a></li>
                        <li><a href="visualisasi_data.html" class="hover:text-blue-400 transition">Statistik</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-center gap-2">
                            <i class="fas fa-map-marker-alt text-blue-500"></i>
                            Balige, Kabupaten Toba
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-phone text-blue-500"></i>
                            (0632) 123456
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-envelope text-blue-500"></i>
                            info@disdukcapil-toba.go.id
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-500">
                <p>&copy; 2025 Disdukcapil Kabupaten Toba. Seluruh hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');

        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Hide loading page
        window.addEventListener('load', () => {
            setTimeout(() => {
                document.getElementById('pageLoading').classList.add('hidden');
            }, 500);
        });

        // Service Selection
        function selectService(service) {
            const serviceNames = {
                'kk': 'Kartu Keluarga',
                'akta-lahir': 'Akta Kelahiran',
                'akta-kematian': 'Akta Kematian',
                'Lahir Mati': 'Akta Lahir Mati',
                'kawin': 'Akta Perkawinan',
            };

            document.getElementById('modalTitle').textContent = `Form Pengajuan ${serviceNames[service]}`;
            document.getElementById('modalSubtitle').textContent = `Lengkapi data untuk ${serviceNames[service]}`;

            // Show modal
            document.getElementById('serviceModal').classList.add('active');

            // Update stepper
            updateStepper(2);
        }

        function closeModal() {
            document.getElementById('serviceModal').classList.remove('active');
            document.getElementById('applicationForm').reset();
            updateStepper(1);
        }

        // Update Stepper
        function updateStepper(step) {
            const percentage = ((step - 1) / 3) * 100;
            document.getElementById('stepperFill').style.width = percentage + '%';

            document.querySelectorAll('.stepper-item').forEach(item => {
                const itemStep = parseInt(item.dataset.step);
                const circle = item.querySelector('div');
                const icon = circle.querySelector('i');
                const text = item.querySelector('p');

                if (itemStep < step) {
                    // Completed
                    circle.className = 'w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-2 relative z-10 shadow-lg';
                    icon.className = 'fas fa-check text-white';
                    text.className = 'text-sm font-semibold text-blue-600';
                } else if (itemStep === step) {
                    // Active
                    circle.className = 'w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-2 relative z-10 shadow-lg ring-4 ring-blue-100';
                    text.className = 'text-sm font-semibold text-blue-600';
                } else {
                    // Inactive
                    circle.className = 'w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-2 relative z-10';
                    text.className = 'text-sm font-medium text-gray-500';
                }
            });
        }

        // File Upload
        document.getElementById('uploadArea').addEventListener('click', () => {
            document.getElementById('fileKtp').click();
        });

        document.getElementById('uploadSelfie').addEventListener('click', () => {
            document.getElementById('fileSelfie').click();
        });

        document.getElementById('fileKtp').addEventListener('change', function() {
            const fileName = this.files[0]?.name;
            if (fileName) {
                this.parentElement.querySelector('p').textContent = fileName;
                this.parentElement.classList.add('border-emerald-500', 'bg-emerald-50');
            }
        });

        document.getElementById('fileSelfie').addEventListener('change', function() {
            const fileName = this.files[0]?.name;
            if (fileName) {
                this.parentElement.querySelector('p').textContent = fileName;
                this.parentElement.classList.add('border-emerald-500', 'bg-emerald-50');
            }
        });

        // Form Submission
        document.getElementById('applicationForm').addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Kirim Pengajuan?',
                text: 'Pastikan semua data yang Anda masukkan sudah benar',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Kirim',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Berhasil!',
                        html: 'Pengajuan Anda telah dikirim.<br>Nomor Tiket: <strong>Tiket-20250226-' + Math.floor(Math.random() * 1000).toString().padStart(3, '0') + '</strong>',
                        icon: 'success',
                        confirmButtonColor: '#10b981',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        closeModal();
                        updateStepper(3);
                    });
                }
            });
        });

        // Tracking Form
        document.getElementById('trackingForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const ticket = document.getElementById('ticketNumber').value;

            // Show result (demo data)
            document.getElementById('resultTicket').textContent = ticket;
            document.getElementById('trackingResult').classList.remove('hidden');

            Swal.fire({
                title: 'Status Ditemukan!',
                text: 'Pengajuan Anda sedang dalam proses verifikasi',
                icon: 'info',
                confirmButtonColor: '#0052CC'
            });
        });

        // Scroll Reveal
        function reveal() {
            const reveals = document.querySelectorAll('.reveal');
            reveals.forEach(element => {
                const windowHeight = window.innerHeight;
                const elementTop = element.getBoundingClientRect().top;
                const elementVisible = 150;

                if (elementTop < windowHeight - elementVisible) {
                    element.classList.add('active');
                }
            });
        }

        window.addEventListener('scroll', reveal);
        reveal();

        // Header Scroll Effect
        const header = document.getElementById('mainHeader');
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 50) {
                header.classList.add('shadow-lg');
            } else {
                header.classList.remove('shadow-lg');
            }
        });

        // Close modal on outside click
        document.getElementById('serviceModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script> -->
</body>
</html>
