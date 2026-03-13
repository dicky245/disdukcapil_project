@extends('layouts.user')

@section('content')
@php
    use App\Models\Layanan_Model;
    $data_layanan = Layanan_Model::all();
@endphp

<main class="pt-0">
    {{-- Page Loading --}}
    <div id="pageLoading" class="page-loading">
        <div class="loading-logo bg-white rounded-2xl shadow-2xl overflow-hidden flex items-center justify-center">
            <img src="{{ asset('images/logo_toba.jpeg') }}" alt="Logo Kabupaten Toba" class="w-full h-full object-contain p-3">
        </div>
        <div class="loading-spinner"></div>
        <div class="loading-text">Disdukcapil Kabupaten Toba</div>
        <div class="loading-subtext">Memuat antrian...</div>
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
                    <i class="fas fa-ticket-alt"></i>
                    Antrian Online
                </div>
                <h1 class="text-4xl md:text-5xl font-extrabold mb-6">
                    Ambil Nomor Antrian dari Rumah
                </h1>
                <p class="text-lg text-blue-100 mb-8">
                    Tidak perlu datang lebih awal untuk antri. Ambil nomor antrian secara online dan datang sesuai jadwal.
                </p>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#f9fafb"/>
            </svg>
        </div>
    </section>

    {{-- Queue Stats --}}
    <section class="py-12 bg-gray-50 -mt-8 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-6">
                <div class="bg-white rounded-2xl shadow-lg p-6 text-center stat-card">
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-3xl text-blue-600"></i>
                    </div>
                    <p class="text-4xl font-bold text-gray-800 mb-1" id="totalToday">-</p>
                    <p class="text-gray-600">Total Hari Ini</p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 text-center stat-card">
                    <div class="w-16 h-16 bg-yellow-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-clock text-3xl text-yellow-600"></i>
                    </div>
                    <p class="text-4xl font-bold text-gray-800 mb-1" id="waitingToday">-</p>
                    <p class="text-gray-600">Menunggu</p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 text-center stat-card">
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-spinner text-3xl text-blue-600"></i>
                    </div>
                    <p class="text-4xl font-bold text-gray-800 mb-1" id="processingToday">-</p>
                    <p class="text-gray-600">Sedang Diproses</p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 text-center stat-card">
                    <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-check-circle text-3xl text-green-600"></i>
                    </div>
                    <p class="text-4xl font-bold text-gray-800 mb-1" id="completedToday">-</p>
                    <p class="text-gray-600">Selesai</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Booking Form Section --}}
    <section class="py-16 bg-gray-50" id="formSection">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2">Ambil Nomor Antrian</h2>
                <p class="text-gray-600 mt-3 max-w-2xl mx-auto">
                    Lengkapi data diri dan pilih layanan untuk mendapatkan nomor antrian
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-8">
                <form id="antrianForm" class="space-y-6">
                    @csrf

                    {{-- Nama --}}
                    <div>
                        <label class="block text-lg font-semibold text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" required
                               placeholder="Masukkan nama lengkap sesuai KTP"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-base">
                        <p id="namaError" class="text-red-500 text-sm mt-2 hidden">Masukkan nama lengkap</p>
                    </div>

                    {{-- Jenis Layanan --}}
                    <div>
                        <label class="block text-lg font-semibold text-gray-700 mb-2">
                            Jenis Layanan <span class="text-red-500">*</span>
                        </label>
                        <select name="layanan_id" id="layanan_id" required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-base bg-white">
                            <option value="" disabled selected>Pilih jenis layanan...</option>
                            @foreach($data_layanan as $layanan)
                                <option value="{{ $layanan->layanan_id }}">{{ $layanan->nama_layanan }}</option>
                            @endforeach
                        </select>
                        <p id="layananError" class="text-red-500 text-sm mt-2 hidden">Pilih jenis layanan</p>
                    </div>

                    <button type="submit" id="submitBtn" class="w-full py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg">
                        <i class="fas fa-ticket-alt mr-2"></i>
                        Ambil Nomor Antrian
                    </button>
                </form>
            </div>
        </div>
    </section>

    {{-- Ticket Result Section dengan Animasi --}}
    <section id="ticketResult" class="py-16 bg-gray-50 hidden">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Confetti Container -->
            <div id="confetti-container" class="fixed inset-0 pointer-events-none z-50"></div>

            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden ticket-wrapper">
                <!-- Header Tiket -->
                <div class="bg-gradient-to-r from-blue-600 via-cyan-600 to-blue-700 text-white p-8 text-center relative overflow-hidden">
                    <!-- Animated Background -->
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent animate-shimmer"></div>

                    <div class="relative z-10">
                        <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mx-auto mb-4 animate-bounce-slow">
                            <i class="fas fa-ticket-alt text-5xl"></i>
                        </div>
                        <h3 class="text-3xl font-bold mb-2">Nomor Antrian Anda</h3>
                        <p class="text-blue-100">Simpan nomor ini untuk mengecek status</p>
                    </div>
                </div>

                <!-- Body Tiket -->
                <div class="p-8 text-center relative">
                    <!-- Nomor Antrian dengan Counter Animation -->
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-8 mb-6 relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-600/5 to-cyan-600/5 animate-pulse-slow"></div>
                        <div class="relative z-10">
                            <p class="text-sm text-gray-500 mb-2 font-medium">NOMOR ANTRIAN</p>
                            <div class="text-7xl font-black bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent mb-4 counter-animate" id="ticketNumber">ABC-123</div>
                            <div class="flex items-center justify-center gap-2 text-sm text-gray-500">
                                <i class="fas fa-clock"></i>
                                <span id="ticketTime">-</span>
                            </div>
                        </div>
                    </div>

                    <!-- Info Grid -->
                    <div class="grid grid-cols-2 gap-4 text-left mb-6">
                        <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-4 border border-blue-100 info-card">
                            <div class="flex items-center gap-2 mb-2">
                                <i class="fas fa-user text-blue-600"></i>
                                <p class="text-xs font-semibold text-gray-500 uppercase">Nama</p>
                            </div>
                            <p class="font-bold text-gray-800 text-lg" id="ticketName">-</p>
                        </div>
                        <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-4 border border-purple-100 info-card">
                            <div class="flex items-center gap-2 mb-2">
                                <i class="fas fa-file-alt text-purple-600"></i>
                                <p class="text-xs font-semibold text-gray-500 uppercase">Layanan</p>
                            </div>
                            <p class="font-bold text-gray-800 text-lg" id="ticketService">-</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3">
                        <button onclick="printTicket()" class="flex-1 py-3 bg-gradient-to-r from-gray-100 to-gray-200 text-gray-800 rounded-xl font-bold hover:from-gray-200 hover:to-gray-300 transition-all shadow-md action-btn no-print">
                            <i class="fas fa-print mr-2"></i>
                            Cetak Tiket
                        </button>
                        <button onclick="resetForm()" class="flex-1 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg action-btn no-print">
                            <i class="fas fa-plus mr-2"></i>
                            Ambil Lagi
                        </button>
                    </div>
                </div>

                <!-- Decorative Elements -->
                <div class="absolute top-0 left-0 w-32 h-32 bg-blue-500/10 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 right-0 w-32 h-32 bg-cyan-500/10 rounded-full translate-x-1/2 translate-y-1/2"></div>
            </div>
        </div>
    </section>

    {{-- Cari Antrian Section --}}
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2">Lupa Nomor Antrian?</h2>
                <p class="text-gray-600 mt-3">Cari nomor antrian Anda dengan memasukkan nama atau nomor antrian</p>
            </div>

            <div class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-2xl shadow-lg p-8 border border-gray-100">
                <div class="grid md:grid-cols-3 gap-4 mb-6">
                    <div class="md:col-span-2">
                        <input type="text" id="searchInput" placeholder="Masukkan nama atau nomor antrian"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    </div>
                    <div>
                        <select id="searchLayanan" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                            <option value="">Semua Layanan</option>
                            @foreach($data_layanan as $layanan)
                                <option value="{{ $layanan->layanan_id }}">{{ $layanan->nama_layanan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button onclick="searchAntrian()" class="w-full py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg">
                    <i class="fas fa-search mr-2"></i>
                    Cari Antrian
                </button>
            </div>

            <!-- Search Results dengan Staggered Animation -->
            <div id="searchResults" class="mt-8 space-y-4"></div>
        </div>
    </section>

    {{-- Lacak Berkas Section --}}
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2">Pantau Status Berkas Anda</h2>
                <p class="text-gray-600 mt-3">Masukkan nomor antrian atau nama lengkap untuk melacak status berkas</p>
            </div>

            <div class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-2xl shadow-lg p-8 border border-gray-100">
                <div class="grid md:grid-cols-3 gap-4 mb-6">
                    <div class="md:col-span-2">
                        <div class="relative">
                            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" id="lacakInput" placeholder="Masukkan nomor antrian (contoh: ABC-123-456) atau nama lengkap"
                                   class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        </div>
                    </div>
                    <div>
                        <select id="lacakLayanan" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                            <option value="">Semua Layanan</option>
                            @foreach($data_layanan as $layanan)
                                <option value="{{ $layanan->layanan_id }}">{{ $layanan->nama_layanan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button onclick="lacakBerkas()" class="w-full py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg">
                    <i class="fas fa-search mr-2"></i>
                    Lacak Status
                </button>
            </div>

            {{-- Hasil Lacak dengan Timeline Animation --}}
            <div id="lacakResult" class="hidden mt-8">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden lacak-card">
                    <!-- Header dengan Gradient -->
                    <div class="bg-gradient-to-r from-blue-600 via-cyan-600 to-blue-700 text-white p-6 relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent animate-shimmer"></div>
                        <div class="relative z-10 flex items-center justify-between">
                            <div>
                                <p class="text-sm opacity-90 mb-1 flex items-center gap-2">
                                    <i class="fas fa-ticket-alt"></i>
                                    Nomor Antrian
                                </p>
                                <h3 class="text-3xl font-bold tracking-wide" id="lacakNomor">ABC-123-456</h3>
                            </div>
                            <span class="px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-bold uppercase animate-pulse-slow" id="lacakStatus">Menunggu</span>
                        </div>
                        <div class="relative z-10 mt-4 grid grid-cols-2 gap-4">
                            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3">
                                <p class="text-sm opacity-90 flex items-center gap-2">
                                    <i class="fas fa-user text-xs"></i>
                                    Nama Lengkap
                                </p>
                                <p class="font-semibold" id="lacakNama">-</p>
                            </div>
                            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3">
                                <p class="text-sm opacity-90 flex items-center gap-2">
                                    <i class="fas fa-file-alt text-xs"></i>
                                    Jenis Layanan
                                </p>
                                <p class="font-semibold" id="lacakLayanan">-</p>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline Riwayat dengan Animated Progress Line -->
                    <div class="p-6">
                        <h4 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                            <i class="fas fa-history text-blue-600"></i>
                            Riwayat Status
                        </h4>
                        <div id="lacakTimeline" class="relative">
                            <!-- Timeline items will be inserted here -->
                        </div>
                    </div>

                    <!-- Print Button untuk Hasil Lacak -->
                    <div class="px-6 pb-6 no-print">
                        <button onclick="printLacakResult()" class="w-full py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg">
                            <i class="fas fa-print mr-2"></i>
                            Cetak Status Berkas
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@push('styles')
<style>
    /* Ticket Animation */
    .ticket-wrapper {
        animation: ticketAppear 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    @keyframes ticketAppear {
        0% {
            transform: scale(0.3) rotate(-10deg);
            opacity: 0;
        }
        50% {
            transform: scale(1.05) rotate(2deg);
        }
        100% {
            transform: scale(1) rotate(0deg);
            opacity: 1;
        }
    }

    /* Counter Animation untuk Nomor Antrian */
    .counter-animate {
        animation: counterPop 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55) 0.3s both;
    }

    @keyframes counterPop {
        0% {
            transform: scale(0);
            opacity: 0;
        }
        50% {
            transform: scale(1.2);
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    /* Info Cards Staggered Animation */
    .info-card {
        animation: slideUp 0.5s ease-out 0.4s both;
    }

    .info-card:nth-child(1) {
        animation-delay: 0.4s;
    }

    .info-card:nth-child(2) {
        animation-delay: 0.5s;
    }

    @keyframes slideUp {
        from {
            transform: translateY(20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Action Buttons */
    .action-btn {
        animation: buttonSlide 0.5s ease-out 0.6s both;
    }

    @keyframes buttonSlide {
        from {
            transform: translateY(10px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Shimmer Effect */
    @keyframes shimmer {
        0% {
            transform: translateX(-100%);
        }
        100% {
            transform: translateX(100%);
        }
    }

    .animate-shimmer > div {
        animation: shimmer 2s infinite;
    }

    /* Bounce Animation */
    @keyframes bounce-slow {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }

    .animate-bounce-slow {
        animation: bounce-slow 2s ease-in-out infinite;
    }

    /* Pulse Slow Animation */
    @keyframes pulse-slow {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.7;
        }
    }

    .animate-pulse-slow {
        animation: pulse-slow 2s ease-in-out infinite;
    }

    /* Search Result Card Animation */
    .search-result-card {
        animation: cardSlideIn 0.5s ease-out both;
    }

    @keyframes cardSlideIn {
        from {
            transform: translateX(-30px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    /* Lacak Card Animation */
    .lacak-card {
        animation: lacakAppear 0.7s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    @keyframes lacakAppear {
        0% {
            transform: scale(0.8) translateY(20px);
            opacity: 0;
        }
        100% {
            transform: scale(1) translateY(0);
            opacity: 1;
        }
    }

    /* Timeline Animation */
    .timeline-item {
        animation: timelineFade 0.5s ease-out both;
    }

    @keyframes timelineFade {
        from {
            transform: translateX(-20px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    /* Timeline Progress Line Animation */
    .timeline-progress {
        animation: progressLine 1.5s ease-out forwards;
    }

    @keyframes progressLine {
        from {
            height: 0;
        }
        to {
            height: 100%;
        }
    }

    /* Status Badge Glow */
    .status-glow {
        animation: glow 2s ease-in-out infinite;
    }

    @keyframes glow {
        0%, 100% {
            box-shadow: 0 0 5px currentColor;
        }
        50% {
            box-shadow: 0 0 20px currentColor, 0 0 30px currentColor;
        }
    }

    /* Confetti Animation */
    .confetti {
        position: fixed;
        width: 10px;
        height: 10px;
        top: -10px;
        animation: confettiFall 3s linear forwards;
    }

    @keyframes confettiFall {
        0% {
            transform: translateY(0) rotate(0deg);
            opacity: 1;
        }
        100% {
            transform: translateY(100vh) rotate(720deg);
            opacity: 0;
        }
    }

    /* Stat Cards */
    .stat-card {
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    /* Print Styles */
    @media print {
        /* Sembunyikan semua elemen kecuali tiket */
        body > *:not(#ticketResult):not(#lacakResult) {
            display: none !important;
        }

        /* Tampilkan section yang relevan */
        #ticketResult,
        #lacakResult {
            display: block !important;
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            margin: 0 !important;
            padding: 20px !important;
        }

        /* Hilangkan elemen dekoratif dan tombol */
        .no-print,
        #confetti-container,
        .action-btn,
        #ticketResult .absolute:not(.bg-gradient-to-r):not(.inset-0) {
            display: none !important;
        }

        /* Style untuk cetak tiket */
        .ticket-wrapper {
            box-shadow: none !important;
            border: 2px solid #000 !important;
            page-break-inside: avoid;
            max-width: 100% !important;
        }

        /* Style untuk cetak lacak result */
        .lacak-card {
            box-shadow: none !important;
            border: 1px solid #000 !important;
            page-break-inside: avoid;
        }

        .bg-gradient-to-r {
            background: #0052CC !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Pastikan warna tercetak dengan benar */
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        /* Hentikan semua animasi saat print */
        * {
            animation: none !important;
            transition: none !important;
            transform: none !important;
        }

        /* Atur ukuran kertas */
        @page {
            size: A4;
            margin: 15mm;
        }

        body {
            margin: 0;
            padding: 0;
            background: white !important;
        }

        /* Pastikan text tetap terbaca */
        .text-transparent {
            background-clip: border-box !important;
            -webkit-background-clip: border-box !important;
            color: #0052CC !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Load Statistics on Page Load
    document.addEventListener('DOMContentLoaded', function() {
        loadStatistics();
    });

    function loadStatistics() {
        fetch('{{ route('antrian.statistik') }}')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    animateCounter('totalToday', data.data.total_antrian);
                    animateCounter('waitingToday', data.data.antrian_menunggu);
                    animateCounter('processingToday', data.data.antrian_diproses);
                    animateCounter('completedToday', data.data.antrian_selesai);
                }
            })
            .catch(err => console.error('Gagal memuat statistik:', err));
    }

    // Counter Animation
    function animateCounter(elementId, target) {
        const element = document.getElementById(elementId);
        const duration = 1000;
        const steps = 30;
        const increment = target / steps;
        let current = 0;

        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                element.textContent = target;
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current);
            }
        }, duration / steps);
    }

    // Form Submit Handler dengan Confetti
    document.getElementById('antrianForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // Client-side validation
        const nama = document.getElementById('nama_lengkap').value.trim();
        const layanan = document.getElementById('layanan_id').value;

        if (!nama) {
            Swal.fire({
                icon: 'warning',
                title: 'Data Belum Lengkap',
                text: 'Nama lengkap harus diisi',
                confirmButtonColor: '#0052CC',
                confirmButtonText: 'OK'
            });
            document.getElementById('nama_lengkap').focus();
            return;
        }

        if (!layanan) {
            Swal.fire({
                icon: 'warning',
                title: 'Layanan Belum Dipilih',
                text: 'Silakan pilih jenis layanan terlebih dahulu',
                confirmButtonColor: '#0052CC',
                confirmButtonText: 'OK'
            });
            document.getElementById('layanan_id').focus();
            return;
        }

        const formData = new FormData(this);
        const data = Object.fromEntries(formData);
        const submitBtn = document.getElementById('submitBtn');

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';

        // Show loading
        Swal.fire({
            title: 'Memproses...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        fetch('{{ route('antrian.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            Swal.close();
            if (data.success) {
                document.getElementById('ticketNumber').textContent = data.data.nomor_antrian;
                document.getElementById('ticketName').textContent = data.data.nama_lengkap;
                document.getElementById('ticketService').textContent = data.data.layanan;
                document.getElementById('ticketTime').textContent = new Date().toLocaleString('id-ID', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });

                document.getElementById('formSection').classList.add('hidden');
                document.getElementById('ticketResult').classList.remove('hidden');
                document.getElementById('ticketResult').scrollIntoView({ behavior: 'smooth' });

                // Trigger Confetti Animation
                createConfetti();

                // Show success message
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    html: `Nomor antrian <strong>${data.data.nomor_antrian}</strong> telah dibuat!<br><small class="text-gray-500">Silakan simpan nomor ini</small>`,
                    confirmButtonColor: '#0052CC',
                    confirmButtonText: 'OK',
                    timer: 3000,
                    timerProgressBar: true
                });

                loadStatistics();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: data.message || 'Terjadi kesalahan saat mengambil antrian',
                    confirmButtonColor: '#0052CC',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(err => {
            console.error('Error:', err);
            Swal.fire({
                icon: 'error',
                title: 'Koneksi Error',
                text: 'Gagal mengambil antrian. Pastikan koneksi server tersedia.',
                confirmButtonColor: '#0052CC',
                confirmButtonText: 'OK'
            });
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-ticket-alt mr-2"></i>Ambil Nomor Antrian';
        });
    });

    // Confetti Animation
    function createConfetti() {
        const container = document.getElementById('confetti-container');
        const colors = ['#0052CC', '#00B8D9', '#36B37E', '#FFAB00', '#FF5630', '#6554C0'];

        for (let i = 0; i < 50; i++) {
            const confetti = document.createElement('div');
            confetti.className = 'confetti';
            confetti.style.left = Math.random() * 100 + 'vw';
            confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
            confetti.style.animationDelay = Math.random() * 2 + 's';
            confetti.style.animationDuration = (Math.random() * 2 + 2) + 's';
            container.appendChild(confetti);

            setTimeout(() => confetti.remove(), 4000);
        }
    }

    // Print Tiket Antrian
    function printTicket() {
        Swal.fire({
            title: 'Cetak Tiket Antrian?',
            text: 'Tiket akan dicetak dalam format yang rapi',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0052CC',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Cetak',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Simpan konten asli
                const ticketNumber = document.getElementById('ticketNumber').textContent;
                const ticketName = document.getElementById('ticketName').textContent;
                const ticketService = document.getElementById('ticketService').textContent;
                const ticketTime = document.getElementById('ticketTime').textContent;

        // Buat window print khusus
        const printWindow = window.open('', '_blank', 'width=800,height=600');

        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Cetak Tiket Antrian - Disdukcapil Kabupaten Toba</title>
                <link rel="icon" type="image/jpeg" href="{{ asset('images/logo_toba.jpeg') }}">
                <script src="https://cdn.tailwindcss.com"><\/script>
                <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
                <style>
                    @media print {
                        @page {
                            size: A4;
                            margin: 20mm;
                        }
                        body {
                            margin: 0;
                            padding: 20px;
                            -webkit-print-color-adjust: exact;
                            print-color-adjust: exact;
                        }
                        .no-print {
                            display: none !important;
                        }
                    }
                    * {
                        font-family: 'Plus Jakarta Sans', sans-serif;
                        -webkit-print-color-adjust: exact !important;
                        print-color-adjust: exact !important;
                    }
                </style>
            </head>
            <body class="bg-gray-100 min-h-screen flex items-center justify-center">
                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden max-w-md mx-auto">
                    <!-- Header Tiket -->
                    <div class="bg-gradient-to-r from-blue-600 to-cyan-600 text-white p-8 text-center">
                        <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-ticket-alt text-5xl"></i>
                        </div>
                        <h3 class="text-3xl font-bold mb-2">Nomor Antrian</h3>
                        <p class="text-blue-100 text-sm">Disdukcapil Kabupaten Toba</p>
                    </div>

                    <!-- Body Tiket -->
                    <div class="p-8 text-center">
                        <!-- Nomor Antrian -->
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-8 mb-6 border-2 border-blue-200">
                            <p class="text-sm text-gray-500 mb-2 font-bold uppercase tracking-wider">NOMOR ANTRIAN</p>
                            <div class="text-6xl font-black bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent mb-4">
                                ${document.getElementById('ticketNumber').textContent}
                            </div>
                            <div class="flex items-center justify-center gap-2 text-sm text-gray-600">
                                <i class="fas fa-calendar-alt"></i>
                                <span>${document.getElementById('ticketTime').textContent}</span>
                            </div>
                        </div>

                        <!-- Info Grid -->
                        <div class="grid grid-cols-2 gap-4 text-left mb-6">
                            <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-4 border border-blue-100">
                                <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Nama</p>
                                <p class="font-bold text-gray-800 text-lg">${document.getElementById('ticketName').textContent}</p>
                            </div>
                            <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-4 border border-purple-100">
                                <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Layanan</p>
                                <p class="font-bold text-gray-800 text-lg">${document.getElementById('ticketService').textContent}</p>
                            </div>
                        </div>

                        <!-- Footer Info -->
                        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-left">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-info-circle text-yellow-600 mt-1"></i>
                                <div>
                                    <p class="font-bold text-yellow-800 text-sm">Informasi Penting:</p>
                                    <ul class="text-xs text-yellow-700 mt-2 space-y-1">
                                        <li>• Simpan nomor antrian ini</li>
                                        <li>• Datang ke loket sesuai jadwal</li>
                                        <li>• Tunjukkan nomor ini saat dipanggil</li>
                                        <li>• Nomor antrian berlaku untuk hari ini</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Print Button (No Print) -->
                        <div class="mt-6 no-print">
                            <button onclick="window.print()" class="w-full py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg">
                                <i class="fas fa-print mr-2"></i>
                                Cetak Sekarang
                            </button>
                        </div>
                    </div>
                </div>

                <script>
                    // Auto print setelah loading
                    window.addEventListener('load', function() {
                        setTimeout(function() {
                            window.print();
                        }, 500);
                    });
                <\/script>
            </body>
            </html>
        `);

        printWindow.document.close();

        // Tunggu window print tertutup untuk fokus kembali ke window utama
        printWindow.onbeforeunload = function() {
            window.focus();
        };
            }
        });
    }

    function resetForm() {
        Swal.fire({
            title: 'Ambil Antrian Baru?',
            text: 'Nomor antrian saat ini akan hilang. Apakah Anda yakin?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0052CC',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Ambil Lagi',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('antrianForm').reset();
                document.getElementById('formSection').classList.remove('hidden');
                document.getElementById('ticketResult').classList.add('hidden');
                window.scrollTo({ top: 0, behavior: 'smooth' });

                // Show success message
                Swal.fire({
                    icon: 'success',
                    title: 'Form Direset',
                    text: 'Silakan ambil nomor antrian baru',
                    timer: 1500,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            }
        });
    }

    // Search Antrian dengan Staggered Animation
    function searchAntrian() {
        const search = document.getElementById('searchInput').value.trim();
        const layanan = document.getElementById('searchLayanan').value;

        if (!search) {
            Swal.fire({
                icon: 'warning',
                title: 'Input Kosong',
                text: 'Masukkan nama atau nomor antrian terlebih dahulu',
                confirmButtonColor: '#0052CC',
                confirmButtonText: 'OK'
            });
            return;
        }

        const params = new URLSearchParams({
            nama_lengkap: search,
            layanan_id: layanan
        });

        // Show loading
        Swal.fire({
            title: 'Mencari...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        fetch(`{{ route('antrian.search') }}?${params}`)
            .then(response => response.json())
            .then(data => {
                Swal.close();
                const resultsContainer = document.getElementById('searchResults');
                if (data.success && data.data.length > 0) {
                    renderSearchResults(data.data);

                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Ditemukan!',
                        text: `Menemukan ${data.data.length} data antrian`,
                        timer: 2000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                } else {
                    resultsContainer.innerHTML = `
                        <div class="text-center py-8 animate-fade-in">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-inbox text-3xl text-gray-400"></i>
                            </div>
                            <p class="text-gray-500 font-medium">Data antrian tidak ditemukan.</p>
                            <p class="text-sm text-gray-400 mt-1">Coba kata kunci lain atau periksa kembali nomor antrian Anda.</p>
                        </div>
                    `;
                }
            })
            .catch(err => {
                Swal.close();
                console.error('Error:', err);
                Swal.fire({
                    icon: 'error',
                    title: 'Koneksi Error',
                    text: 'Gagal mencari data. Pastikan koneksi tersedia.',
                    confirmButtonColor: '#0052CC',
                    confirmButtonText: 'OK'
                });
            });
    }

    function renderSearchResults(results) {
        const html = results.map((antrian, index) => {
            const statusColors = {
                'Menunggu': 'bg-amber-100 text-amber-700 border-amber-200',
                'Dokumen Diterima': 'bg-blue-100 text-blue-700 border-blue-200',
                'Verifikasi Data': 'bg-indigo-100 text-indigo-700 border-indigo-200',
                'Proses Cetak': 'bg-purple-100 text-purple-700 border-purple-200',
                'Siap Pengambilan': 'bg-emerald-100 text-emerald-700 border-emerald-200',
                'Ditolak': 'bg-red-100 text-red-700 border-red-200',
                'Dibatalkan': 'bg-rose-100 text-rose-700 border-rose-200'
            };
            const colorClass = statusColors[antrian.status_antrian] || 'bg-gray-100 text-gray-700';
            const statusIcons = {
                'Menunggu': 'fa-clock',
                'Dokumen Diterima': 'fa-file-check',
                'Verifikasi Data': 'fa-search',
                'Proses Cetak': 'fa-print',
                'Siap Pengambilan': 'fa-box-open',
                'Ditolak': 'fa-ban',
                'Dibatalkan': 'fa-times'
            };
            const icon = statusIcons[antrian.status_antrian] || 'fa-info-circle';

            return `
                <div class="search-result-card bg-white border-2 border-gray-100 rounded-xl p-5 flex justify-between items-center shadow-md hover:shadow-xl transition-all duration-300 hover:border-blue-200 cursor-pointer" style="animation-delay: ${index * 0.1}s" onclick='showAntrianDetail(${JSON.stringify(antrian)})'>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg">
                            ${antrian.nomor_antrian.substring(0, 2)}
                        </div>
                        <div>
                            <p class="font-bold text-blue-600 text-lg">${antrian.nomor_antrian}</p>
                            <p class="text-gray-800 font-semibold">${antrian.nama_lengkap}</p>
                            <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">
                                <i class="fas fa-file-alt mr-1"></i>
                                ${antrian.layanan ? antrian.layanan.nama_layanan : 'Layanan Umum'}
                            </p>
                        </div>
                    </div>
                    <span class="px-4 py-2 rounded-full text-xs font-bold uppercase border ${colorClass} flex items-center gap-2 shadow-sm">
                        <i class="fas ${icon}"></i>
                        ${antrian.status_antrian}
                    </span>
                </div>
            `;
        }).join('');
        document.getElementById('searchResults').innerHTML = html;
    }

    // Show detail antrian dengan SweetAlert
    function showAntrianDetail(antrian) {
        const statusColors = {
            'Menunggu': '#f59e0b',
            'Dokumen Diterima': '#3b82f6',
            'Verifikasi Data': '#6366f1',
            'Proses Cetak': '#a855f7',
            'Siap Pengambilan': '#10b981',
            'Ditolak': '#ef4444',
            'Dibatalkan': '#f43f5e'
        };
        const statusIcon = {
            'Menunggu': 'fa-clock',
            'Dokumen Diterima': 'fa-file-check',
            'Verifikasi Data': 'fa-search',
            'Proses Cetak': 'fa-print',
            'Siap Pengambilan': 'fa-box-open',
            'Ditolak': 'fa-ban',
            'Dibatalkan': 'fa-times'
        };

        Swal.fire({
            title: antrian.nomor_antrian,
            html: `
                <div class="text-left">
                    <div class="mb-4">
                        <p class="text-sm text-gray-500 mb-1">Nama Lengkap</p>
                        <p class="font-bold text-gray-800">${antrian.nama_lengkap}</p>
                    </div>
                    <div class="mb-4">
                        <p class="text-sm text-gray-500 mb-1">Jenis Layanan</p>
                        <p class="font-bold text-gray-800">${antrian.layanan ? antrian.layanan.nama_layanan : 'Layanan Umum'}</p>
                    </div>
                    <div class="mb-4">
                        <p class="text-sm text-gray-500 mb-1">Status</p>
                        <p class="font-bold" style="color: ${statusColors[antrian.status_antrian] || '#6b7280'}">
                            <i class="fas ${statusIcon[antrian.status_antrian] || 'fa-info-circle'} mr-2"></i>
                            ${antrian.status_antrian}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Tanggal Pengajuan</p>
                        <p class="font-semibold text-gray-700">${new Date(antrian.created_at).toLocaleString('id-ID', {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        })}</p>
                    </div>
                </div>
            `,
            icon: 'info',
            confirmButtonColor: '#0052CC',
            confirmButtonText: 'Tutup',
            showCloseButton: true
        });
    }

    // Lacak Berkas dengan Timeline Animation
    function lacakBerkas() {
        const input = document.getElementById('lacakInput').value.trim();
        const layanan = document.getElementById('lacakLayanan').value;

        if (!input) {
            Swal.fire({
                icon: 'warning',
                title: 'Input Kosong',
                text: 'Masukkan nomor antrian atau nama lengkap terlebih dahulu',
                confirmButtonColor: '#0052CC',
                confirmButtonText: 'OK'
            });
            return;
        }

        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mencari...';

        const isNomorAntrian = /^[A-Z]{3}-\d{3}-\d{3}$/.test(input.toUpperCase());
        const params = new URLSearchParams();
        if (isNomorAntrian) {
            params.append('nomor_antrian', input.toUpperCase());
        } else {
            params.append('nama_lengkap', input);
        }
        if (layanan) {
            params.append('layanan_id', layanan);
        }

        // Show loading
        Swal.fire({
            title: 'Melacak...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        fetch(`{{ route('antrian.lacak') }}?${params}`)
            .then(response => response.json())
            .then(data => {
                Swal.close();
                if (data.success) {
                    displayLacakResult(data.data);
                    document.getElementById('lacakResult').classList.remove('hidden');
                    document.getElementById('lacakResult').scrollIntoView({ behavior: 'smooth' });

                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Data Ditemukan!',
                        text: `Status antrian ${data.data.nomor_antrian}: ${data.data.status_antrian}`,
                        timer: 2000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Data Tidak Ditemukan',
                        text: data.message || 'Data antrian tidak ditemukan. Silakan periksa kembali nomor antrian atau nama Anda.',
                        confirmButtonColor: '#0052CC',
                        confirmButtonText: 'OK'
                    });
                    document.getElementById('lacakResult').classList.add('hidden');
                }
            })
            .catch(err => {
                Swal.close();
                console.error('Error:', err);
                Swal.fire({
                    icon: 'error',
                    title: 'Koneksi Error',
                    text: 'Gagal mencari data. Pastikan koneksi tersedia.',
                    confirmButtonColor: '#0052CC',
                    confirmButtonText: 'OK'
                });
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = originalText;
            });
    }

    function displayLacakResult(data) {
        document.getElementById('lacakNomor').textContent = data.nomor_antrian;
        document.getElementById('lacakNama').textContent = data.nama_lengkap;
        document.getElementById('lacakLayanan').textContent = data.layanan;

        const statusBadge = document.getElementById('lacakStatus');
        statusBadge.textContent = data.status_antrian;
        statusBadge.className = 'px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-bold uppercase animate-pulse-slow ' + getStatusColor(data.status_antrian);

        const timeline = document.getElementById('lacakTimeline');
        if (data.riwayat && data.riwayat.length > 0) {
            let timelineHTML = '<div class="relative">';
            timelineHTML += '<div class="absolute left-4 top-0 bottom-0 w-1 bg-gradient-to-b from-blue-500 to-cyan-500 rounded-full timeline-progress"></div>';

            data.riwayat.forEach((item, index) => {
                const isLast = index === data.riwayat.length - 1;
                const dotColor = getTimelineDotColor(item.status);
                const dotSize = item.status === data.status_antrian ? 'w-5 h-5' : 'w-4 h-4';
                const glowClass = item.status === data.status_antrian ? 'status-glow' : '';
                const date = new Date(item.tanggal);
                const formattedDate = date.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });

                timelineHTML += `
                    <div class="timeline-item relative pl-12 ${!isLast ? 'pb-8' : ''}" style="animation-delay: ${index * 0.15}s">
                        <div class="absolute left-0 ${dotSize} ${dotColor} ${glowClass} rounded-full border-4 border-white shadow-lg transform transition-transform hover:scale-110"></div>
                        <div class="bg-gradient-to-r from-gray-50 to-blue-50 rounded-xl p-4 border border-gray-200 hover:shadow-md transition-all">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <i class="fas ${getTimelineIcon(item.status)} text-sm ${getTimelineIconColor(item.status)}"></i>
                                        <p class="font-bold text-gray-800">${item.status}</p>
                                    </div>
                                    <p class="text-sm text-gray-600 ml-6">${item.keterangan || 'Status diperbarui'}</p>
                                    ${item.alasan_penolakan ? `
                                        <div class="mt-2 ml-6 p-2 bg-red-50 border border-red-200 rounded-lg">
                                            <p class="text-sm text-red-700 font-semibold flex items-center gap-2">
                                                <i class="fas fa-exclamation-circle"></i>
                                                ${item.alasan_penolakan}
                                            </p>
                                        </div>
                                    ` : ''}
                                </div>
                                <div class="ml-4 text-right">
                                    <span class="text-xs text-gray-500 font-medium">${formattedDate}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            timelineHTML += '</div>';
            timeline.innerHTML = timelineHTML;
        } else {
            timeline.innerHTML = `
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-history text-3xl text-gray-400"></i>
                    </div>
                    <p class="text-gray-500 font-medium">Belum ada riwayat status</p>
                </div>
            `;
        }
    }

    function getStatusColor(status) {
        switch(status) {
            case 'Menunggu': return '!text-amber-700 !bg-amber-500/30';
            case 'Dokumen Diterima': return '!text-blue-700 !bg-blue-500/30';
            case 'Verifikasi Data': return '!text-indigo-700 !bg-indigo-500/30';
            case 'Proses Cetak': return '!text-purple-700 !bg-purple-500/30';
            case 'Siap Pengambilan': return '!text-emerald-700 !bg-emerald-500/30';
            case 'Ditolak': return '!text-red-700 !bg-red-500/30';
            case 'Dibatalkan': return '!text-rose-700 !bg-rose-500/30';
            default: return '!text-gray-700 !bg-gray-500/30';
        }
    }

    function getTimelineDotColor(status) {
        switch(status) {
            case 'Menunggu': return 'bg-amber-500';
            case 'Dokumen Diterima': return 'bg-blue-500';
            case 'Verifikasi Data': return 'bg-indigo-500';
            case 'Proses Cetak': return 'bg-purple-500';
            case 'Siap Pengambilan': return 'bg-emerald-500';
            case 'Ditolak': return 'bg-red-500';
            case 'Dibatalkan': return 'bg-rose-500';
            default: return 'bg-gray-500';
        }
    }

    function getTimelineIcon(status) {
        switch(status) {
            case 'Menunggu': return 'fa-clock';
            case 'Dokumen Diterima': return 'fa-file-check';
            case 'Verifikasi Data': return 'fa-search';
            case 'Proses Cetak': return 'fa-print';
            case 'Siap Pengambilan': return 'fa-box-open';
            case 'Ditolak': return 'fa-ban';
            case 'Dibatalkan': return 'fa-times';
            default: return 'fa-info-circle';
        }
    }

    function getTimelineIconColor(status) {
        switch(status) {
            case 'Menunggu': return 'text-amber-600';
            case 'Dokumen Diterima': return 'text-blue-600';
            case 'Verifikasi Data': return 'text-indigo-600';
            case 'Proses Cetak': return 'text-purple-600';
            case 'Siap Pengambilan': return 'text-emerald-600';
            case 'Ditolak': return 'text-red-600';
            case 'Dibatalkan': return 'text-rose-600';
            default: return 'text-gray-600';
        }
    }

    // Print Hasil Lacak Berkas
    function printLacakResult() {
        Swal.fire({
            title: 'Cetak Status Berkas?',
            text: 'Status berkas akan dicetak lengkap dengan riwayat',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0052CC',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Cetak',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                const nomor = document.getElementById('lacakNomor').textContent;
                const nama = document.getElementById('lacakNama').textContent;
                const layanan = document.getElementById('lacakLayanan').textContent;
                const status = document.getElementById('lacakStatus').textContent;

        // Ambil timeline content
        const timeline = document.getElementById('lacakTimeline').innerHTML;

        // Buat window print khusus
        const printWindow = window.open('', '_blank', 'width=800,height=800');

        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Status Berkas - ${nomor} - Disdukcapil Kabupaten Toba</title>
                <link rel="icon" type="image/jpeg" href="{{ asset('images/logo_toba.jpeg') }}">
                <script src="https://cdn.tailwindcss.com"><\/script>
                <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
                <style>
                    @media print {
                        @page {
                            size: A4;
                            margin: 15mm;
                        }
                        body {
                            margin: 0;
                            padding: 15px;
                            -webkit-print-color-adjust: exact;
                            print-color-adjust: exact;
                        }
                        .no-print {
                            display: none !important;
                        }
                        .page-break {
                            page-break-before: always;
                        }
                    }
                    * {
                        font-family: 'Plus Jakarta Sans', sans-serif;
                        -webkit-print-color-adjust: exact !important;
                        print-color-adjust: exact !important;
                    }
                    .timeline-line {
                        position: absolute;
                        left: 16px;
                        top: 0;
                        bottom: 0;
                        width: 2px;
                        background: linear-gradient(to bottom, #0052CC, #00B8D9);
                    }
                </style>
            </head>
            <body class="bg-gray-50">
                <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-blue-600 to-cyan-600 text-white p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                    <i class="fas fa-ticket-alt text-2xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm opacity-90">Nomor Antrian</p>
                                    <h2 class="text-2xl font-bold">${nomor}</h2>
                                </div>
                            </div>
                            <span class="px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-bold uppercase">${status}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3">
                                <p class="text-xs opacity-90">Nama Lengkap</p>
                                <p class="font-semibold">${nama}</p>
                            </div>
                            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3">
                                <p class="text-xs opacity-90">Jenis Layanan</p>
                                <p class="font-semibold">${layanan}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline Section -->
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                            <i class="fas fa-history text-blue-600"></i>
                            Riwayat Status
                        </h3>
                        <div class="relative">
                            <div class="timeline-line"></div>
                            ${timeline}
                        </div>
                    </div>

                    <!-- Footer Info -->
                    <div class="bg-blue-50 border-t border-blue-100 p-6">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-info-circle text-blue-600 mt-1"></i>
                            <div>
                                <p class="font-bold text-blue-800 text-sm mb-1">Informasi:</p>
                                <ul class="text-xs text-blue-700 space-y-1">
                                    <li>• Cetak dokumen ini sebagai bukti status berkas</li>
                                    <li>• Pantau terus status berkas Anda secara berkala</li>
                                    <li>• Hubungi loket jika ada pertanyaan</li>
                                </ul>
                            </div>
                        </div>
                        <div class="mt-4 text-center">
                            <p class="text-xs text-gray-500">
                                <i class="fas fa-clock mr-1"></i>
                                Dicetak pada: ${new Date().toLocaleString('id-ID', {
                                    day: 'numeric',
                                    month: 'long',
                                    year: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit'
                                })}
                            </p>
                        </div>
                    </div>

                    <!-- Print Button (No Print) -->
                    <div class="p-6 no-print bg-gray-50">
                        <button onclick="window.print()" class="w-full py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg">
                            <i class="fas fa-print mr-2"></i>
                            Cetak Sekarang
                        </button>
                    </div>
                </div>

                <script>
                    // Auto print setelah loading
                    window.addEventListener('load', function() {
                        setTimeout(function() {
                            window.print();
                        }, 500);
                    });
                <\/script>
            </body>
            </html>
        `);

        printWindow.document.close();

        // Tunggu window print tertutup
        printWindow.onbeforeunload = function() {
            window.focus();
        };
            }
        });
    }

    // Enter key support
    document.getElementById('lacakInput')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            lacakBerkas();
        }
    });

    document.getElementById('searchInput')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            searchAntrian();
        }
    });
</script>
@endpush
