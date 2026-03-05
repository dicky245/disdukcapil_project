<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Disdukcapil Kabupaten Toba</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
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
                        teal: {
                            500: '#00B8D9',
                            600: '#0097b8',
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

        /* Sidebar */
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
            background: rgba(59, 130, 246, 0.1);
            color: #0052CC;
        }

        .sidebar-link.active {
            border-left: 3px solid #0052CC;
        }

        /* Dropdown */
        .dropdown-menu {
            display: none;
            padding-left: 2rem;
        }

        .dropdown-menu.active {
            display: block;
        }

        .dropdown-toggle {
            justify-content: space-between;
        }

        .dropdown-toggle .fa-chevron-down {
            transition: transform 0.3s ease;
        }

        .dropdown-toggle.active .fa-chevron-down {
            transform: rotate(180deg);
        }

        /* Main Content */
        .main-content {
            transition: all 0.3s ease;
        }

        .main-content.expanded {
            margin-left: 80px;
        }

        /* Card Hover Effect */
        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 82, 204, 0.15);
        }

        /* Reveal Animation */
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
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link active flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700">
                <i class="fas fa-home w-5"></i>
                <span class="sidebar-text font-medium">Dashboard</span>
            </a>

            <div class="pt-4 pb-2">
                <p class="sidebar-text px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Manajemen</p>
            </div>

            <a href="berita.html" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700">
                <i class="fas fa-newspaper w-5"></i>
                <span class="sidebar-text font-medium">Kelola Berita</span>
            </a>
            <a href="organisasi.html" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700">
                <i class="fas fa-sitemap w-5"></i>
                <span class="sidebar-text font-medium">Organisasi</span>
            </a>
            <a href="penghargaan.html" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700">
                <i class="fas fa-trophy w-5"></i>
                <span class="sidebar-text font-medium">Penghargaan</span>
            </a>
            <a href="dasar-hukum.html" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700">
                <i class="fas fa-balance-scale w-5"></i>
                <span class="sidebar-text font-medium">Dasar Hukum</span>
            </a>
            <a href="statistik.html" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700">
                <i class="fas fa-chart-bar w-5"></i>
                <span class="sidebar-text font-medium">Statistik</span>
            </a>

            <div class="pt-4 pb-2">
                <p class="sidebar-text px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Layanan</p>
            </div>

            <a href="antrian-online.html" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700">
                <i class="fas fa-ticket-alt w-5"></i>
                <span class="sidebar-text font-medium">Antrian Online</span>
            </a>
            <a href="konfirmasi-status.html" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700">
                <i class="fas fa-clipboard-list w-5"></i>
                <span class="sidebar-text font-medium">Konfirmasi Status</span>
            </a>

            <!-- Kelola Layanan Dropdown -->
            <div class="layanan-dropdown">
                <a href="#" class="sidebar-link dropdown-toggle flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700" onclick="toggleDropdown(event)">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-file-alt w-5"></i>
                        <span class="sidebar-text font-medium">Kelola Layanan</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs"></i>
                </a>
                <div class="dropdown-menu">
                    <a href="penerbitan-kk.html" class="sidebar-link flex items-center gap-3 px-4 py-2 rounded-lg text-gray-700 text-sm">
                        <i class="fas fa-address-card w-4"></i>
                        <span class="sidebar-text">Kartu Keluarga</span>
                    </a>
                    <a href="penerbitan-akte-lahir.html" class="sidebar-link flex items-center gap-3 px-4 py-2 rounded-lg text-gray-700 text-sm">
                        <i class="fas fa-baby w-4"></i>
                        <span class="sidebar-text">Akta Kelahiran</span>
                    </a>
                    <a href="penerbitan-akte-kematian.html" class="sidebar-link flex items-center gap-3 px-4 py-2 rounded-lg text-gray-700 text-sm">
                        <i class="fas fa-user-times w-4"></i>
                        <span class="sidebar-text">Akta Kematian</span>
                    </a>
                    <a href="penerbitan-lahir-mati.html" class="sidebar-link flex items-center gap-3 px-4 py-2 rounded-lg text-gray-700 text-sm">
                        <i class="fas fa-exchange-alt w-4"></i>
                        <span class="sidebar-text">Lahir Mati</span>
                    </a>
                    <a href="penerbitan-pernikahan.html" class="sidebar-link flex items-center gap-3 px-4 py-2 rounded-lg text-gray-700 text-sm">
                        <i class="fas fa-ring w-4"></i>
                        <span class="sidebar-text">Akta Pernikahan</span>
                    </a>
                </div>
            </div>

            <div class="pt-4 pb-2">
                <p class="sidebar-text px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Akun</p>
            </div>

            <a href="manajemen-akun.html" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700">
                <i class="fas fa-users-cog w-5"></i>
                <span class="sidebar-text font-medium">Manajemen Akun</span>
            </a>
            <a href="kelola-akun-keagamaan.html" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700">
                <i class="fas fa-pray w-5"></i>
                <span class="sidebar-text font-medium">Akun Keagamaan</span>
            </a>
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
                        <h1 class="text-xl font-bold text-gray-800">Dashboard</h1>
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
                        <h2 class="text-2xl md:text-3xl font-bold mb-2">Selamat Datang, Admin!</h2>
                        <p class="text-blue-100 text-lg">Berikut adalah ringkasan aktivitas hari ini</p>
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
                <div class="stat-card bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-users text-xl text-blue-600"></i>
                        </div>
                        <span class="text-xs font-medium text-green-600 bg-green-50 px-2 py-1 rounded-full">
                            <i class="fas fa-arrow-up mr-1"></i>12%
                        </span>
                    </div>
                    <h3 class="text-3xl font-extrabold text-gray-800 mb-1">250,487</h3>
                    <p class="text-sm text-gray-600 font-medium">Total Penduduk</p>
                </div>

                <div class="stat-card bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-teal-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-id-card text-xl text-teal-600"></i>
                        </div>
                        <span class="text-xs font-medium text-green-600 bg-green-50 px-2 py-1 rounded-full">
                            <i class="fas fa-arrow-up mr-1"></i>8%
                        </span>
                    </div>
                    <h3 class="text-3xl font-extrabold text-gray-800 mb-1">238,210</h3>
                    <p class="text-sm text-gray-600 font-medium">KTP Elektronik</p>
                </div>

                <div class="stat-card bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-ticket-alt text-xl text-purple-600"></i>
                        </div>
                        <span class="text-xs font-medium text-yellow-600 bg-yellow-50 px-2 py-1 rounded-full">
                            <i class="fas fa-clock mr-1"></i>Proses
                        </span>
                    </div>
                    <h3 class="text-3xl font-extrabold text-gray-800 mb-1">127</h3>
                    <p class="text-sm text-gray-600 font-medium">Antrian Hari Ini</p>
                </div>

                <div class="stat-card bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-check-circle text-xl text-green-600"></i>
                        </div>
                        <span class="text-xs font-medium text-green-600 bg-green-50 px-2 py-1 rounded-full">
                            <i class="fas fa-arrow-up mr-1"></i>95%
                        </span>
                    </div>
                    <h3 class="text-3xl font-extrabold text-gray-800 mb-1">4.8</h3>
                    <p class="text-sm text-gray-600 font-medium">Kepuasan Masyarakat</p>
                </div>
            </div>

            <!-- Main Grid -->
            <div class="grid lg:grid-cols-3 gap-6 mb-6">
                <!-- Chart -->
                <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 p-6 shadow-sm reveal">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-800">Statistik Layanan Bulanan</h3>
                        <select class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>2025</option>
                            <option>2024</option>
                            <option>2023</option>
                        </select>
                    </div>
                    <div class="h-80">
                        <canvas id="servicesChart"></canvas>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm reveal">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <a href="#" class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:border-blue-500 hover:bg-blue-50 transition group">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-500 transition">
                                <i class="fas fa-plus text-blue-600 group-hover:text-white transition"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800 text-sm">Tambah Berita</p>
                                <p class="text-xs text-gray-500">Buat berita baru</p>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-600 transition"></i>
                        </a>

                        <a href="#" class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:border-blue-500 hover:bg-blue-50 transition group">
                            <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center group-hover:bg-teal-500 transition">
                                <i class="fas fa-clipboard-check text-teal-600 group-hover:text-white transition"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800 text-sm">Konfirmasi Status</p>
                                <p class="text-xs text-gray-500">Verifikasi pengajuan</p>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-600 transition"></i>
                        </a>

                        <a href="#" class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:border-blue-500 hover:bg-blue-50 transition group">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-500 transition">
                                <i class="fas fa-file-export text-purple-600 group-hover:text-white transition"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800 text-sm">Export Laporan</p>
                                <p class="text-xs text-gray-500">Unduh data statistik</p>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-600 transition"></i>
                        </a>

                        <a href="#" class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:border-blue-500 hover:bg-blue-50 transition group">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center group-hover:bg-orange-500 transition">
                                <i class="fas fa-cog text-orange-600 group-hover:text-white transition"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800 text-sm">Pengaturan</p>
                                <p class="text-xs text-gray-500">Konfigurasi sistem</p>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-600 transition"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm reveal">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Aktivitas Terbaru</h3>
                    <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-700">Lihat Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aktivitas</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">User</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Waktu</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-id-card text-sm text-blue-600"></i>
                                        </div>
                                        <span class="font-medium text-gray-800 text-sm">Pengajuan KTP Baru</span>
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-sm text-gray-600">Budi Santoso</td>
                                <td class="py-3 px-4 text-sm text-gray-600">5 menit lalu</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">Menunggu</span>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-check text-sm text-green-600"></i>
                                        </div>
                                        <span class="font-medium text-gray-800 text-sm">KK Selesai Diproses</span>
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-sm text-gray-600">Siti Aminah</td>
                                <td class="py-3 px-4 text-sm text-gray-600">15 menit lalu</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Selesai</span>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-newspaper text-sm text-purple-600"></i>
                                        </div>
                                        <span class="font-medium text-gray-800 text-sm">Berita Baru Ditambahkan</span>
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-sm text-gray-600">Admin</td>
                                <td class="py-3 px-4 text-sm text-gray-600">1 jam lalu</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">Published</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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

        // Dropdown Toggle
        function toggleDropdown(event) {
            event.preventDefault();
            const dropdown = event.currentTarget.closest('.layanan-dropdown');
            const menu = dropdown.querySelector('.dropdown-menu');
            const toggle = dropdown.querySelector('.dropdown-toggle');

            menu.classList.toggle('active');
            toggle.classList.toggle('active');
        }

        // Chart.js
        Chart.defaults.font.family = 'Plus Jakarta Sans';
        Chart.defaults.color = '#6b7280';

        new Chart(document.getElementById('servicesChart'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                datasets: [
                    {
                        label: 'KTP',
                        data: [1234, 1456, 1678, 1523, 1689, 1734],
                        borderColor: '#0052CC',
                        backgroundColor: 'rgba(0, 82, 204, 0.1)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'KK',
                        data: [456, 523, 598, 512, 567, 589],
                        borderColor: '#00B8D9',
                        backgroundColor: 'rgba(0, 184, 217, 0.1)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Akta',
                        data: [789, 867, 945, 823, 901, 934],
                        borderColor: '#6554C0',
                        backgroundColor: 'rgba(101, 84, 192, 0.1)',
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: { padding: 20 }
                    }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
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
