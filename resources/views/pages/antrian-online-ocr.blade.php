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
                    Antrian Online dengan OCR KTP
                </div>
                <h1 class="text-4xl md:text-5xl font-extrabold mb-6">
                    Ambil Nomor Antrian dengan Mudah
                </h1>
                <p class="text-lg text-blue-100 mb-8">
                    Upload KTP Anda dan biarkan sistem mengisi data secara otomatis. Tidak perlu mengetik manual!
                </p>
            </div>
        </div>

        <!-- Decorative Elements -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
    </section>

    {{-- OCR KTP Upload Section --}}
    <section class="py-16 bg-gradient-to-br from-purple-50 to-blue-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2">Upload KTP Anda</h2>
                <p class="text-gray-600 mt-3">
                    Upload foto KTP Anda dan sistem akan otomatis mengekstrak data. Pastikan foto jelas dan terbaca dengan baik.
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-8">
                {{-- Upload Area --}}
                <div id="uploadArea" class="border-3 border-dashed border-gray-300 rounded-xl p-8 text-center cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-all">
                    <div id="uploadContent">
                        <div class="mb-4">
                            <i class="fas fa-cloud-upload-alt text-6xl text-gray-400"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">Klik atau Drag & Drop KTP</h3>
                        <p class="text-gray-500 text-sm mb-4">Format: PNG, JPG, JPEG (Max 5MB)</p>
                        <div class="flex items-center justify-center gap-2 text-sm text-gray-400">
                            <i class="fas fa-lock"></i>
                            Data Anda aman dan tidak disimpan
                        </div>
                    </div>
                    <input type="file" id="ktpInput" accept="image/png,image/jpeg,image/jpg" class="hidden">
                </div>

                {{-- Preview Image --}}
                <div id="previewContainer" class="hidden mt-6">
                    <div class="flex items-start gap-4">
                        <div class="flex-1">
                            <img id="previewImage" src="" alt="Preview KTP" class="w-full max-h-64 object-contain rounded-lg border-2 border-gray-200">
                        </div>
                        <div class="flex-shrink-0">
                            <button id="removeImage" class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Scan Button --}}
                <button id="scanKtpBtn" class="hidden w-full mt-6 py-4 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-xl font-bold hover:from-purple-700 hover:to-blue-700 transition-all shadow-lg">
                    <i class="fas fa-magic mr-2"></i>
                    Scan KTP - Ekstrak Data Otomatis
                </button>

                {{-- Loading State --}}
                <div id="ocrLoading" class="hidden mt-6 text-center">
                    <div class="inline-flex items-center gap-3 px-6 py-3 bg-blue-100 text-blue-700 rounded-xl">
                        <svg class="animate-spin h-5 w-5 text-blue-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="font-semibold">Sedang memproses KTP...</span>
                    </div>
                </div>

                {{-- OCR Result --}}
                <div id="ocrResult" class="hidden mt-6 p-6 bg-gradient-to-r from-green-50 to-blue-50 rounded-xl border-2 border-green-200">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-green-500 text-white rounded-full flex items-center justify-center">
                            <i class="fas fa-check"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">Data Berhasil Diekstrak!</h4>
                            <p class="text-sm text-gray-600">Data telah diisi otomatis ke form. Silakan review dan koreksi jika diperlukan.</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg p-4 text-sm">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-gray-500 text-xs">Nama</p>
                                <p id="ocrNama" class="font-semibold text-gray-800">-</p>
                            </div>
                            <div>
                                <p class="text-gray-500 text-xs">Tanggal Lahir</p>
                                <p id="ocrTanggal" class="font-semibold text-gray-800">-</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-gray-500 text-xs">Alamat</p>
                                <p id="ocrAlamat" class="font-semibold text-gray-800">-</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- OCR Error --}}
                <div id="ocrError" class="hidden mt-6 p-6 bg-red-50 rounded-xl border-2 border-red-200">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-red-500 text-white rounded-full flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">Gagal Mengekstrak Data</h4>
                            <p id="ocrErrorMessage" class="text-sm text-gray-600">Pastikan foto KTP jelas dan coba lagi.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Booking Form Section --}}
    <section class="py-16 bg-gray-50" id="formSection">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2">Lengkapi Data Diri</h2>
                <p class="text-gray-600 mt-3 max-w-2xl mx-auto">
                    Review data yang diekstrak dari KTP atau lengkapi secara manual
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
                               placeholder="Masukkan nama lengkap sesuai identitas"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-base">
                        <p id="namaError" class="text-red-500 text-sm mt-2 hidden">Masukkan nama lengkap</p>
                    </div>

                    {{-- Alamat --}}
                    <div>
                        <label class="block text-lg font-semibold text-gray-700 mb-2">
                            Alamat <span class="text-gray-400 text-sm"></span>
                        </label>
                        <textarea name="alamat" id="alamat" rows="3"
                                  placeholder="Masukkan alamat lengkap"
                                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-base resize-none"></textarea>
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div>
                        <label class="block text-lg font-semibold text-gray-700 mb-2">
                            Tanggal Lahir <span class="text-gray-400 text-sm"></span>
                        </label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-base">
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

    {{-- Ticket Result Section (Original code continues...) --}}
    <section id="ticketResult" class="py-16 bg-gray-50 hidden">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div id="confetti-container" class="fixed inset-0 pointer-events-none z-50"></div>

            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden ticket-wrapper">
                <div class="bg-gradient-to-r from-blue-600 via-cyan-600 to-blue-700 text-white p-8 text-center relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent animate-shimmer"></div>

                    <div class="relative z-10">
                        <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mx-auto mb-4 animate-bounce-slow">
                            <i class="fas fa-ticket-alt text-5xl"></i>
                        </div>
                        <h3 class="text-3xl font-bold mb-2">Nomor Antrian Anda</h3>
                        <p class="text-blue-100">Simpan nomor ini untuk mengecek status</p>
                    </div>
                </div>

                <div class="p-8 text-center relative">
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-8 mb-6 relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-600/5 to-cyan-600/5 animate-pulse-slow"></div>

                        <div class="relative z-10">
                            <h2 id="ticketNumber" class="text-6xl font-black text-gray-800 mb-4 tracking-wider counter-animate">ABC-001</h2>
                            <p class="text-sm text-gray-600">Nomor Antrian</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-4 info-card">
                            <div class="flex items-center gap-2 mb-2">
                                <i class="fas fa-user text-blue-600"></i>
                                <p class="text-xs font-semibold text-gray-500 uppercase">Nama Lengkap</p>
                            </div>
                            <p class="font-bold text-gray-800 text-lg" id="ticketName">-</p>
                        </div>

                        <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-4 info-card">
                            <div class="flex items-center gap-2 mb-2">
                                <i class="fas fa-file-alt text-purple-600"></i>
                                <p class="text-xs font-semibold text-gray-500 uppercase">Layanan</p>
                            </div>
                            <p class="font-bold text-gray-800 text-lg" id="ticketService">-</p>
                        </div>
                    </div>

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
            </div>
        </div>
    </section>

    {{-- Other sections continue... --}}
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

            <div id="searchResults" class="mt-8 space-y-4"></div>
        </div>
    </section>
</main>
@endsection

@push('styles')
<style>
    /* OCR Upload Styles */
    #uploadArea {
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #uploadArea.dragover {
        border-color: #3B82F6 !important;
        background-color: #EFF6FF !important;
    }

    #uploadArea:hover {
        transform: translateY(-2px);
    }

    /* Existing animations... */
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

    .info-card {
        animation: slideUp 0.5s ease-out 0.4s both;
    }

    @keyframes slideUp {
        0% {
            transform: translateY(20px);
            opacity: 0;
        }
        100% {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .action-btn {
        animation: fadeIn 0.6s ease-out 0.6s both;
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // OCR KTP Variables
    let selectedFile = null;

    // DOM Elements
    const uploadArea = document.getElementById('uploadArea');
    const ktpInput = document.getElementById('ktpInput');
    const previewContainer = document.getElementById('previewContainer');
    const previewImage = document.getElementById('previewImage');
    const removeImageBtn = document.getElementById('removeImage');
    const scanKtpBtn = document.getElementById('scanKtpBtn');
    const ocrLoading = document.getElementById('ocrLoading');
    const ocrResult = document.getElementById('ocrResult');
    const ocrError = document.getElementById('ocrError');

    // Upload Area Click
    uploadArea.addEventListener('click', () => {
        ktpInput.click();
    });

    // File Input Change
    ktpInput.addEventListener('change', (e) => {
        handleFileSelect(e.target.files[0]);
    });

    // Drag & Drop
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            handleFileSelect(file);
        }
    });

    // Handle File Selection
    function handleFileSelect(file) {
        if (!file) return;

        // Validate file size (5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('Ukuran file terlalu besar. Maksimal 5MB.');
            return;
        }

        // Validate file type
        if (!file.type.match('image.*')) {
            alert('File harus berupa gambar (PNG, JPG, JPEG).');
            return;
        }

        selectedFile = file;

        // Show preview
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImage.src = e.target.result;
            previewContainer.classList.remove('hidden');
            scanKtpBtn.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }

    // Remove Image
    removeImageBtn.addEventListener('click', () => {
        selectedFile = null;
        ktpInput.value = '';
        previewContainer.classList.add('hidden');
        scanKtpBtn.classList.add('hidden');
        ocrResult.classList.add('hidden');
        ocrError.classList.add('hidden');
    });

    // Scan KTP Button
    scanKtpBtn.addEventListener('click', async () => {
        if (!selectedFile) {
            alert('Silakan upload KTP terlebih dahulu.');
            return;
        }

        // Show loading
        scanKtpBtn.classList.add('hidden');
        ocrLoading.classList.remove('hidden');
        ocrResult.classList.add('hidden');
        ocrError.classList.add('hidden');

        try {
            // Prepare form data
            const formData = new FormData();
            formData.append('ktp_image', selectedFile);

            // Send to OCR API
            const response = await fetch('/api/ocr/extract-ktp', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const result = await response.json();

            // Hide loading
            ocrLoading.classList.add('hidden');
            scanKtpBtn.classList.remove('hidden');

            if (result.success && result.data) {
                // Auto-fill form
                if (result.data.nama) {
                    document.getElementById('nama_lengkap').value = result.data.nama;
                }
                if (result.data.alamat) {
                    document.getElementById('alamat').value = result.data.alamat;
                }
                if (result.data.tanggal_lahir) {
                    // Convert DD-MM-YYYY to YYYY-MM-DD for date input
                    const dateParts = result.data.tanggal_lahir.split('-');
                    if (dateParts.length === 3) {
                        document.getElementById('tanggal_lahir').value = `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}`;
                    }
                }

                // Show OCR result
                document.getElementById('ocrNama').textContent = result.data.nama || '-';
                document.getElementById('ocrAlamat').textContent = result.data.alamat || '-';
                document.getElementById('ocrTanggal').textContent = result.data.tanggal_lahir || '-';
                ocrResult.classList.remove('hidden');

                // Scroll to form
                document.getElementById('formSection').scrollIntoView({ behavior: 'smooth', block: 'start' });

                // Show success message
                if (result.confidence && result.confidence > 0.7) {
                    showToast('Data berhasil diekstrak dengan akurasi ' + Math.round(result.confidence * 100) + '%', 'success');
                }
            } else {
                // Show error
                document.getElementById('ocrErrorMessage').textContent = result.message || 'Gagal mengekstrak data. Silakan coba lagi.';
                ocrError.classList.remove('hidden');
            }

        } catch (error) {
            console.error('OCR Error:', error);
            ocrLoading.classList.add('hidden');
            scanKtpBtn.classList.remove('hidden');

            document.getElementById('ocrErrorMessage').textContent = 'Terjadi kesalahan sistem. Silakan coba lagi atau isi data secara manual.';
            ocrError.classList.remove('hidden');
        }
    });

    // Toast notification
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 px-6 py-3 rounded-xl shadow-lg z-50 ${
            type === 'success' ? 'bg-green-500' : 'bg-blue-500'
        } text-white font-semibold`;
        toast.textContent = message;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 3000);
    }

    // Original antrian-online functions continue...
    document.getElementById('antrianForm').addEventListener('submit', async (e) => {
        e.preventDefault();

        const nama = document.getElementById('nama_lengkap').value.trim();
        const layananId = document.getElementById('layanan_id').value;

        if (!nama) {
            document.getElementById('namaError').classList.remove('hidden');
            document.getElementById('nama_lengkap').focus();
            return;
        }

        if (!layananId) {
            document.getElementById('layananError').classList.remove('hidden');
            return;
        }

        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData);

        try {
            const response = await fetch('/antrian-online', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (result.success) {
                document.getElementById('ticketNumber').textContent = result.data.nomor_antrian;
                document.getElementById('ticketName').textContent = result.data.nama_lengkap;
                const layananSelect = document.getElementById('layanan_id');
                const selectedLayanan = layananSelect.options[layananSelect.selectedIndex].text;
                document.getElementById('ticketService').textContent = selectedLayanan;

                document.getElementById('formSection').classList.add('hidden');
                document.getElementById('ticketResult').classList.remove('hidden');
                createConfetti();
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
        }
    });

    function resetForm() {
        document.getElementById('antrianForm').reset();
        document.getElementById('ticketResult').classList.add('hidden');
        document.getElementById('formSection').classList.remove('hidden');
    }

    function printTicket() {
        window.print();
    }

    function createConfetti() {
        // Confetti animation...
    }

    function searchAntrian() {
        // Search functionality...
    }

    function lacakBerkas() {
        // Tracking functionality...
    }
</script>
@endpush
