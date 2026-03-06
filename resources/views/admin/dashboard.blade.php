@extends('layouts.admin')

@section('content')
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

            <a href="{{ route('admin.konfirmasi-status') }}" class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:border-blue-500 hover:bg-blue-50 transition group">
                <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center group-hover:bg-teal-500 transition">
                    <i class="fas fa-clipboard-check text-teal-600 group-hover:text-white transition"></i>
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-gray-800 text-sm">Konfirmasi Status</p>
                    <p class="text-xs text-gray-500">Verifikasi pengajuan</p>
                </div>
                <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-600 transition"></i>
            </a>

            <a href="{{ route('admin.visualisasi-data') }}" class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:border-blue-500 hover:bg-blue-50 transition group">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-500 transition">
                    <i class="fas fa-file-export text-purple-600 group-hover:text-white transition"></i>
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-gray-800 text-sm">Export Laporan</p>
                    <p class="text-xs text-gray-500">Unduh data statistik</p>
                </div>
                <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-600 transition"></i>
            </a>

            <a href="{{ route('admin.manajemen-akun') }}" class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:border-blue-500 hover:bg-blue-50 transition group">
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

<script>
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
@endsection
