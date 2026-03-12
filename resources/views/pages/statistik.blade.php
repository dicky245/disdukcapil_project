@extends('layouts.user')

@section('content')
@php
    $stats = [
        'total_penduduk' => 250487,
        'ktp_elektronik' => 238210,
        'kartu_keluarga' => 78456,
        'kia_anak' => 45234
    ];

    $districts = [
        ['name' => 'Kec. Balige', 'penduduk' => 45234, 'kk' => 12456, 'ktp' => 43120, 'percentage' => 95],
        ['name' => 'Kec. Borbor', 'penduduk' => 28456, 'kk' => 7890, 'ktp' => 27340, 'percentage' => 92],
        ['name' => 'Kec. Laguboti', 'penduduk' => 35678, 'kk' => 9234, 'ktp' => 34120, 'percentage' => 94],
    ];
@endphp

<main class="pt-0">
    {{-- Page Loading --}}
    <div id="pageLoading" class="page-loading">
        <div class="loading-logo bg-white rounded-2xl shadow-2xl overflow-hidden flex items-center justify-center">
            <img src="{{ asset('images/logo_toba.jpeg') }}" alt="Logo Kabupaten Toba" class="w-full h-full object-contain p-3">
        </div>
        <div class="loading-spinner"></div>
        <div class="loading-text">Disdukcapil Kabupaten Toba</div>
        <div class="loading-subtext">Memuat statistik...</div>
        <div class="loading-dots">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    {{-- Hero Section --}}
    <section class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-cyan-800 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm text-sm font-medium mb-6">
                    <i class="fas fa-chart-line"></i>
                    Statistik & Data
                </div>
                <h1 class="text-4xl md:text-5xl font-extrabold mb-6">
                    Data Kependudukan Kabupaten Toba
                </h1>
                <p class="text-lg text-blue-100 mb-8">
                    Informasi statistik kependudukan yang transparan dan akuntabel
                </p>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#f9fafb"/>
            </svg>
        </div>
    </section>

    {{-- Quick Stats --}}
    <section class="py-12 bg-gray-50 -mt-8 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 reveal">
                <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-users text-2xl text-blue-600"></i>
                    </div>
                    <p class="text-3xl font-bold text-gray-800 mb-1">{{ number_format($stats['total_penduduk']) }}</p>
                    <p class="text-sm text-gray-600">Total Penduduk</p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-id-card text-2xl text-blue-600"></i>
                    </div>
                    <p class="text-3xl font-bold text-gray-800 mb-1">{{ number_format($stats['ktp_elektronik']) }}</p>
                    <p class="text-sm text-gray-600">KTP Elektronik</p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                    <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-address-card text-2xl text-purple-600"></i>
                    </div>
                    <p class="text-3xl font-bold text-gray-800 mb-1">{{ number_format($stats['kartu_keluarga']) }}</p>
                    <p class="text-sm text-gray-600">Kartu Keluarga</p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                    <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-child text-2xl text-orange-600"></i>
                    </div>
                    <p class="text-3xl font-bold text-gray-800 mb-1">{{ number_format($stats['kia_anak']) }}</p>
                    <p class="text-sm text-gray-600">KIA Anak</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Charts Section --}}
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 reveal">
                <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider">Visualisasi</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2">Grafik Kependudukan</h2>
            </div>

            <div class="grid md:grid-cols-2 gap-8 reveal">
                {{-- Population by Age --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fas fa-chart-pie text-blue-500 mr-2"></i>
                        Distribusi Populasi
                    </h3>
                    <div class="h-80">
                        <canvas id="ageChart"></canvas>
                    </div>
                </div>

                {{-- Population by Gender --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fas fa-venus-mars text-blue-500 mr-2"></i>
                        Jenis Kelamin
                    </h3>
                    <div class="h-80">
                        <canvas id="genderChart"></canvas>
                    </div>
                </div>

                {{-- Documents Issued --}}
                <div class="bg-white rounded-2xl shadow-lg p-6 md:col-span-2">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fas fa-file-alt text-purple-500 mr-2"></i>
                        Dokumen Diterbitkan per Bulan
                    </h3>
                    <div class="h-80">
                        <canvas id="documentsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- District Stats --}}
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 reveal">
                <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider">Per Kecamatan</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2">Data Kecamatan</h2>
            </div>

            <div class="grid md:grid-cols-3 gap-6 reveal">
                @foreach($districts as $district)
                <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl p-6 border border-blue-100">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="font-bold text-gray-800">{{ $district['name'] }}</h4>
                        @if($district['percentage'] >= 95)
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">Tertinggi</span>
                        @endif
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Penduduk</span>
                            <span class="font-semibold">{{ number_format($district['penduduk']) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">KK</span>
                            <span class="font-semibold">{{ number_format($district['kk']) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">KTP</span>
                            <span class="font-semibold">{{ number_format($district['ktp']) }}</span>
                        </div>
                    </div>
                    <div class="mt-4 bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $district['percentage'] }}%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">{{ $district['percentage'] }}% kepemilikan KTP</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
    // Age Chart
    const ageCtx = document.getElementById('ageChart')?.getContext('2d');
    if (ageCtx) {
        new Chart(ageCtx, {
            type: 'doughnut',
            data: {
                labels: ['0-15 Tahun', '16-30 Tahun', '31-45 Tahun', '46-60 Tahun', '60+ Tahun'],
                datasets: [{
                    data: [45230, 78450, 65230, 42100, 19477],
                    backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

    // Gender Chart
    const genderCtx = document.getElementById('genderChart')?.getContext('2d');
    if (genderCtx) {
        new Chart(genderCtx, {
            type: 'doughnut',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    data: [125243, 125244],
                    backgroundColor: ['#3b82f6', '#ec4899'],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

    // Documents Chart
    const docsCtx = document.getElementById('documentsChart')?.getContext('2d');
    if (docsCtx) {
        new Chart(docsCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'KTP',
                    data: [450, 380, 420, 500, 480, 520, 610, 590, 530, 480, 520, 450],
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4
                }, {
                    label: 'KK',
                    data: [280, 250, 290, 320, 310, 350, 380, 360, 340, 300, 320, 280],
                    borderColor: '#8b5cf6',
                    backgroundColor: 'rgba(139, 92, 246, 0.1.',
                    tension: 0.4
                }, {
                    label: 'Akta',
                    data: [150, 180, 160, 200, 190, 220, 250, 240, 210, 180, 200, 160],
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
</script>
@endpush
