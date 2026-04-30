@extends('layouts.user')

@section('content')
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

        {{-- Hero Section --}}
        <section
            class="relative min-h-[600px] bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900 text-white overflow-hidden">
            {{-- Background Figures --}}
            <div class="hero-bg-left">
                <div class="hero-figure">
                    <div class="hero-figure-image">
                        <img src="{{ asset('images/Bupati_Toba_Effendi_Sintong_Panangian_Napitupulu.png') }}"
                            alt="Bupati Toba" class="w-full h-full object-cover">
                    </div>
                    <div class="hero-figure-name">Bupati Toba</div>
                    <div class="hero-figure-title">Effendi Sintong Panangian Napitupulu</div>
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

            {{-- Wave Divider --}}
            <div class="absolute bottom-0 left-0 right-0">
                <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z"
                        fill="#f9fafb" />
                </svg>
            </div>
        </section>
        {{-- Alur Pendaftaran Online Section (Revisi 6 Langkah) --}}
        <section id="alur-layanan" class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 reveal">
                    <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider">Panduan Masyarakat</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2">Alur Pendaftaran Online</h2>
                    <p class="text-gray-600 mt-3 max-w-2xl mx-auto">
                        Langkah-langkah mudah mengurus dokumen kependudukan melalui layanan mandiri Disdukcapil Kabupaten
                        Toba
                    </p>
                </div>

                <div class="relative reveal">
                    <div
                        class="hidden lg:block absolute top-[45px] left-[8%] right-[8%] h-1 bg-gradient-to-r from-blue-100 via-blue-400 to-blue-100 z-0">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-10 lg:gap-4 relative z-10">

                        <div class="flex flex-col items-center text-center group">
                            <div
                                class="w-24 h-24 bg-white rounded-full border-4 border-blue-50 shadow-lg flex items-center justify-center mb-6 relative group-hover:border-blue-500 transition-colors duration-300">
                                <div
                                    class="absolute -top-2 -right-2 w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 text-white font-bold rounded-full flex items-center justify-center border-2 border-white shadow-sm">
                                    1</div>
                                <i
                                    class="fas fa-ticket-alt text-3xl text-blue-600 group-hover:scale-110 transition-transform duration-300"></i>
                            </div>
                            <h3 class="font-bold text-gray-800 text-base mb-2">Ambil Antrean</h3>
                            <p class="text-xs text-gray-600 px-1 leading-relaxed">Dapatkan nomor antrean virtual Anda
                                sebelum memulai pengajuan.</p>
                        </div>

                        <div class="flex flex-col items-center text-center group">
                            <div
                                class="w-24 h-24 bg-white rounded-full border-4 border-blue-50 shadow-lg flex items-center justify-center mb-6 relative group-hover:border-teal-500 transition-colors duration-300">
                                <div
                                    class="absolute -top-2 -right-2 w-8 h-8 bg-gradient-to-br from-teal-500 to-teal-700 text-white font-bold rounded-full flex items-center justify-center border-2 border-white shadow-sm">
                                    2</div>
                                <i
                                    class="fas fa-mouse-pointer text-3xl text-teal-600 group-hover:scale-110 transition-transform duration-300"></i>
                            </div>
                            <h3 class="font-bold text-gray-800 text-base mb-2">Pilih Layanan</h3>
                            <p class="text-xs text-gray-600 px-1 leading-relaxed">Pilih jenis dokumen kependudukan yang
                                ingin Anda urus di portal.</p>
                        </div>

                        <div class="flex flex-col items-center text-center group">
                            <div
                                class="w-24 h-24 bg-white rounded-full border-4 border-blue-50 shadow-lg flex items-center justify-center mb-6 relative group-hover:border-amber-500 transition-colors duration-300">
                                <div
                                    class="absolute -top-2 -right-2 w-8 h-8 bg-gradient-to-br from-amber-500 to-amber-700 text-white font-bold rounded-full flex items-center justify-center border-2 border-white shadow-sm">
                                    3</div>
                                <i
                                    class="fas fa-file-upload text-3xl text-amber-600 group-hover:scale-110 transition-transform duration-300"></i>
                            </div>
                            <h3 class="font-bold text-gray-800 text-base mb-2">Unggah Berkas</h3>
                            <p class="text-xs text-gray-600 px-1 leading-relaxed">Isi formulir elektronik dan unggah
                                foto/scan dokumen persyaratan.</p>
                        </div>

                        <div class="flex flex-col items-center text-center group">
                            <div
                                class="w-24 h-24 bg-white rounded-full border-4 border-blue-50 shadow-lg flex items-center justify-center mb-6 relative group-hover:border-purple-500 transition-colors duration-300">
                                <div
                                    class="absolute -top-2 -right-2 w-8 h-8 bg-gradient-to-br from-purple-500 to-purple-700 text-white font-bold rounded-full flex items-center justify-center border-2 border-white shadow-sm">
                                    4</div>
                                <i
                                    class="fas fa-user-check text-3xl text-purple-600 group-hover:scale-110 transition-transform duration-300"></i>
                            </div>
                            <h3 class="font-bold text-gray-800 text-base mb-2">Verifikasi Admin</h3>
                            <p class="text-xs text-gray-600 px-1 leading-relaxed">Petugas kami akan memvalidasi kebenaran
                                dan kelengkapan data Anda.</p>
                        </div>

                        <div class="flex flex-col items-center text-center group">
                            <div
                                class="w-24 h-24 bg-white rounded-full border-4 border-blue-50 shadow-lg flex items-center justify-center mb-6 relative group-hover:border-indigo-500 transition-colors duration-300">
                                <div
                                    class="absolute -top-2 -right-2 w-8 h-8 bg-gradient-to-br from-indigo-500 to-indigo-700 text-white font-bold rounded-full flex items-center justify-center border-2 border-white shadow-sm">
                                    5</div>
                                <i
                                    class="fas fa-search text-3xl text-indigo-600 group-hover:scale-110 transition-transform duration-300"></i>
                            </div>
                            <h3 class="font-bold text-gray-800 text-base mb-2">Cek Status</h3>
                            <p class="text-xs text-gray-600 px-1 leading-relaxed">Pantau terus status pengajuan Anda secara
                                berkala menggunakan nomor antrean.</p>
                        </div>

                        <div class="flex flex-col items-center text-center group">
                            <div
                                class="w-24 h-24 bg-white rounded-full border-4 border-blue-50 shadow-lg flex items-center justify-center mb-6 relative group-hover:border-rose-500 transition-colors duration-300">
                                <div
                                    class="absolute -top-2 -right-2 w-8 h-8 bg-gradient-to-br from-rose-500 to-rose-700 text-white font-bold rounded-full flex items-center justify-center border-2 border-white shadow-sm">
                                    6</div>
                                <i
                                    class="fas fa-cloud-download-alt text-3xl text-rose-600 group-hover:scale-110 transition-transform duration-300"></i>
                            </div>
                            <h3 class="font-bold text-gray-800 text-base mb-2">Unduh Berkas</h3>
                            <p class="text-xs text-gray-600 px-1 leading-relaxed">
                                Berkas selesai dikirim ke nomor antrean. Segera unduh sebelum <span
                                    class="font-bold text-rose-600">batas waktu 1x24 jam</span>.
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        {{-- Welcome Section --}}
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div
                    class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl p-8 md:p-12 text-white text-center reveal">
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
                        <button onclick="switchTab(event, 'visi')"
                            class="tab-btn active flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold whitespace-nowrap transition-all text-gray-600 hover:bg-gray-100">
                            <i class="fas fa-bullseye"></i>
                            Visi & Misi
                        </button>
                        <button onclick="switchTab(event, 'motto')"
                            class="tab-btn flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold whitespace-nowrap transition-all text-gray-600 hover:bg-gray-100">
                            <i class="fas fa-quote-left"></i>
                            Motto & Nilai
                        </button>
                        <button onclick="switchTab(event, 'sejarah')"
                            class="tab-btn flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold whitespace-nowrap transition-all text-gray-600 hover:bg-gray-100">
                            <i class="fas fa-history"></i>
                            Sejarah
                        </button>
                        <button onclick="switchTab(event, 'penghargaan')"
                            class="tab-btn flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold whitespace-nowrap transition-all text-gray-600 hover:bg-gray-100">
                            <i class="fas fa-trophy"></i>
                            Penghargaan
                        </button>
                        <button onclick="switchTab(event, 'dasar-hukum')"
                            class="tab-btn flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold whitespace-nowrap transition-all text-gray-600 hover:bg-gray-100">
                            <i class="fas fa-balance-scale"></i>
                            Dasar Hukum
                        </button>
                        <button onclick="switchTab(event, 'tugas-fungsi')"
                            class="tab-btn flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold whitespace-nowrap transition-all text-gray-600 hover:bg-gray-100">
                            <i class="fas fa-tasks"></i>
                            Tugas & Fungsi
                        </button>
                        <button onclick="switchTab(event, 'struktur-organisasi')"
                            class="tab-btn flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold whitespace-nowrap transition-all text-gray-600 hover:bg-gray-100">
                            <i class="fas fa-sitemap"></i>
                            Struktur Organisasi
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
                                    <p
                                        class="text-gray-700 text-lg leading-relaxed bg-blue-50 rounded-xl p-6 border-l-4 border-blue-500">
                                        "Terwujudnya masyarakat Kabupaten Toba yang tertib administrasi kependudukan dan
                                        layanan pencatatan sipil yang berkualitas"
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
                                            <span class="text-gray-700">Meningkatkan kualitas pelayanan administrasi
                                                kependudukan</span>
                                        </li>
                                        <li class="flex items-start gap-3">
                                            <i class="fas fa-check-circle text-blue-600 mt-1"></i>
                                            <span class="text-gray-700">Mengembangkan sistem informasi administrasi
                                                kependudukan terpadu</span>
                                        </li>
                                        <li class="flex items-start gap-3">
                                            <i class="fas fa-check-circle text-blue-600 mt-1"></i>
                                            <span class="text-gray-700">Meningkatkan profesionalisme SDM aparatur</span>
                                        </li>
                                        <li class="flex items-start gap-3">
                                            <i class="fas fa-check-circle text-blue-600 mt-1"></i>
                                            <span class="text-gray-700">Mewujudkan pelayanan prima yang transparan dan
                                                akuntabel</span>
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
                                <div
                                    class="w-20 h-20 bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-quote-left text-3xl text-white"></i>
                                </div>
                                <h3 class="text-3xl font-bold text-gray-800 mb-2">Motto Pelayanan</h3>
                            </div>
                            <div
                                class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl p-8 text-white text-center mb-8">
                                <p class="text-2xl md:text-3xl font-bold">"CEPAT, TEPAT, DAN RAMAH"</p>
                            </div>
                            <h4 class="text-xl font-bold text-gray-800 mb-6 text-center">Nilai-Nilai Pelayanan</h4>
                            <div class="grid md:grid-cols-3 gap-6">
                                <div class="text-center p-6 bg-blue-50 rounded-xl">
                                    <div
                                        class="w-14 h-14 bg-blue-600 rounded-xl flex items-center justify-center mx-auto mb-3">
                                        <i class="fas fa-clock text-2xl text-white"></i>
                                    </div>
                                    <h5 class="font-bold text-gray-800 mb-2">Cepat</h5>
                                    <p class="text-gray-600 text-sm">Pelayanan efisien dengan waktu proses yang optimal</p>
                                </div>
                                <div class="text-center p-6 bg-teal-50 rounded-xl">
                                    <div
                                        class="w-14 h-14 bg-teal-500 rounded-xl flex items-center justify-center mx-auto mb-3">
                                        <i class="fas fa-bullseye text-2xl text-white"></i>
                                    </div>
                                    <h5 class="font-bold text-gray-800 mb-2">Tepat</h5>
                                    <p class="text-gray-600 text-sm">Hasil layanan akurat dan sesuai ketentuan peraturan
                                    </p>
                                </div>
                                <div class="text-center p-6 bg-purple-50 rounded-xl">
                                    <div
                                        class="w-14 h-14 bg-purple-500 rounded-xl flex items-center justify-center mx-auto mb-3">
                                        <i class="fas fa-heart text-2xl text-white"></i>
                                    </div>
                                    <h5 class="font-bold text-gray-800 mb-2">Ramah</h5>
                                    <p class="text-gray-600 text-sm">Pelayanan dengan senyum dan sikap yang menyenangkan
                                    </p>
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
                                    Dinas Kependudukan dan Pencatatan Sipil (Disdukcapil) Kabupaten Toba merupakan unsur
                                    pelaksana urusan pemerintahan di bidang administrasi kependudukan dan pencatatan sipil.
                                </p>
                                <p class="text-gray-700 leading-relaxed">
                                    Sejak berdirinya Kabupaten Toba, Disdukcapil terus berkomitmen untuk memberikan
                                    pelayanan terbaik bagi masyarakat dalam hal pengurusan dokumen kependudukan seperti KTP,
                                    Kartu Keluarga, Akta Kelahiran, dan dokumen lainnya.
                                </p>
                                <p class="text-gray-700 leading-relaxed">
                                    Dengan perkembangan teknologi dan digitalisasi, Disdukcapil Kabupaten Toba kini telah
                                    mengimplementasikan berbagai sistem online untuk memudahkan masyarakat dalam mengurus
                                    dokumen kependudukan tanpa harus datang langsung ke kantor.
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
                                <div
                                    class="flex gap-4 p-4 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-xl border-l-4 border-yellow-500">
                                    <div
                                        class="w-12 h-12 bg-yellow-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-award text-xl text-white"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-800">Pelayanan Terbaik 2024</h4>
                                        <p class="text-gray-600 text-sm">Penghargaan tingkat Provinsi Sumatera Utara</p>
                                    </div>
                                </div>
                                <div
                                    class="flex gap-4 p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl border-l-4 border-blue-500">
                                    <div
                                        class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-digital-tachograph text-xl text-white"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-800">Digitalisasi Terbaik 2023</h4>
                                        <p class="text-gray-600 text-sm">Inovasi pelayanan online terintegrasi</p>
                                    </div>
                                </div>
                                <div
                                    class="flex gap-4 p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border-l-4 border-green-500">
                                    <div
                                        class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-users text-xl text-white"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-800">Satyalancana Karya Bhakti</h4>
                                        <p class="text-gray-600 text-sm">Penghargaan pelayanan publik prima</p>
                                    </div>
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
                <div id="penghargaan" class="tab-panel hidden">
                        <div class="bg-white rounded-2xl shadow-lg p-8">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-trophy text-2xl text-yellow-600"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-800">Penghargaan</h3>
                            </div>
                            @if(isset($penghargaan) && $penghargaan->count() > 0)
                                <div class="grid md:grid-cols-2 gap-4">
                                    @foreach($penghargaan as $item)
                                        @php
                                            $colors = [
                                                'Nasional'  => ['border' => 'border-yellow-500', 'bg' => 'from-yellow-50 to-amber-50',  'icon_bg' => 'bg-yellow-500',  'badge' => 'bg-red-100 text-red-700'],
                                                'Provinsi'  => ['border' => 'border-blue-500',   'bg' => 'from-blue-50 to-cyan-50',     'icon_bg' => 'bg-blue-500',    'badge' => 'bg-blue-100 text-blue-700'],
                                                'Kabupaten' => ['border' => 'border-green-500',  'bg' => 'from-green-50 to-emerald-50', 'icon_bg' => 'bg-green-500',   'badge' => 'bg-green-100 text-green-700'],
                                            ];
                                            $c = $colors[$item->tingkat] ?? ['border' => 'border-gray-300', 'bg' => 'from-gray-50 to-gray-100', 'icon_bg' => 'bg-gray-400', 'badge' => 'bg-gray-100 text-gray-600'];
                                        @endphp
                                        <div class="flex gap-4 p-4 bg-gradient-to-r {{ $c['bg'] }} rounded-xl border-l-4 {{ $c['border'] }}">
                                            <div class="w-12 h-12 {{ $c['icon_bg'] }} rounded-xl flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-award text-xl text-white"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-start justify-between gap-2">
                                                    <h4 class="font-bold text-gray-800 text-sm leading-snug">{{ $item->nama }}</h4>
                                                    <span class="px-2 py-0.5 {{ $c['badge'] }} rounded-full text-xs font-semibold flex-shrink-0">{{ $item->tingkat }}</span>
                                                </div>
                                                <p class="text-gray-600 text-xs mt-1">{{ $item->instansi }}</p>
                                                @if($item->tahun || $item->lokasi)
                                                    <div class="flex items-center gap-3 mt-1.5 text-xs text-gray-400">
                                                        @if($item->tahun)<span><i class="fas fa-calendar mr-1"></i>{{ $item->tahun }}</span>@endif
                                                        @if($item->lokasi)<span><i class="fas fa-map-marker-alt mr-1"></i>{{ $item->lokasi }}</span>@endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-trophy text-gray-300 text-2xl"></i>
                                    </div>
                                    <p class="text-gray-500 text-sm">Belum ada data penghargaan.</p>
                                </div>
                            @endif
                        </div>
                    </div>
 
                    {{-- Dasar Hukum --}}
                    <div id="dasar-hukum" class="tab-panel hidden">
                        <div class="bg-white rounded-2xl shadow-lg p-8">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-balance-scale text-2xl text-indigo-600"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-800">Dasar Hukum</h3>
                            </div>
                            @if(isset($dasarHukum) && $dasarHukum->count() > 0)
                                <div class="space-y-4">
                                    @foreach($dasarHukum as $index => $item)
                                        <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl hover:bg-blue-50 transition group">
                                            <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <span class="text-white font-bold text-sm">{{ $loop->iteration }}</span>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h4 class="font-semibold text-gray-800">{{ $item->nama }}</h4>
                                                <p class="text-gray-600 text-sm mt-1">{{ $item->deskripsi_singkat }}</p>
                                            </div>
                                            @if($item->file)
                                                <a href="{{ asset('storage/' . $item->file) }}" target="_blank" rel="noopener"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded-lg hover:bg-blue-700 transition">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </a>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-balance-scale text-gray-300 text-2xl"></i>
                                    </div>
                                    <p class="text-gray-500 text-sm">Belum ada data dasar hukum.</p>
                                </div>
                            @endif
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
                                        Melaksanakan urusan pemerintahan daerah di bidang administrasi kependudukan dan
                                        pencatatan sipil yang menjadi kewenangan daerah dan tugas pembantuan yang ditugaskan
                                        kepada Daerah.
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
                                            <span class="text-gray-700">Perumusan kebijakan teknis di bidang administrasi
                                                kependudukan</span>
                                        </li>
                                        <li class="flex items-start gap-3">
                                            <i class="fas fa-chevron-right text-blue-500 mt-1"></i>
                                            <span class="text-gray-700">Penyelenggaraan pendaftaran penduduk dan pencatatan
                                                sipil</span>
                                        </li>
                                        <li class="flex items-start gap-3">
                                            <i class="fas fa-chevron-right text-blue-500 mt-1"></i>
                                            <span class="text-gray-700">Penerbitan dokumen kependudukan</span>
                                        </li>
                                        <li class="flex items-start gap-3">
                                            <i class="fas fa-chevron-right text-blue-500 mt-1"></i>
                                            <span class="text-gray-700">Pengelolaan sistem informasi administrasi
                                                kependudukan</span>
                                        </li>
                                        <li class="flex items-start gap-3">
                                            <i class="fas fa-chevron-right text-blue-500 mt-1"></i>
                                            <span class="text-gray-700">Pembinaan dan pengawasan di bidang administrasi
                                                kependudukan</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- STRUKTUR ORGANISASI --}}
                    {{-- STRUKTUR ORGANISASI (UI DIPERBARUI) --}}
                    <div id="struktur-organisasi" class="tab-panel">
                        <div class="bg-white rounded-3xl shadow-xl p-6 md:p-8 lg:p-12">
                            <div class="text-center mb-12">
                                <div
                                    class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-2xl mb-4">
                                    <i class="fas fa-sitemap text-3xl text-blue-600"></i>
                                </div>
                                <h3 class="text-3xl md:text-4xl font-extrabold text-gray-800">Bagan Struktur Organisasi
                                </h3>
                                <p class="text-gray-500 mt-3 font-medium">Dinas Kependudukan dan Pencatatan Sipil Kabupaten
                                    Toba</p>
                            </div>

                            <div class="flex flex-col items-center w-full max-w-5xl mx-auto">

                                <div class="relative z-10 flex flex-col items-center">
                                    <div
                                        class="w-64 bg-gradient-to-b from-blue-700 to-blue-900 rounded-2xl p-6 text-center text-white shadow-xl ring-4 ring-blue-50 transform transition hover:-translate-y-1">
                                        <div
                                            class="w-20 h-20 bg-white/10 backdrop-blur-sm rounded-full mx-auto mb-4 flex items-center justify-center border-2 border-white/20">
                                            <i class="fas fa-user-tie text-4xl text-white"></i>
                                        </div>
                                        <h3 class="font-bold text-lg leading-tight mb-1">
                                            {{ isset($struktur['kadis']) && $struktur['kadis']->nama_pejabat ? $struktur['kadis']->nama_pejabat : 'Belum Diisi' }}
                                        </h3>
                                        <p class="text-blue-200 text-sm font-medium tracking-wide">
                                            {{ isset($struktur['kadis']) ? $struktur['kadis']->nama_jabatan : 'Kepala Dinas' }}
                                        </p>
                                    </div>
                                    <div class="w-1 h-10 bg-blue-200"></div>
                                </div>

                                <div class="relative z-10 flex flex-col items-center">
                                    <div
                                        class="w-64 bg-gradient-to-b from-blue-500 to-blue-600 rounded-2xl p-6 text-center text-white shadow-lg ring-4 ring-blue-50 transform transition hover:-translate-y-1">
                                        <div
                                            class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full mx-auto mb-3 flex items-center justify-center border-2 border-white/30">
                                            <i class="fas fa-user text-2xl text-white"></i>
                                        </div>
                                        <h3 class="font-bold leading-tight mb-1">
                                            {{ isset($struktur['sekdin']) && $struktur['sekdin']->nama_pejabat ? $struktur['sekdin']->nama_pejabat : 'Belum Diisi' }}
                                        </h3>
                                        <p class="text-blue-100 text-sm font-medium">
                                            {{ isset($struktur['sekdin']) ? $struktur['sekdin']->nama_jabatan : 'Sekretaris' }}
                                        </p>
                                    </div>
                                    <div class="w-1 h-10 lg:h-12 bg-blue-200"></div>
                                </div>

                                <div class="relative w-full">
                                    <div class="hidden lg:block absolute top-0 left-[12.5%] right-[12.5%] h-1 bg-blue-200">
                                    </div>

                                    <div
                                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 pt-0 lg:pt-8">
                                        @php
                                            $bidangUser = [
                                                'kabid_piak' => [
                                                    'bg' => 'bg-blue-50',
                                                    'text' => 'text-blue-600',
                                                    'ring' => 'hover:ring-blue-400',
                                                    'border' => 'border-blue-100',
                                                    'icon' => 'fa-id-card',
                                                    'desc' => 'Pengelolaan Informasi',
                                                    'def' => 'Bidang PIAK',
                                                ],
                                                'kabid_dafduk' => [
                                                    'bg' => 'bg-emerald-50',
                                                    'text' => 'text-emerald-600',
                                                    'ring' => 'hover:ring-emerald-400',
                                                    'border' => 'border-emerald-100',
                                                    'icon' => 'fa-users',
                                                    'desc' => 'Pendaftaran Penduduk',
                                                    'def' => 'Bidang Dafduk',
                                                ],
                                                'kabid_pencatatan' => [
                                                    'bg' => 'bg-purple-50',
                                                    'text' => 'text-purple-600',
                                                    'ring' => 'hover:ring-purple-400',
                                                    'border' => 'border-purple-100',
                                                    'icon' => 'fa-file-alt',
                                                    'desc' => 'Pencatatan Sipil',
                                                    'def' => 'Bidang Pencatatan',
                                                ],
                                                'kabid_psda' => [
                                                    'bg' => 'bg-orange-50',
                                                    'text' => 'text-orange-600',
                                                    'ring' => 'hover:ring-orange-400',
                                                    'border' => 'border-orange-100',
                                                    'icon' => 'fa-cogs',
                                                    'desc' => 'Sistem & Dokumen',
                                                    'def' => 'Bidang PSDA',
                                                ],
                                            ];
                                        @endphp

                                        @foreach ($bidangUser as $key => $data)
                                            <div class="relative flex flex-col items-center">
                                                <div
                                                    class="hidden lg:block absolute -top-8 left-1/2 w-1 h-8 bg-blue-200 -translate-x-1/2">
                                                </div>

                                                <div class="block lg:hidden w-1 h-6 bg-blue-200 -mt-6 mb-2"></div>

                                                <div
                                                    class="w-full h-full bg-white border {{ $data['border'] }} rounded-2xl p-6 text-center shadow-sm hover:shadow-xl transition-all transform hover:-translate-y-1 ring-2 ring-transparent {{ $data['ring'] }} group cursor-default">
                                                    <div
                                                        class="w-14 h-14 {{ $data['bg'] }} rounded-2xl mx-auto mb-4 flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                                                        <i
                                                            class="fas {{ $data['icon'] }} text-2xl {{ $data['text'] }}"></i>
                                                    </div>
                                                    <h4
                                                        class="font-bold text-gray-800 text-sm mb-2 h-10 flex items-center justify-center">
                                                        {{ isset($struktur[$key]) ? $struktur[$key]->nama_jabatan : $data['def'] }}
                                                    </h4>

                                                    <div class="mt-4 pt-4 border-t border-gray-100">
                                                        <p
                                                            class="text-[11px] text-gray-400 uppercase tracking-wider font-semibold mb-1">
                                                            Kepala Bidang</p>
                                                        <p class="text-sm {{ $data['text'] }} font-bold">
                                                            {{ isset($struktur[$key]) && $struktur[$key]->nama_pejabat ? $struktur[$key]->nama_pejabat : 'Belum Diisi' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Berita & Pengumuman --}}
    <section id="berita" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 reveal">
                <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider">Kabar Terkini</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2">Berita & Pengumuman</h2>
                <p class="text-gray-600 mt-3 max-w-2xl mx-auto">
                    Informasi terbaru seputar layanan dan kegiatan Disdukcapil Kabupaten Toba
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 reveal">
                @forelse ($beritas as $item)
                    <div class="news-card-large bg-white rounded-2xl shadow-lg overflow-hidden cursor-pointer hover:shadow-2xl transition-all duration-300 hover:-translate-y-2"
                         role="button"
                         tabindex="0"
                         onclick="openNewsModal({{ $item->id }})"
                         onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();openNewsModal({{ $item->id }});}">
                        <div class="p-6">
                            <div class="flex items-start justify-between gap-3 mb-4">
                                <span class="px-3 py-1 berita-badge rounded-full text-xs font-semibold whitespace-nowrap max-w-[65%] truncate">
                                    {{ $item->judul }}
                                </span>
                                <span class="text-gray-500 text-sm whitespace-nowrap">
                                    {{ ($item->published_at ?? $item->created_at)->locale('id')->translatedFormat('d M Y') }}
                                </span>
                            </div>

                            <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-2">{{ $item->judul }}</h3>
                            <p class="text-gray-600 text-sm mb-5 line-clamp-4">
                                {{ \Illuminate\Support\Str::limit(trim(strip_tags($item->konten)), 160) }}
                            </p>

                            <span class="inline-flex items-center gap-2 text-blue-600 font-semibold text-sm hover:gap-3 transition-all">
                                Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="md:col-span-3 text-center text-gray-500 py-12 text-lg">
                        Belum ada berita yang dipublikasikan. Silakan cek kembali nanti.
                    </p>
                @endforelse
            </div>
        </div>
    </section>
</main>

    {{-- Modal baca berita --}}
    <div class="news-modal-overlay" id="newsModalOverlay" onclick="closeNewsModal()">
        <div class="news-modal" onclick="event.stopPropagation()">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between gap-4">
                <span class="px-4 py-2 berita-badge rounded-full text-sm font-semibold shrink-0 max-w-[60%] truncate" id="modalCategory">Kategori</span>
                <button type="button" onclick="closeNewsModal()" class="w-10 h-10 hover:bg-gray-100 rounded-lg flex items-center justify-center transition shrink-0" aria-label="Tutup">
                    <i class="fas fa-times text-gray-500"></i>
                </button>
            </div>
            <div class="p-8">
                <span class="text-gray-500 text-sm" id="modalDate">Tanggal</span>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mt-2 mb-6" id="modalTitle">Judul Berita</h2>
                <div class="prose max-w-none text-gray-700" id="modalContent"></div>
            </div>
        </div>
    </div>
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

    /* News modal (beranda) */
    .news-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(8px);
        z-index: 10000;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .news-modal-overlay.active {
        display: flex;
    }

    .news-modal {
        background: white;
        border-radius: 24px;
        max-width: 800px;
        max-height: 90vh;
        overflow-y: auto;
        width: 100%;
        animation: modalSlideUp 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    @keyframes modalSlideUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .berita-badge {
        background: #FEF7E0;
        color: #B06000;
    }
</style>
@endpush

@push('scripts')
<script>
    const newsData = @json($newsForModal);

    // Hide loading after page loads
    window.addEventListener('load', function() {
        const loading = document.getElementById('pageLoading');
        if (loading) {
            loading.classList.add('hidden');
        }
    });

    function openNewsModal(newsId) {
        const overlay = document.getElementById('newsModalOverlay');
        if (!overlay) return;
        const news = newsData[String(newsId)] || newsData[newsId];
        if (!news) return;

        document.getElementById('modalCategory').textContent = news.category;
        document.getElementById('modalDate').textContent = news.date;
        document.getElementById('modalTitle').textContent = news.title;
        document.getElementById('modalContent').innerHTML = news.content;

        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeNewsModal() {
        const overlay = document.getElementById('newsModalOverlay');
        if (!overlay) return;
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeNewsModal();
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
            panel.classList.add('hidden');
            panel.classList.remove('active');
        });
        document.getElementById(tabId).classList.remove('hidden');
        document.getElementById(tabId).classList.add('active');

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
