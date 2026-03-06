@extends('layouts.admin')

@section('content')
@php
    $page_title = 'Penghargaan - Admin';
@endphp

<!-- Page Header -->
<div class="mb-6 reveal">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Penghargaan</h1>
            <p class="text-gray-600 mt-1">Daftar penghargaan yang telah diraih Disdukcapil Kabupaten Toba</p>
        </div>
        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
            <i class="fas fa-plus"></i>
            <span>Tambah Penghargaan</span>
        </button>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 reveal">
    <div class="stat-card bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-trophy text-xl text-yellow-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-800">24</p>
                <p class="text-sm text-gray-600">Total Penghargaan</p>
            </div>
        </div>
    </div>

    <div class="stat-card bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-star text-xl text-emerald-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-800">8</p>
                <p class="text-sm text-gray-600">Tingkat Nasional</p>
            </div>
        </div>
    </div>

    <div class="stat-card bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-medal text-xl text-blue-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-800">16</p>
                <p class="text-sm text-gray-600">Tingkat Provinsi</p>
            </div>
        </div>
    </div>
</div>

<!-- Awards List -->
<div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm reveal">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-bold text-gray-800">Daftar Penghargaan</h3>
        <div class="flex gap-2">
            <select class="px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option>Semua Tingkat</option>
                <option>Nasional</option>
                <option>Provinsi</option>
                <option>Kabupaten</option>
            </select>
            <select class="px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option>Terbaru</option>
                <option>Terlama</option>
            </select>
        </div>
    </div>

    <div class="space-y-4">
        <!-- Award Item 1 -->
        <div class="border border-gray-200 rounded-xl p-6 hover:shadow-md transition">
            <div class="flex items-start gap-6">
                <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-trophy text-2xl text-white"></i>
                </div>
                <div class="flex-1">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <h4 class="text-lg font-bold text-gray-800">Penghargaan Kualitas Pelayanan Publik</h4>
                            <p class="text-sm text-gray-600">Kementerian Pendayagunaan Aparatur Negara dan Reformasi Birokrasi</p>
                        </div>
                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">Nasional</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-3">Penghargaan atas keberhasilan dalam meningkatkan kualitas pelayanan publik di bidang administrasi kependudukan.</p>
                    <div class="flex items-center gap-4 text-sm text-gray-500">
                        <span><i class="fas fa-calendar mr-1"></i> 2024</span>
                        <span><i class="fas fa-map-marker-alt mr-1"></i> Jakarta</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Award Item 2 -->
        <div class="border border-gray-200 rounded-xl p-6 hover:shadow-md transition">
            <div class="flex items-start gap-6">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-medal text-2xl text-white"></i>
                </div>
                <div class="flex-1">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <h4 class="text-lg font-bold text-gray-800">Terbaik Implementasi Sistem Informasi Administrasi Kependudukan (SIAK)</h4>
                            <p class="text-sm text-gray-600">Dinas Kependudukan dan Pencatatan Sipil Provinsi Sumatera Utara</p>
                        </div>
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">Provinsi</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-3">Penghargaan sebagai implementator terbaik SIAK di tingkat provinsi Sumatera Utara.</p>
                    <div class="flex items-center gap-4 text-sm text-gray-500">
                        <span><i class="fas fa-calendar mr-1"></i> 2023</span>
                        <span><i class="fas fa-map-marker-alt mr-1"></i> Medan</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Award Item 3 -->
        <div class="border border-gray-200 rounded-xl p-6 hover:shadow-md transition">
            <div class="flex items-start gap-6">
                <div class="w-16 h-16 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-star text-2xl text-white"></i>
                </div>
                <div class="flex-1">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <h4 class="text-lg font-bold text-gray-800">Penghargaan Pembangunan Daerah</h4>
                            <p class="text-sm text-gray-600">Pemerintah Provinsi Sumatera Utara</p>
                        </div>
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">Provinsi</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-3">Penghargaan atas kontribusi dalam pembangunan daerah melalui pelayanan administrasi kependudukan.</p>
                    <div class="flex items-center gap-4 text-sm text-gray-500">
                        <span><i class="fas fa-calendar mr-1"></i> 2023</span>
                        <span><i class="fas fa-map-marker-alt mr-1"></i> Medan</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Award Item 4 -->
        <div class="border border-gray-200 rounded-xl p-6 hover:shadow-md transition">
            <div class="flex items-start gap-6">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-award text-2xl text-white"></i>
                </div>
                <div class="flex-1">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <h4 class="text-lg font-bold text-gray-800">Inovasi Pelayanan Terpadu</h4>
                            <p class="text-sm text-gray-600">Pemerintah Kabupaten Toba</p>
                        </div>
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Kabupaten</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-3">Penghargaan atas inovasi dalam pelayanan terpadu administrasi kependudukan.</p>
                    <div class="flex items-center gap-4 text-sm text-gray-500">
                        <span><i class="fas fa-calendar mr-1"></i> 2022</span>
                        <span><i class="fas fa-map-marker-alt mr-1"></i> Balige</span>
                    </div>
                </div>
            </div>
        </div>
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
