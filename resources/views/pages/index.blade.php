@extends('layouts.user')

@section('content')
@php
    use Illuminate\Support\Str;
@endphp

<main class="pt-0">
    {{-- Page Loading with Animated Logo --}}
    <div id="pageLoading" class="page-loading">
        <div class="loading-logo bg-white rounded-2xl shadow-2xl overflow-hidden flex items-center justify-center">
            <img src="{{ asset('images/logo_toba.jpeg') }}" alt="Logo Kabupaten Toba" class="w-full h-full object-contain p-3">
        </div>
        <div class="loading-spinner"></div>
        <div class="loading-text">Disdukcapil Kabupaten Toba</div>
        <div class="loading-subtext">Memuat layanan...</div>
        <div class="loading-dots">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    {{-- Hero Section --}}
    <section class="relative min-h-[600px] bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900 text-white overflow-hidden">
        {{-- Background Figures --}}
        <div class="hero-bg-left">
            <div class="hero-figure">
                <div class="hero-figure-image">
                    <img src="{{ asset('images/Bupati_Toba_Effendi_Sintong_Panangian_Napitupulu.png') }}"
                         alt="Bupati Toba"
                         class="w-full h-full object-cover">
                </div>
                <div class="hero-figure-name">Bupati Toba</div>
                <div class="hero-figure-title">Effendi Sintong Panangian Napitupulu</div>
            </div>
        </div>

        <div class="hero-bg-right">
            <div class="hero-figure">
                <div class="hero-figure-image">
                    <img src="{{ asset('images/Wakil_Bupati_Toba_Audi_Murphy_O._Sitorus.png') }}"
                         alt="Wakil Bupati Toba"
                         class="w-full h-full object-cover">
                </div>
                <div class="hero-figure-name">Wakil Bupati Toba</div>
                <div class="hero-figure-title">Audi Murphy O. Sitorus</div>
            </div>
        </div>

        {{-- Hero Content --}}
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center max-w-3xl mx-auto">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm text-sm font-medium mb-6 animate-fade-in-up">
                    <i class="fas fa-rocket"></i>
                    Platform Digital Terintegrasi
                </span>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-6 animate-fade-in-up" style="animation-delay: 0.1s;">
                    Urus Dokumen Kependudukan
                    <span class="block text-blue-200">Kini Lebih Mudah & Cepat</span>
                </h1>
                <p class="text-lg md:text-xl text-blue-100 mb-8 animate-fade-in-up" style="animation-delay: 0.2s;">
                    Layanan pendaftaran, pencatatan sipil, dan informasi kependudukan yang
                    modern, transparan, dan dapat diakses kapan saja, di mana saja.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-in-up" style="animation-delay: 0.3s;">
                    <a href="{{ route('layanan-mandiri') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-blue-700 rounded-xl font-semibold hover:bg-blue-50 transition-all hover:scale-105 shadow-lg">
                        <i class="fas fa-rocket"></i>
                        Layanan Mandiri
                    </a>
                    <a href="{{ route('statistik') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-blue-500/30 backdrop-blur-sm border-2 border-white/30 text-white rounded-xl font-semibold hover:bg-blue-500/50 transition-all hover:scale-105">
                        <i class="fas fa-chart-line"></i>
                        Lihat Statistik
                    </a>
                </div>
            </div>
        </div>

        {{-- Wave Divider --}}
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#f9fafb"/>
            </svg>
        </div>
    </section>

    {{-- Welcome Section --}}
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl p-8 md:p-12 text-white text-center reveal">
                <div class="text-4xl mb-4">👋</div>
                <h2 class="text-2xl md:text-3xl font-bold mb-3">Selamat Datang di Portal Disdukcapil</h2>
                <p class="text-blue-100 text-lg max-w-3xl mx-auto">
                    Kabupaten Toba berkomitmen memberikan pelayanan administrasi kependudukan
                    kelas dunia dengan memanfaatkan teknologi terkini untuk kenyamanan masyarakat.
                </p>
            </div>
        </div>
    </section>

    {{-- Profil Disdukcapil Section --}}
    <section id="profil" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 reveal">
                <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider">Tentang Kami</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2">Profil Disdukcapil</h2>
                <p class="text-gray-600 mt-3 max-w-2xl mx-auto">
                    Mengenal lebih dekat visi, misi, dan dedikasi kami dalam melayani masyarakat
                </p>
            </div>

            {{-- Horizontal Tabs Navigation --}}
            <div class="bg-white rounded-2xl shadow-lg p-2 mb-8 overflow-x-auto reveal">
                <div class="tabs flex gap-2 min-w-max justify-center">
                    <button onclick="switchTab(event, 'visi')" class="tab-btn active flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold whitespace-nowrap transition-all text-gray-600 hover:bg-gray-100">
                        <i class="fas fa-bullseye"></i>
                        Visi & Misi
                    </button>
                    <button onclick="switchTab(event, 'motto')" class="tab-btn flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold whitespace-nowrap transition-all text-gray-600 hover:bg-gray-100">
                        <i class="fas fa-quote-left"></i>
                        Motto & Nilai
                    </button>
                    <button onclick="switchTab(event, 'sejarah')" class="tab-btn flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold whitespace-nowrap transition-all text-gray-600 hover:bg-gray-100">
                        <i class="fas fa-history"></i>
                        Sejarah
                    </button>
                    <button onclick="switchTab(event, 'penghargaan')" class="tab-btn flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold whitespace-nowrap transition-all text-gray-600 hover:bg-gray-100">
                        <i class="fas fa-trophy"></i>
                        Penghargaan
                    </button>
                    <button onclick="switchTab(event, 'dasar-hukum')" class="tab-btn flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold whitespace-nowrap transition-all text-gray-600 hover:bg-gray-100">
                        <i class="fas fa-balance-scale"></i>
                        Dasar Hukum
                    </button>
                    <button onclick="switchTab(event, 'tugas-fungsi')" class="tab-btn flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold whitespace-nowrap transition-all text-gray-600 hover:bg-gray-100">
                        <i class="fas fa-tasks"></i>
                        Tugas & Fungsi
                    </button>
                </div>
            </div>

            {{-- Tab Content --}}
            <div class="tab-content reveal">
                {{-- Visi & Misi --}}
                <div id="visi" class="tab-panel active">
                    <div class="bg-white rounded-2xl shadow-lg p-8">
                        <div class="grid md:grid-cols-2 gap-8">
                            <div>
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-bullseye text-2xl text-blue-600"></i>
                                    </div>
                                    <h3 class="text-2xl font-bold text-gray-800">Visi</h3>
                                </div>
                                <p class="text-gray-700 text-lg leading-relaxed bg-blue-50 rounded-xl p-6 border-l-4 border-blue-500">
                                    "Terwujudnya masyarakat Kabupaten Toba yang tertib administrasi kependudukan dan layanan pencatatan sipil yang berkualitas"
                                </p>
                            </div>
                            <div>
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-12 h-12 bg-teal-100 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-rocket text-2xl text-teal-600"></i>
                                    </div>
                                    <h3 class="text-2xl font-bold text-gray-800">Misi</h3>
                                </div>
                                <ul class="space-y-3">
                                    <li class="flex items-start gap-3">
                                        <i class="fas fa-check-circle text-blue-600 mt-1"></i>
                                        <span class="text-gray-700">Meningkatkan kualitas pelayanan administrasi kependudukan</span>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <i class="fas fa-check-circle text-blue-600 mt-1"></i>
                                        <span class="text-gray-700">Mengembangkan sistem informasi administrasi kependudukan terpadu</span>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <i class="fas fa-check-circle text-blue-600 mt-1"></i>
                                        <span class="text-gray-700">Meningkatkan profesionalisme SDM aparatur</span>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <i class="fas fa-check-circle text-blue-600 mt-1"></i>
                                        <span class="text-gray-700">Mewujudkan pelayanan prima yang transparan dan akuntabel</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Motto & Nilai --}}
                <div id="motto" class="tab-panel">
                    <div class="bg-white rounded-2xl shadow-lg p-8">
                        <div class="text-center mb-8">
                            <div class="w-20 h-20 bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-quote-left text-3xl text-white"></i>
                            </div>
                            <h3 class="text-3xl font-bold text-gray-800 mb-2">Motto Pelayanan</h3>
                        </div>
                        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl p-8 text-white text-center mb-8">
                            <p class="text-2xl md:text-3xl font-bold">"CEPAT, TEPAT, DAN RAMAH"</p>
                        </div>
                        <h4 class="text-xl font-bold text-gray-800 mb-6 text-center">Nilai-Nilai Pelayanan</h4>
                        <div class="grid md:grid-cols-3 gap-6">
                            <div class="text-center p-6 bg-blue-50 rounded-xl">
                                <div class="w-14 h-14 bg-blue-600 rounded-xl flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-clock text-2xl text-white"></i>
                                </div>
                                <h5 class="font-bold text-gray-800 mb-2">Cepat</h5>
                                <p class="text-gray-600 text-sm">Pelayanan efisien dengan waktu proses yang optimal</p>
                            </div>
                            <div class="text-center p-6 bg-teal-50 rounded-xl">
                                <div class="w-14 h-14 bg-teal-500 rounded-xl flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-bullseye text-2xl text-white"></i>
                                </div>
                                <h5 class="font-bold text-gray-800 mb-2">Tepat</h5>
                                <p class="text-gray-600 text-sm">Hasil layanan akurat dan sesuai ketentuan peraturan</p>
                            </div>
                            <div class="text-center p-6 bg-purple-50 rounded-xl">
                                <div class="w-14 h-14 bg-purple-500 rounded-xl flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-heart text-2xl text-white"></i>
                                </div>
                                <h5 class="font-bold text-gray-800 mb-2">Ramah</h5>
                                <p class="text-gray-600 text-sm">Pelayanan dengan senyum dan sikap yang menyenangkan</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sejarah --}}
                <div id="sejarah" class="tab-panel">
                    <div class="bg-white rounded-2xl shadow-lg p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-history text-2xl text-amber-600"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800">Sejarah Disdukcapil</h3>
                        </div>
                        <div class="space-y-6">
                            <p class="text-gray-700 leading-relaxed">
                                Dinas Kependudukan dan Pencatatan Sipil (Disdukcapil) Kabupaten Toba merupakan unsur pelaksana urusan pemerintahan di bidang administrasi kependudukan dan pencatatan sipil.
                            </p>
                            <p class="text-gray-700 leading-relaxed">
                                Sejak berdirinya Kabupaten Toba, Disdukcapil terus berkomitmen untuk memberikan pelayanan terbaik bagi masyarakat dalam hal pengurusan dokumen kependudukan seperti KTP, Kartu Keluarga, Akta Kelahiran, dan dokumen lainnya.
                            </p>
                            <p class="text-gray-700 leading-relaxed">
                                Dengan perkembangan teknologi dan digitalisasi, Disdukcapil Kabupaten Toba kini telah mengimplementasikan berbagai sistem online untuk memudahkan masyarakat dalam mengurus dokumen kependudukan tanpa harus datang langsung ke kantor.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Penghargaan --}}
                <div id="penghargaan" class="tab-panel">
                    <div class="bg-white rounded-2xl shadow-lg p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-trophy text-2xl text-yellow-600"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800">Penghargaan</h3>
                        </div>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="flex gap-4 p-4 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-xl border-l-4 border-yellow-500">
                                <div class="w-12 h-12 bg-yellow-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-award text-xl text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800">Pelayanan Terbaik 2024</h4>
                                    <p class="text-gray-600 text-sm">Penghargaan tingkat Provinsi Sumatera Utara</p>
                                </div>
                            </div>
                            <div class="flex gap-4 p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl border-l-4 border-blue-500">
                                <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-digital-tachograph text-xl text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800">Digitalisasi Terbaik 2023</h4>
                                    <p class="text-gray-600 text-sm">Inovasi pelayanan online terintegrasi</p>
                                </div>
                            </div>
                            <div class="flex gap-4 p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border-l-4 border-green-500">
                                <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-users text-xl text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800">Satyalancana Karya Bhakti</h4>
                                    <p class="text-gray-600 text-sm">Penghargaan pelayanan publik prima</p>
                                </div>
                            </div>
                            <div class="flex gap-4 p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl border-l-4 border-purple-500">
                                <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-star text-xl text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800">Predikat WTP</h4>
                                    <p class="text-gray-600 text-sm">Opini tertinggi atas laporan keuangan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Dasar Hukum --}}
                <div id="dasar-hukum" class="tab-panel">
                    <div class="bg-white rounded-2xl shadow-lg p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-balance-scale text-2xl text-indigo-600"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800">Dasar Hukum</h3>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl hover:bg-blue-50 transition">
                                <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <span class="text-white font-bold text-sm">1</span>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Undang-Undang No. 24 Tahun 2013</h4>
                                    <p class="text-gray-600 text-sm">Tentang Perubahan atas Undang-Undang No. 23 Tahun 2006 tentang Administrasi Kependudukan</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl hover:bg-blue-50 transition">
                                <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <span class="text-white font-bold text-sm">2</span>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Peraturan Pemerintah No. 40 Tahun 2010</h4>
                                    <p class="text-gray-600 text-sm">Tentang Pelaksanaan Undang-Undang Nomor 23 Tahun 2006</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl hover:bg-blue-50 transition">
                                <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <span class="text-white font-bold text-sm">3</span>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Peraturan Daerah Kabupaten Toba</h4>
                                    <p class="text-gray-600 text-sm">Tentang Penyelenggaraan Administrasi Kependudukan di Kabupaten Toba</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tugas & Fungsi --}}
                <div id="tugas-fungsi" class="tab-panel">
                    <div class="bg-white rounded-2xl shadow-lg p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 bg-teal-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-tasks text-2xl text-teal-600"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800">Tugas & Fungsi</h3>
                        </div>
                        <div class="grid md:grid-cols-2 gap-8">
                            <div>
                                <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                    <i class="fas fa-clipboard-check text-blue-500"></i>
                                    Tugas Pokok
                                </h4>
                                <p class="text-gray-700 leading-relaxed bg-blue-50 rounded-xl p-6">
                                    Melaksanakan urusan pemerintahan daerah di bidang administrasi kependudukan dan pencatatan sipil yang menjadi kewenangan daerah dan tugas pembantuan yang ditugaskan kepada Daerah.
                                </p>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                    <i class="fas fa-cogs text-teal-500"></i>
                                    Fungsi
                                </h4>
                                <ul class="space-y-3">
                                    <li class="flex items-start gap-3">
                                        <i class="fas fa-chevron-right text-blue-500 mt-1"></i>
                                        <span class="text-gray-700">Perumusan kebijakan teknis di bidang administrasi kependudukan</span>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <i class="fas fa-chevron-right text-blue-500 mt-1"></i>
                                        <span class="text-gray-700">Penyelenggaraan pendaftaran penduduk dan pencatatan sipil</span>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <i class="fas fa-chevron-right text-blue-500 mt-1"></i>
                                        <span class="text-gray-700">Penerbitan dokumen kependudukan</span>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <i class="fas fa-chevron-right text-blue-500 mt-1"></i>
                                        <span class="text-gray-700">Pengelolaan sistem informasi administrasi kependudukan</span>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <i class="fas fa-chevron-right text-blue-500 mt-1"></i>
                                        <span class="text-gray-700">Pembinaan dan pengawasan di bidang administrasi kependudukan</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@push('styles')
<style>
    /* Hero Background */
    .hero-bg-left,
    .hero-bg-right {
        position: absolute;
        top: 60%;
        transform: translateY(-50%);
        width: 450px;
        height: 650px;
        z-index: 1;
        opacity: 0.25;
        pointer-events: none;
    }

    .hero-bg-left {
        left: -50px;
    }

    .hero-bg-right {
        right: -50px;
    }

    .hero-figure {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 0 20px;
    }

    .hero-figure-image {
        width: 280px;
        height: 380px;
        border-radius: 16px;
        overflow: hidden;
        filter: blur(0.3px);
        animation: figureFloat 6s ease-in-out infinite;
        box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.4);
        border: 4px solid rgba(255, 255, 255, 0.2);
    }

    .hero-figure-name {
        font-size: 1.1rem;
        font-weight: 700;
        color: rgba(255, 255, 255, 0.95);
        margin-top: 16px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        max-width: 100%;
        word-wrap: break-word;
    }

    .hero-figure-title {
        font-size: 0.85rem;
        color: rgba(255, 255, 255, 0.8);
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        max-width: 100%;
        word-wrap: break-word;
        line-height: 1.3;
    }

    .hero-bg-right .hero-figure-emoji {
        animation: figureFloat 6s ease-in-out infinite reverse;
    }

    @keyframes figureFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }
</style>
@endpush

@push('scripts')
<script>
    // Hide loading after page loads
    window.addEventListener('load', function() {
        const loading = document.getElementById('pageLoading');
        if (loading) {
            loading.classList.add('hidden');
        }
    });

    // Tab Switching
    function switchTab(event, tabId) {
        // Remove active class from all buttons and panels
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active', 'bg-blue-600', 'text-white');
            btn.classList.add('text-gray-600', 'hover:bg-gray-100');
        });
        document.querySelectorAll('.tab-panel').forEach(panel => {
            panel.classList.remove('active');
        });

        // Add active class to clicked button
        event.currentTarget.classList.add('active', 'bg-blue-600', 'text-white');
        event.currentTarget.classList.remove('text-gray-600', 'hover:bg-gray-100');

        // Show corresponding panel
        document.getElementById(tabId).classList.add('active');
    }

    // Initialize first tab as active
    document.addEventListener('DOMContentLoaded', () => {
        const firstTab = document.querySelector('.tab-btn');
        if (firstTab) {
            firstTab.classList.add('bg-blue-600', 'text-white');
            firstTab.classList.remove('text-gray-600', 'hover:bg-gray-100');
        }
    });
</script>
@endpush
