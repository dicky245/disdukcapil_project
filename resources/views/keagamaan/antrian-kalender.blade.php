@extends('layouts.keagamaan')

@section('content')
@php
    $page_title = 'Antrian & Kalender - Keagamaan';
@endphp

<!-- Page Header -->
<div class="mb-6 reveal">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Antrian & Kalender</h1>
            <p class="text-gray-600 mt-1">Kelola jadwal dan antrian layanan keagamaan</p>
        </div>
        <div class="flex gap-3">
            <button class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-50 transition flex items-center gap-2">
                <i class="fas fa-filter"></i>
                <span>Filter</span>
            </button>
            <button class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span>Tambah Jadwal</span>
            </button>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6 reveal">
    <div class="stat-card bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-calendar-day text-xl text-blue-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-800">12</p>
                <p class="text-sm text-gray-600">Jadwal Hari Ini</p>
            </div>
        </div>
    </div>

    <div class="stat-card bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-clock text-xl text-emerald-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-800">5</p>
                <p class="text-sm text-gray-600">Menunggu</p>
            </div>
        </div>
    </div>

    <div class="stat-card bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-spinner text-xl text-purple-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-800">7</p>
                <p class="text-sm text-gray-600">Sedang Diproses</p>
            </div>
        </div>
    </div>

    <div class="stat-card bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-teal-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-calendar-week text-xl text-teal-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-800">48</p>
                <p class="text-sm text-gray-600">Total Bulan Ini</p>
            </div>
        </div>
    </div>
</div>

<!-- Calendar & Queue Grid -->
<div class="grid lg:grid-cols-3 gap-6 mb-6">
    <!-- Calendar -->
    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 p-6 shadow-sm reveal">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-800">Kalender Jadwal</h3>
            <div class="flex gap-2">
                <button class="p-2 hover:bg-gray-100 rounded-lg transition">
                    <i class="fas fa-chevron-left text-gray-600"></i>
                </button>
                <span class="px-4 py-2 bg-gray-50 rounded-lg font-medium text-gray-700">Maret 2026</span>
                <button class="p-2 hover:bg-gray-100 rounded-lg transition">
                    <i class="fas fa-chevron-right text-gray-600"></i>
                </button>
            </div>
        </div>

        <!-- Calendar Grid -->
        <div class="grid grid-cols-7 gap-2 mb-4">
            <div class="text-center text-sm font-semibold text-gray-500 py-2">Min</div>
            <div class="text-center text-sm font-semibold text-gray-500 py-2">Sen</div>
            <div class="text-center text-sm font-semibold text-gray-500 py-2">Sel</div>
            <div class="text-center text-sm font-semibold text-gray-500 py-2">Rab</div>
            <div class="text-center text-sm font-semibold text-gray-500 py-2">Kam</div>
            <div class="text-center text-sm font-semibold text-gray-500 py-2">Jum</div>
            <div class="text-center text-sm font-semibold text-gray-500 py-2">Sab</div>
        </div>
        <div class="grid grid-cols-7 gap-2">
            @for($i = 0; $i < 31; $i++)
            <div class="aspect-square flex flex-col items-center justify-center rounded-lg cursor-pointer transition
                {{ $i < 6 ? 'bg-gray-50 text-gray-400' : 'hover:bg-teal-50 hover:text-teal-700' }}
                {{ $i == 5 ? 'bg-teal-600 text-white hover:bg-teal-700' : '' }}
                {{ $i == 12 || $i == 19 || $i == 26 ? 'bg-teal-100 text-teal-700' : '' }}">
                <span class="text-sm font-medium">{{ $i + 1 }}</span>
                @if(in_array($i, [5, 12, 19, 26]))
                <span class="text-xs mt-1">{{ $i == 5 ? '12' : '5' }}</span>
                @endif
            </div>
            @endfor
        </div>
    </div>

    <!-- Today's Schedule -->
    <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm reveal">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Jadwal Hari Ini</h3>
        <div class="space-y-3">
            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-semibold text-blue-700">08:00 - 09:00</span>
                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">Proses</span>
                </div>
                <p class="text-sm text-gray-800 font-medium">Akad Nikah - Budi & Siti</p>
                <p class="text-xs text-gray-600 mt-1">KUA Balige</p>
            </div>

            <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-lg">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-semibold text-emerald-700">10:00 - 11:00</span>
                    <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-medium">Selesai</span>
                </div>
                <p class="text-sm text-gray-800 font-medium">Pencatatan Nikah - Ahmad & Rina</p>
                <p class="text-xs text-gray-600 mt-1">KUA Balige</p>
            </div>

            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-semibold text-yellow-700">13:00 - 14:00</span>
                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">Menunggu</span>
                </div>
                <p class="text-sm text-gray-800 font-medium">Akta Nikah - Joko & Maria</p>
                <p class="text-xs text-gray-600 mt-1">KUA Balige</p>
            </div>

            <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-semibold text-gray-700">15:00 - 16:00</span>
                    <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium">Terjadwal</span>
                </div>
                <p class="text-sm text-gray-800 font-medium">Pernikahan - Dedi & Lestari</p>
                <p class="text-xs text-gray-600 mt-1">KUA Balige</p>
            </div>
        </div>
    </div>
</div>

<!-- Queue List -->
<div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm reveal">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-bold text-gray-800">Antrian Aktif</h3>
        <div class="flex gap-2">
            <input type="text" placeholder="Cari antrian..." class="px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">No. Antrian</th>
                    <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Pasangan</th>
                    <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Layanan</th>
                    <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Waktu</th>
                    <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <tr class="hover:bg-gray-50">
                    <td class="py-4 px-4">
                        <span class="font-bold text-teal-600">A001</span>
                    </td>
                    <td class="py-4 px-4 text-sm text-gray-800">Budi Santoso & Sati Aminah</td>
                    <td class="py-4 px-4 text-sm text-gray-600">Akad Nikah</td>
                    <td class="py-4 px-4 text-sm text-gray-600">08:00 - 09:00</td>
                    <td class="py-4 px-4">
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">Proses</span>
                    </td>
                    <td class="py-4 px-4">
                        <div class="flex gap-2">
                            <button class="p-2 hover:bg-teal-50 rounded-lg transition" title="Detail">
                                <i class="fas fa-eye text-teal-600"></i>
                            </button>
                            <button class="p-2 hover:bg-blue-50 rounded-lg transition" title="Proses">
                                <i class="fas fa-check text-blue-600"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="py-4 px-4">
                        <span class="font-bold text-teal-600">A002</span>
                    </td>
                    <td class="py-4 px-4 text-sm text-gray-800">Joko Widodo & Maria Susanti</td>
                    <td class="py-4 px-4 text-sm text-gray-600">Akta Nikah</td>
                    <td class="py-4 px-4 text-sm text-gray-600">13:00 - 14:00</td>
                    <td class="py-4 px-4">
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">Menunggu</span>
                    </td>
                    <td class="py-4 px-4">
                        <div class="flex gap-2">
                            <button class="p-2 hover:bg-teal-50 rounded-lg transition" title="Detail">
                                <i class="fas fa-eye text-teal-600"></i>
                            </button>
                            <button class="p-2 hover:bg-blue-50 rounded-lg transition" title="Proses">
                                <i class="fas fa-play text-blue-600"></i>
                            </button>
                        </div>
                    </td>
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
