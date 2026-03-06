@extends('layouts.admin')

@section('content')
@php
    $page_title = 'Organisasi - Admin';
@endphp

<!-- Page Header -->
<div class="mb-6 reveal">
    <h1 class="text-2xl font-bold text-gray-800">Struktur Organisasi</h1>
    <p class="text-gray-600 mt-1">Struktur organisasi Disdukcapil Kabupaten Toba</p>
</div>

<!-- Organization Chart -->
<div class="bg-white rounded-xl border border-gray-100 p-8 shadow-sm reveal">
    <div class="flex flex-col items-center">
        <!-- Kepala Dinas -->
        <div class="relative">
            <div class="w-48 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl p-6 text-center text-white shadow-lg">
                <div class="w-20 h-20 bg-white/20 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-user-tie text-4xl"></i>
                </div>
                <h3 class="font-bold text-lg mb-1">Dr. Johny Simanjuntak, M.Si</h3>
                <p class="text-blue-100 text-sm">Kepala Dinas</p>
            </div>
            <div class="absolute left-1/2 transform -translate-x-1/2 bottom-0 translate-y-full w-0.5 h-12 bg-blue-600"></div>
        </div>

        <!-- Sekretaris -->
        <div class="relative mt-12">
            <div class="w-48 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-center text-white shadow-lg">
                <div class="w-20 h-20 bg-white/20 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-user text-3xl"></i>
                </div>
                <h3 class="font-bold mb-1">Rina Sari, S.Pd, MM</h3>
                <p class="text-blue-100 text-sm">Sekretaris</p>
            </div>
            <div class="absolute left-1/2 transform -translate-x-1/2 bottom-0 translate-y-full w-0.5 h-12 bg-blue-500"></div>
        </div>

        <!-- Bidang-bidang -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-4 gap-4 w-full max-w-5xl">
            <!-- Bidang 1 -->
            <div class="bg-white border-2 border-blue-200 rounded-xl p-4 text-center shadow-md">
                <div class="w-16 h-16 bg-blue-100 rounded-full mx-auto mb-3 flex items-center justify-center">
                    <i class="fas fa-id-card text-2xl text-blue-600"></i>
                </div>
                <h4 class="font-bold text-gray-800 mb-1">Bidang PIAK</h4>
                <p class="text-xs text-gray-600 mb-2">Pengelolaan Informasi Administrasi Kependudukan</p>
                <p class="text-xs text-blue-600 font-medium">Kabid: Budi Santoso</p>
            </div>

            <!-- Bidang 2 -->
            <div class="bg-white border-2 border-blue-200 rounded-xl p-4 text-center shadow-md">
                <div class="w-16 h-16 bg-emerald-100 rounded-full mx-auto mb-3 flex items-center justify-center">
                    <i class="fas fa-users text-2xl text-emerald-600"></i>
                </div>
                <h4 class="font-bold text-gray-800 mb-1">Bidang Dafduk</h4>
                <p class="text-xs text-gray-600 mb-2">Pendaftaran Penduduk</p>
                <p class="text-xs text-emerald-600 font-medium">Kabid: Siti Aminah</p>
            </div>

            <!-- Bidang 3 -->
            <div class="bg-white border-2 border-blue-200 rounded-xl p-4 text-center shadow-md">
                <div class="w-16 h-16 bg-purple-100 rounded-full mx-auto mb-3 flex items-center justify-center">
                    <i class="fas fa-file-alt text-2xl text-purple-600"></i>
                </div>
                <h4 class="font-bold text-gray-800 mb-1">Bidang Pencatatan</h4>
                <p class="text-xs text-gray-600 mb-2">Pencatatan Sipil</p>
                <p class="text-xs text-purple-600 font-medium">Kabid: Ahmad Rizki</p>
            </div>

            <!-- Bidang 4 -->
            <div class="bg-white border-2 border-blue-200 rounded-xl p-4 text-center shadow-md">
                <div class="w-16 h-16 bg-orange-100 rounded-full mx-auto mb-3 flex items-center justify-center">
                    <i class="fas fa-cogs text-2xl text-orange-600"></i>
                </div>
                <h4 class="font-bold text-gray-800 mb-1">Bidang PSDA</h4>
                <p class="text-xs text-gray-600 mb-2">Pengelolaan Sistem & Dokumen</p>
                <p class="text-xs text-orange-600 font-medium">Kabid: Dewi Sartika</p>
            </div>
        </div>
    </div>
</div>

<!-- Staff List -->
<div class="grid lg:grid-cols-2 gap-6 mt-6">
    <!-- Struktur Organisasi Detail -->
    <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm reveal">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Detail Struktur</h3>
        <div class="space-y-3">
            <div class="p-4 bg-gray-50 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-semibold text-gray-800">Kepala Dinas</p>
                        <p class="text-sm text-gray-600">Eselon II.b</p>
                    </div>
                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">1</span>
                </div>
            </div>

            <div class="p-4 bg-gray-50 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-semibold text-gray-800">Sekretaris</p>
                        <p class="text-sm text-gray-600">Eselon III.a</p>
                    </div>
                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">1</span>
                </div>
            </div>

            <div class="p-4 bg-gray-50 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-semibold text-gray-800">Kepala Bidang</p>
                        <p class="text-sm text-gray-600">Eselon III.a</p>
                    </div>
                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-medium">4</span>
                </div>
            </div>

            <div class="p-4 bg-gray-50 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-semibold text-gray-800">Kepala Sub Bagian</p>
                        <p class="text-sm text-gray-600">Eselon IV.a</p>
                    </div>
                    <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-medium">3</span>
                </div>
            </div>

            <div class="p-4 bg-gray-50 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-semibold text-gray-800">Kasubbag TU</p>
                        <p class="text-sm text-gray-600">Eselon IV.a</p>
                    </div>
                    <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-medium">1</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Staff -->
    <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm reveal">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Statistik Pegawai</h3>
        <div class="grid grid-cols-2 gap-4">
            <div class="text-center p-4 bg-blue-50 rounded-xl">
                <p class="text-3xl font-bold text-blue-600">45</p>
                <p class="text-sm text-gray-600">Total Pegawai</p>
            </div>
            <div class="text-center p-4 bg-emerald-50 rounded-xl">
                <p class="text-3xl font-bold text-emerald-600">28</p>
                <p class="text-sm text-gray-600">Pegawai PNS</p>
            </div>
            <div class="text-center p-4 bg-purple-50 rounded-xl">
                <p class="text-3xl font-bold text-purple-600">12</p>
                <p class="text-sm text-gray-600">Pegawai PPPK</p>
            </div>
            <div class="text-center p-4 bg-orange-50 rounded-xl">
                <p class="text-3xl font-bold text-orange-600">5</p>
                <p class="text-sm text-gray-600">Pegawai Honorer</p>
            </div>
        </div>

        <div class="mt-6">
            <h4 class="font-semibold text-gray-800 mb-3">Distribusi per Bidang</h4>
            <div class="space-y-3">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600">Bidang PIAK</span>
                    <div class="flex items-center gap-2">
                        <div class="w-24 h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-600 rounded-full" style="width: 75%"></div>
                        </div>
                        <span class="font-medium text-gray-800">12</span>
                    </div>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600">Bidang Dafduk</span>
                    <div class="flex items-center gap-2">
                        <div class="w-24 h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-600 rounded-full" style="width: 60%"></div>
                        </div>
                        <span class="font-medium text-gray-800">10</span>
                    </div>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600">Bidang Pencatatan</span>
                    <div class="flex items-center gap-2">
                        <div class="w-24 h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-purple-600 rounded-full" style="width: 55%"></div>
                        </div>
                        <span class="font-medium text-gray-800">9</span>
                    </div>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600">Bidang PSDA</span>
                    <div class="flex items-center gap-2">
                        <div class="w-24 h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-orange-600 rounded-full" style="width: 50%"></div>
                        </div>
                        <span class="font-medium text-gray-800">8</span>
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
