@extends('layouts.keagamaan')

@section('content')
@php
    $page_title = 'Sinkronisasi Dukcapil - Keagamaan';
@endphp

<!-- Page Header -->
<div class="mb-6 reveal">
    <h1 class="text-2xl font-bold text-gray-800">Sinkronisasi Dukcapil</h1>
    <p class="text-gray-600 mt-1">Sinkronkan data keagamaan dengan data kependudukan</p>
</div>

<!-- Sync Status Card -->
<div class="bg-gradient-to-r from-teal-600 to-teal-700 rounded-2xl p-6 text-white mb-6 reveal">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h2 class="text-xl font-bold mb-2">Status Sinkronisasi</h2>
            <p class="text-teal-100">Terakhir disinkronkan: <strong>5 Maret 2026, 14:30 WIB</strong></p>
        </div>
        <div class="flex gap-3">
            <button class="px-6 py-3 bg-white/20 backdrop-blur-sm rounded-xl hover:bg-white/30 transition flex items-center gap-2">
                <i class="fas fa-history"></i>
                <span>Riwayat</span>
            </button>
            <button onclick="syncData()" class="px-6 py-3 bg-white text-teal-700 rounded-xl hover:bg-gray-100 transition flex items-center gap-2 font-semibold">
                <i class="fas fa-sync"></i>
                <span>Sinkronkan Sekarang</span>
            </button>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6 reveal">
    <div class="stat-card bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-users text-xl text-blue-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-800">1,234</p>
                <p class="text-sm text-gray-600">Total Data</p>
            </div>
        </div>
    </div>

    <div class="stat-card bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-check-circle text-xl text-emerald-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-800">1,180</p>
                <p class="text-sm text-gray-600">Tersinkronisasi</p>
            </div>
        </div>
    </div>

    <div class="stat-card bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-clock text-xl text-yellow-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-800">42</p>
                <p class="text-sm text-gray-600">Pending</p>
            </div>
        </div>
    </div>

    <div class="stat-card bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-xl text-red-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-800">12</p>
                <p class="text-sm text-gray-600">Gagal</p>
            </div>
        </div>
    </div>
</div>

<!-- Sync Information -->
<div class="grid lg:grid-cols-2 gap-6 mb-6">
    <!-- Sync Progress -->
    <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm reveal">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Progres Sinkronisasi</h3>
        <div class="space-y-4">
            <div>
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-gray-600">Data Pernikahan</span>
                    <span class="font-semibold text-gray-800">456/500</span>
                </div>
                <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-teal-500 to-teal-600 rounded-full" style="width: 91%"></div>
                </div>
            </div>

            <div>
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-gray-600">Data Perceraian</span>
                    <span class="font-semibold text-gray-800">78/85</span>
                </div>
                <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-blue-500 to-blue-600 rounded-full" style="width: 92%"></div>
                </div>
            </div>

            <div>
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-gray-600">Data Akta Nikah</span>
                    <span class="font-semibold text-gray-800">646/650</span>
                </div>
                <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-purple-500 to-purple-600 rounded-full" style="width: 99%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sync Settings -->
    <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm reveal">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Pengaturan Sinkronisasi</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div>
                    <p class="font-medium text-gray-800">Auto Sync</p>
                    <p class="text-sm text-gray-600">Sinkronisasi otomatis setiap 1 jam</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-teal-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-teal-600"></div>
                </label>
            </div>

            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div>
                    <p class="font-medium text-gray-800">Notifikasi</p>
                    <p class="text-sm text-gray-600">Kirim notifikasi saat sinkronisasi selesai</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-teal-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-teal-600"></div>
                </label>
            </div>

            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="font-medium text-gray-800 mb-2">Interval Sinkronisasi</p>
                <select class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option>Setiap 30 menit</option>
                    <option selected>Setiap 1 jam</option>
                    <option>Setiap 2 jam</option>
                    <option>Setiap 6 jam</option>
                    <option>Manual saja</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Failed Syncs -->
<div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm reveal">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-bold text-gray-800">Data Gagal Sinkronisasi</h3>
        <button class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition text-sm flex items-center gap-2">
            <i class="fas fa-redo"></i>
            <span>Coba Lagi Semua</span>
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jenis</th>
                    <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Error</th>
                    <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Waktu</th>
                    <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <tr class="hover:bg-gray-50">
                    <td class="py-4 px-4 text-sm text-gray-800 font-medium">KAG-001234</td>
                    <td class="py-4 px-4 text-sm text-gray-800">Budi Santoso</td>
                    <td class="py-4 px-4 text-sm text-gray-600">Pernikahan</td>
                    <td class="py-4 px-4 text-sm text-red-600">NIK tidak ditemukan di database dukcapil</td>
                    <td class="py-4 px-4 text-sm text-gray-600">5 Mar 2026, 14:25</td>
                    <td class="py-4 px-4">
                        <div class="flex gap-2">
                            <button class="px-3 py-1 bg-teal-100 text-teal-700 rounded-lg text-xs font-medium hover:bg-teal-200 transition">
                                <i class="fas fa-redo mr-1"></i> Retry
                            </button>
                            <button class="px-3 py-1 bg-gray-100 text-gray-700 rounded-lg text-xs font-medium hover:bg-gray-200 transition">
                                <i class="fas fa-eye mr-1"></i> Detail
                            </button>
                        </div>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="py-4 px-4 text-sm text-gray-800 font-medium">KAG-001235</td>
                    <td class="py-4 px-4 text-sm text-gray-800">Siti Aminah</td>
                    <td class="py-4 px-4 text-sm text-gray-600">Akta Nikah</td>
                    <td class="py-4 px-4 text-sm text-red-600">Data penduduk tidak valid</td>
                    <td class="py-4 px-4 text-sm text-gray-600">5 Mar 2026, 14:20</td>
                    <td class="py-4 px-4">
                        <div class="flex gap-2">
                            <button class="px-3 py-1 bg-teal-100 text-teal-700 rounded-lg text-xs font-medium hover:bg-teal-200 transition">
                                <i class="fas fa-redo mr-1"></i> Retry
                            </button>
                            <button class="px-3 py-1 bg-gray-100 text-gray-700 rounded-lg text-xs font-medium hover:bg-gray-200 transition">
                                <i class="fas fa-eye mr-1"></i> Detail
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    function syncData() {
        Swal.fire({
            title: 'Memulai Sinkronisasi',
            text: 'Mohon tunggu, sedang menyinkronkan data...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Simulate sync process
        setTimeout(() => {
            Swal.fire({
                icon: 'success',
                title: 'Sinkronisasi Berhasil',
                text: '45 data baru berhasil disinkronkan',
                confirmButtonColor: '#0d9488'
            });
        }, 2000);
    }

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
