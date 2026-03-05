<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Keagamaan - Disdukcapil Kabupaten Toba</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

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
            background: #003d99;
        }

        .sidebar {
            transition: all 0.3s ease;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar.collapsed .sidebar-text,
        .sidebar.collapsed .logo-text {
            display: none;
        }

        .sidebar-link {
            transition: all 0.2s ease;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background: #eff6ff;
            color: #0052CC;
            border-left-color: #0052CC;
        }

        .sidebar-link.active {
            border-left: 3px solid #0052CC;
        }

        .main-content {
            transition: all 0.3s ease;
        }

        .main-content.expanded {
            margin-left: 80px;
        }

        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 82, 204, 0.15);
        }

        .reveal {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease-out;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Sidebar -->
    <aside class="sidebar fixed left-0 top-0 h-full w-64 bg-white border-r border-gray-200 z-50 shadow-lg">
        <!-- Logo -->
        <div class="h-16 flex items-center px-6 border-b border-gray-100">
            <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center flex-shrink-0">
                <span class="text-lg">🏛️</span>
            </div>
            <span class="sidebar-text logo-text ml-3 font-bold text-lg text-gray-800">Disdukcapil</span>
        </div>

        <!-- Navigation -->
        <nav class="p-4 space-y-1 overflow-y-auto h-[calc(100vh-4rem)]">
            <a href="{{ route('keagamaan.dashboard') }}" class="sidebar-link active flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700">
                <i class="fas fa-home w-5"></i>
                <span class="sidebar-text font-medium">Dashboard</span>
            </a>

            <div class="pt-4 pb-2">
                <p class="sidebar-text px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Menu Keagamaan</p>
            </div>

            <a href="antrian-kalender.html" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700">
                <i class="fas fa-calendar-alt w-5"></i>
                <span class="sidebar-text font-medium">Antrian & Kalender</span>
            </a>
            <a href="sinkronisasi-dukcapil.html" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700">
                <i class="fas fa-sync w-5"></i>
                <span class="sidebar-text font-medium">Sinkronisasi Dukcapil</span>
            </a>
            <a href="manajemen-dokumen.html" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700">
                <i class="fas fa-file-alt w-5"></i>
                <span class="sidebar-text font-medium">Manajemen Dokumen</span>
            </a>

            <div class="pt-4 pb-2">
                <p class="sidebar-text px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Akun</p>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="sidebar-link w-full flex items-center gap-3 px-4 py-3 rounded-lg text-red-600 hover:bg-red-50">
                    <i class="fas fa-sign-out-alt w-5"></i>
                    <span class="sidebar-text font-medium">Logout</span>
                </button>
            </form>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content ml-64 min-h-screen">
        <!-- Header -->
        <header class="bg-white border-b border-gray-200 sticky top-0 z-40">
            <div class="flex items-center justify-between px-6 py-4">
                <!-- Left -->
                <div class="flex items-center gap-4">
                    <button id="sidebarToggle" class="p-2 hover:bg-gray-100 rounded-lg transition">
                        <i class="fas fa-bars text-gray-600"></i>
                    </button>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">Dashboard Keagamaan</h1>
                        <p class="text-sm text-gray-500">Selamat datang kembali, {{ auth()->user()->name }}</p>
                    </div>
                </div>

                <!-- Right -->
                <div class="flex items-center gap-4">
                    <!-- Notifications -->
                    <button class="relative p-2 hover:bg-gray-100 rounded-lg transition">
                        <i class="fas fa-bell text-gray-600"></i>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>

                    <!-- Profile -->
                    <div class="flex items-center gap-3 pl-4 border-l border-gray-200">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                        <div class="hidden md:block">
                            <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">Administrator</p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <div class="p-6">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if (session('info'))
                <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-xl mb-6">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-info-circle"></i>
                        <span>{{ session('info') }}</span>
                    </div>
                </div>
            @endif

            @if (session('warning'))
                <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-xl mb-6">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>{{ session('warning') }}</span>
                    </div>
                </div>
            @endif
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl p-6 md:p-8 text-white mb-6 reveal">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold mb-2">Selamat Datang, Admin Keagamaan!</h2>
                        <p class="text-blue-100 text-lg">Berikut adalah ringkasan aktivitas pernikahan hari ini</p>
                    </div>
                    <div class="flex flex-col gap-2 text-sm">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-calendar-alt"></i>
                            <span id="currentDate">{{ now()->isoFormat('dddd, D MMMM Y') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-clock"></i>
                            <span id="currentTime">{{ now()->format('H:i') }} WIB</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6 reveal">
                <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-inbox text-xl text-blue-600"></i>
                        </div>
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                            <i class="fas fa-clock mr-1"></i>Pending
                        </span>
                    </div>
                    <h3 class="text-3xl font-extrabold text-gray-800 mb-1">24</h3>
                    <p class="text-sm text-gray-600 font-medium">Request Masuk</p>
                </div>

                <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-check-circle text-xl text-emerald-600"></i>
                        </div>
                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-semibold">
                            <i class="fas fa-arrow-up mr-1"></i>15%
                        </span>
                    </div>
                    <h3 class="text-3xl font-extrabold text-gray-800 mb-1">156</h3>
                    <p class="text-sm text-gray-600 font-medium">Request Disetujui</p>
                </div>

                <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-ring text-xl text-purple-600"></i>
                        </div>
                        <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-semibold">
                            <i class="fas fa-calendar mr-1"></i>Bulan Ini
                        </span>
                    </div>
                    <h3 class="text-3xl font-extrabold text-gray-800 mb-1">38</h3>
                    <p class="text-sm text-gray-600 font-medium">Total Pernikahan Bulan Ini</p>
                </div>

                <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-hourglass-half text-xl text-yellow-600"></i>
                        </div>
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">
                            <i class="fas fa-sync mr-1"></i>Proses
                        </span>
                    </div>
                    <h3 class="text-3xl font-extrabold text-gray-800 mb-1">12</h3>
                    <p class="text-sm text-gray-600 font-medium">Menunggu Verifikasi</p>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Sidebar Toggle
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.querySelector('.main-content');
        const sidebarToggle = document.getElementById('sidebarToggle');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });

        // Reveal Animation
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
    </script>
</body>
</html>
