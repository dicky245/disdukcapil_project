@extends('layouts.keagamaan')

@section('content')
@php
    $page_title = 'Lacak Berkas - Keagamaan';
@endphp

<!-- Page Header -->
<div class="mb-6 reveal">
    <h1 class="text-2xl font-bold text-gray-800">Lacak Berkas</h1>
    <p class="text-gray-600 mt-1">Pantau status dan lokasi berkas keagamaan</p>
</div>

<!-- Search Section -->
<div class="bg-gradient-to-r from-teal-600 to-teal-700 rounded-2xl p-6 text-white mb-6 reveal">
    <div class="flex flex-col md:flex-row gap-4 items-center">
        <div class="flex-1 w-full">
            <div class="relative">
                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" id="searchInput" placeholder="Masukkan nomor berkas atau nama pasangan..."
                       class="w-full pl-12 pr-4 py-3 rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>
        </div>
        <button onclick="searchBerkas()" class="w-full md:w-auto px-6 py-3 bg-white text-teal-700 rounded-xl hover:bg-gray-100 transition font-semibold whitespace-nowrap">
            <i class="fas fa-search mr-2"></i>Lacak Berkas
        </button>
    </div>
</div>

<!-- Tracking Result (Hidden by default) -->
<div id="trackingResult" class="hidden mb-6">
    <!-- Main Info Card -->
    <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm mb-6 reveal">
        <div class="flex items-start justify-between mb-6">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <h2 class="text-2xl font-bold text-gray-800" id="resultId">KAG-001234</h2>
                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-sm font-medium" id="resultStatus">Selesai</span>
                </div>
                <p class="text-gray-600" id="resultName">Budi Santoso & Siti Aminah</p>
                <p class="text-sm text-gray-500 mt-1" id="resultType">Pernikahan</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">Tanggal Pengajuan</p>
                <p class="font-semibold text-gray-800" id="resultDate">1 Maret 2026</p>
            </div>
        </div>

        <!-- Progress Timeline -->
        <div class="relative">
            <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>

            <div class="relative pl-10 pb-6">
                <div class="absolute left-2.5 w-3 h-3 bg-emerald-500 rounded-full border-2 border-white"></div>
                <div class="flex items-start justify-between">
                    <div>
                        <p class="font-semibold text-gray-800">Berkas Diterima</p>
                        <p class="text-sm text-gray-600">Berkas telah diterima di loket pelayanan</p>
                    </div>
                    <span class="text-sm text-gray-500">1 Mar, 08:30</span>
                </div>
            </div>

            <div class="relative pl-10 pb-6">
                <div class="absolute left-2.5 w-3 h-3 bg-emerald-500 rounded-full border-2 border-white"></div>
                <div class="flex items-start justify-between">
                    <div>
                        <p class="font-semibold text-gray-800">Verifikasi Berkas</p>
                        <p class="text-sm text-gray-600">Kelengkapan berkas sedang diverifikasi</p>
                    </div>
                    <span class="text-sm text-gray-500">1 Mar, 10:15</span>
                </div>
            </div>

            <div class="relative pl-10 pb-6">
                <div class="absolute left-2.5 w-3 h-3 bg-emerald-500 rounded-full border-2 border-white"></div>
                <div class="flex items-start justify-between">
                    <div>
                        <p class="font-semibold text-gray-800">Proses Sinkronisasi</p>
                        <p class="text-sm text-gray-600">Data sedang disinkronkan dengan Dukcapil</p>
                    </div>
                    <span class="text-sm text-gray-500">2 Mar, 09:00</span>
                </div>
            </div>

            <div class="relative pl-10 pb-6">
                <div class="absolute left-2.5 w-3 h-3 bg-emerald-500 rounded-full border-2 border-white"></div>
                <div class="flex items-start justify-between">
                    <div>
                        <p class="font-semibold text-gray-800">Pencetakan Dokumen</p>
                        <p class="text-sm text-gray-600">Dokumen sedang dicetak</p>
                    </div>
                    <span class="text-sm text-gray-500">3 Mar, 14:00</span>
                </div>
            </div>

            <div class="relative pl-10">
                <div class="absolute left-2.5 w-3 h-3 bg-emerald-500 rounded-full border-2 border-white"></div>
                <div class="flex items-start justify-between">
                    <div>
                        <p class="font-semibold text-gray-800">Selesai</p>
                        <p class="text-sm text-gray-600">Dokumen siap diambil</p>
                    </div>
                    <span class="text-sm text-gray-500">4 Mar, 09:30</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Information -->
    <div class="grid md:grid-cols-2 gap-6 mb-6">
        <!-- Document Info -->
        <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm reveal">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Dokumen</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Jenis Layanan</span>
                    <span class="font-semibold text-gray-800">Pernikahan</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Nomor Akta</span>
                    <span class="font-semibold text-gray-800">1234/2026</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Tanggal Nikah</span>
                    <span class="font-semibold text-gray-800">15 Februari 2026</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Lokasi</span>
                    <span class="font-semibold text-gray-800">KUA Balige</span>
                </div>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm reveal">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Kontak</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Nama Suami</span>
                    <span class="font-semibold text-gray-800">Budi Santoso</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">NIK Suami</span>
                    <span class="font-semibold text-gray-800">1234567890123456</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Nama Istri</span>
                    <span class="font-semibold text-gray-800">Siti Aminah</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">NIK Istri</span>
                    <span class="font-semibold text-gray-800">1234567890123457</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex gap-3 reveal">
        <button class="flex-1 px-6 py-3 bg-teal-600 text-white rounded-xl hover:bg-teal-700 transition flex items-center justify-center gap-2">
            <i class="fas fa-download"></i>
            <span>Unduh Dokumen</span>
        </button>
        <button class="flex-1 px-6 py-3 bg-gray-100 text-gray-800 rounded-xl hover:bg-gray-200 transition flex items-center justify-center gap-2">
            <i class="fas fa-print"></i>
            <span>Cetak</span>
        </button>
    </div>
</div>

<!-- Recent Tracking -->
<div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm reveal">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-bold text-gray-800">Pelacakan Terakhir</h3>
        <button class="text-sm text-teal-600 hover:text-teal-700 font-medium">Hapus Riwayat</button>
    </div>

    <div class="space-y-3" id="recentTracking">
        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:border-teal-500 hover:bg-teal-50 transition cursor-pointer" onclick="trackThis('KAG-001234')">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check text-emerald-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-800">Budi Santoso & Siti Aminah</p>
                    <p class="text-sm text-gray-600">KAG-001234 • Pernikahan</p>
                </div>
            </div>
            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-medium">Selesai</span>
        </div>

        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:border-teal-500 hover:bg-teal-50 transition cursor-pointer" onclick="trackThis('KAG-001235')">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-spinner text-blue-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-800">Ahmad & Rina Susanti</p>
                    <p class="text-sm text-gray-600">KAG-001235 • Pernikahan</p>
                </div>
            </div>
            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">Proses</span>
        </div>

        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:border-teal-500 hover:bg-teal-50 transition cursor-pointer" onclick="trackThis('KAG-001236')">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-800">Joko & Maria Widodo</p>
                    <p class="text-sm text-gray-600">KAG-001236 • Akta Nikah</p>
                </div>
            </div>
            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">Menunggu</span>
        </div>
    </div>
</div>

<script>
    function searchBerkas() {
        const input = document.getElementById('searchInput').value;

        if (!input) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Masukkan nomor berkas atau nama pasangan',
                confirmButtonColor: '#0d9488'
            });
            return;
        }

        // Show loading
        Swal.fire({
            title: 'Mencari...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Simulate search
        setTimeout(() => {
            Swal.close();
            document.getElementById('trackingResult').classList.remove('hidden');
            document.getElementById('trackingResult').scrollIntoView({ behavior: 'smooth' });
        }, 1000);
    }

    function trackThis(id) {
        document.getElementById('searchInput').value = id;
        searchBerkas();
    }

    // Allow enter key to search
    document.getElementById('searchInput')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            searchBerkas();
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
