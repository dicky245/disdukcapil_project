@extends('components.layouts-layanan')
@section('content')
<main class="pt-16">
        <!-- Hero Section -->
        <section class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-cyan-800 text-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm text-sm font-medium mb-6">
                        <i class="fas fa-rocket"></i>
                        Layanan Mandiri
                    </div>
                    <h1 class="text-4xl md:text-5xl font-extrabold mb-6">
                        Urus Dokumen dari Rumah
                    </h1>
                    <p class="text-lg text-blue-100 mb-8">
                        Ajukan dan pantau dokumen kependudukan Anda secara online tanpa harus antri di kantor
                    </p>
                </div>
            </div>

            <!-- Wave Divider -->
            <div class="absolute bottom-0 left-0 right-0">
                <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#f9fafb"/>
                </svg>
            </div>
        </section>

        <!-- Stepper Progress -->
        <section class="py-12 bg-gray-50 -mt-8 relative z-10">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-2xl shadow-lg p-8 reveal">
                    <h3 class="text-center text-gray-700 font-semibold mb-8">Tahapan Pengajuan Dokumen</h3>
                    <div class="relative">
                        <div class="stepper-line">
                            <div class="stepper-line-fill" id="stepperFill" style="width: 0%;"></div>
                        </div>
                        <div class="flex justify-between relative">
                            <div class="text-center flex-1 stepper-item" data-step="1">
                                <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-2 relative z-10 shadow-lg">
                                    <i class="fas fa-ticket-alt text-white"></i>
                                </div>
                                <p class="text-sm font-semibold text-blue-600">Antrian Online</p>
                            </div>
                            <div class="text-center flex-1 stepper-item" data-step="2">
                                <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-2 relative z-10">
                                    <i class="fas fa-file-alt text-gray-400"></i>
                                </div>
                                <p class="text-sm font-medium text-gray-500">Pilih Layanan</p>
                            </div>
                            <div class="text-center flex-1 stepper-item" data-step="3">
                                <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-2 relative z-10">
                                    <i class="fas fa-upload text-gray-400"></i>
                                </div>
                                <p class="text-sm font-medium text-gray-500">Upload Dokumen</p>
                            </div>
                            <div class="text-center flex-1 stepper-item" data-step="4">
                                <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-2 relative z-10">
                                    <i class="fas fa-flag-checkered text-gray-400"></i>
                                </div>
                                <p class="text-sm font-medium text-gray-500">Selesai</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Grid -->
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12 reveal">
                    <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider">Pilih Layanan</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2">Jenis Layanan</h2>
                    <p class="text-gray-600 mt-3 max-w-2xl mx-auto">
                        Pilih jenis layanan yang Anda butuhkan
                    </p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 reveal">

                    <button onclick="selectService('kk')" class="service-btn group bg-white border-2 border-gray-100 rounded-2xl p-6 text-center hover:border-purple-500 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                        <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-500 transition-colors">
                            <i class="fas fa-address-card text-3xl text-purple-600 group-hover:text-white transition-colors"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-1">Kartu Keluarga</h3>
                        <p class="text-sm text-gray-500">KK Baru atau Pembaruan</p>
                    </button>
<!-- 
                    <button onclick="selectService('akta-lahir')" class="service-btn group bg-white border-2 border-gray-100 rounded-2xl p-6 text-center hover:border-blue-500 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                        <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-500 transition-colors">
                            <i class="fas fa-scroll text-3xl text-blue-600 group-hover:text-white transition-colors"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-1">Akta Kelahiran</h3>
                        <p class="text-sm text-gray-500">Akta Lahir Baru</p>
                    </button>

                    <button onclick="selectService('akta-kematian')" class="service-btn group bg-white border-2 border-gray-100 rounded-2xl p-6 text-center hover:border-orange-500 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                        <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-orange-500 transition-colors">
                            <i class="fas fa-user-times text-3xl text-orange-600 group-hover:text-white transition-colors"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-1">Akta Kematian</h3>
                        <p class="text-sm text-gray-500">Pelaporan Kematian</p>
                    </button>

                    <button onclick="selectService('Lahir Mati')" class="service-btn group bg-white border-2 border-gray-100 rounded-2xl p-6 text-center hover:border-teal-500 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                        <div class="w-16 h-16 bg-teal-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-teal-500 transition-colors">
                            <i class="fas fa-passport text-3xl text-teal-600 group-hover:text-white transition-colors"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-1">Akta Lahir</h3>
                        <p class="text-sm text-gray-500">Akta Lahir Mati</p>
                    </button>

                    <button onclick="selectService('kawin')" class="service-btn group bg-white border-2 border-gray-100 rounded-2xl p-6 text-center hover:border-pink-500 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                        <div class="w-16 h-16 bg-pink-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-pink-500 transition-colors">
                            <i class="fas fa-ring text-3xl text-pink-600 group-hover:text-white transition-colors"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-1">Akta Perkawinan</h3>
                        <p class="text-sm text-gray-500">Pencatatan Nikah</p>
                    </button> -->
                </div>
            </div>
        </section>
        <!-- Modal Form -->
        <div id="serviceModal" class="modal">
            <div class="modal-content">
                <div class="flex items-center justify-between p-6 border-b">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800" id="modalTitle">Form Pengajuan</h3>
                        <p class="text-sm text-gray-500" id="modalSubtitle">Lengkapi data di bawah ini</p>
                    </div>
                    <button onclick="closeModal()" class="p-2 hover:bg-gray-100 rounded-lg transition">
                        <i class="fas fa-times text-gray-600"></i>
                    </button>
                </div>

                <form id="applicationForm" class="p-6 space-y-5" action="{{ route('kk.simpan') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- NIK -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nomor Induk Kependudukan (NIK)
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nik" required
                            placeholder="Masukkan 16 digit NIK"
                            maxlength="16"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm">
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-info-circle mr-1"></i>
                            Pastikan NIK sesuai dengan Kartu Keluarga (16 digit angka)
                        </p>
                    </div>

                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Lengkap
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama" required
                            placeholder="Masukkan nama lengkap sesuai KTP"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm">
                    </div>

                    <!-- Nomor WhatsApp -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nomor WhatsApp
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" id="whatsapp" required
                            placeholder="08xxxxxxxxxx"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm">
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-info-circle mr-1"></i>
                            Untuk notifikasi status pengajuan
                        </p>
                    </div>

                    <!-- Upload KTP -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Upload Foto KTP/KK
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 transition cursor-pointer" id="uploadArea">
                            <input type="file" id="fileKtp" accept="image/*,.pdf" class="hidden">
                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                            <p class="text-gray-600 text-sm">Klik untuk upload atau drag & drop</p>
                            <p class="text-xs text-gray-400">Format: JPG, PNG, PDF (Max. 5MB)</p>
                        </div>
                    </div>

                    <!-- Upload Selfie -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Upload Foto Selfie dengan KTP
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 transition cursor-pointer" id="uploadSelfie">
                            <input type="file" id="fileSelfie" accept="image/*" class="hidden">
                            <i class="fas fa-camera text-3xl text-gray-400 mb-2"></i>
                            <p class="text-gray-600 text-sm">Klik untuk upload atau drag & drop</p>
                            <p class="text-xs text-gray-400">Format: JPG, PNG (Max. 5MB)</p>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex gap-3 pt-2">
                        <button type="button" onclick="closeModal()" class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition text-sm">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition flex items-center justify-center gap-2 text-sm">
                            <i class="fas fa-paper-plane"></i>
                            Kirim Pengajuan
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Status Tracking -->
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12 reveal">
                    <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider">Cek Status</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2">Lacak Pengajuan</h2>
                    <p class="text-gray-600 mt-3 max-w-2xl mx-auto">
                        Masukkan nomor tiket untuk melihat status pengajuan Anda
                    </p>
                </div>

                <div class="max-w-2xl mx-auto reveal">
                    <div class="bg-white rounded-2xl shadow-lg p-8">
                        <form id="trackingForm" class="flex gap-4">
                            <input type="text" id="ticketNumber" required
                                   placeholder="Masukkan nomor tiket (contoh: Tiket-20250226-001)"
                                   class="flex-1 px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                            <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition flex items-center gap-2">
                                <i class="fas fa-search"></i>
                                Lacak
                            </button>
                        </form>

                        <div id="trackingResult" class="hidden mt-6">
                            <div class="border-t pt-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Nomor Tiket</p>
                                        <p class="font-bold text-gray-800" id="resultTicket">Tiket-20250226-001</p>
                                    </div>
                                    <span id="resultStatus" class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-full text-sm font-semibold">
                                        <i class="fas fa-clock mr-1"></i>
                                        Menunggu Verifikasi
                                    </span>
                                </div>

                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-500">Jenis Layanan</p>
                                        <p class="font-semibold text-gray-800" id="resultService">KTP Elektronik</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Tanggal Pengajuan</p>
                                        <p class="font-semibold text-gray-800" id="resultDate">26 Februari 2025</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Nama Pemohon</p>
                                        <p class="font-semibold text-gray-800" id="resultName">John Doe</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Estimasi Selesai</p>
                                        <p class="font-semibold text-gray-800" id="resultEstimate">2-3 Hari Kerja</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Help Section -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-3 gap-8 reveal">
                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-phone-alt text-3xl text-blue-600"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-2">Hubungi Kami</h3>
                        <p class="text-gray-600">(0632) 123456</p>
                    </div>
                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="fab fa-whatsapp text-3xl text-blue-600"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-2">WhatsApp</h3>
                        <p class="text-gray-600">0812-3456-7890</p>
                    </div>
                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-envelope text-3xl text-purple-600"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-2">Email</h3>
                        <p class="text-gray-600">info@disdukcapil-toba.go.id</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection