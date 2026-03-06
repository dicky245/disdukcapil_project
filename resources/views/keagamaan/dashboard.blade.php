@extends('layouts.keagamaan')

@section('content')
@php
    $stats = [
        'pending' => 24,
        'approved' => 156,
        'this_month' => 38,
        'processing' => 12
    ];
@endphp

<!-- Welcome Banner -->
<div class="bg-gradient-to-r from-teal-600 to-teal-700 rounded-2xl p-6 md:p-8 text-white mb-6 reveal">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div>
            <h2 class="text-2xl md:text-3xl font-bold mb-2">Selamat Datang, Petugas Keagamaan!</h2>
            <p class="text-teal-100 text-lg">Berikut adalah ringkasan aktivitas pernikahan hari ini</p>
        </div>
        <div class="flex flex-col gap-2 text-sm">
            <div class="flex items-center gap-2">
                <i class="fas fa-calendar-alt"></i>
                <span>{{ now()->isoFormat('dddd, D MMMM Y') }}</span>
            </div>
            <div class="flex items-center gap-2">
                <i class="fas fa-clock"></i>
                <span>{{ now()->format('H:i') }} WIB</span>
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
        <h3 class="text-3xl font-extrabold text-gray-800 mb-1">{{ $stats['pending'] }}</h3>
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
        <h3 class="text-3xl font-extrabold text-gray-800 mb-1">{{ $stats['approved'] }}</h3>
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
        <h3 class="text-3xl font-extrabold text-gray-800 mb-1">{{ $stats['this_month'] }}</h3>
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
        <h3 class="text-3xl font-extrabold text-gray-800 mb-1">{{ $stats['processing'] }}</h3>
        <p class="text-sm text-gray-600 font-medium">Menunggu Verifikasi</p>
    </div>
</div>

<!-- Recent Activity -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 reveal">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-bold text-gray-800">Aktivitas Terbaru</h3>
        <a href="{{ route('keagamaan.antrian_kalender') }}" class="text-teal-600 hover:text-teal-700 text-sm font-medium">
            Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="pb-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="pb-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Layanan</th>
                    <th class="pb-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="pb-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b border-gray-100">
                    <td class="py-4 text-sm text-gray-800">Budi Santoso</td>
                    <td class="py-4 text-sm text-gray-600">Pernikahan</td>
                    <td class="py-4">
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">Pending</span>
                    </td>
                    <td class="py-4 text-sm text-gray-600">06 Mar 2026</td>
                </tr>
                <tr class="border-b border-gray-100">
                    <td class="py-4 text-sm text-gray-800">Siti Aminah</td>
                    <td class="py-4 text-sm text-gray-600">Pencatatan Nikah</td>
                    <td class="py-4">
                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-semibold">Selesai</span>
                    </td>
                    <td class="py-4 text-sm text-gray-600">05 Mar 2026</td>
                </tr>
                <tr>
                    <td class="py-4 text-sm text-gray-800">Ahmad Rizki</td>
                    <td class="py-4 text-sm text-gray-600">Akta Nikah</td>
                    <td class="py-4">
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">Proses</span>
                    </td>
                    <td class="py-4 text-sm text-gray-600">05 Mar 2026</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
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
