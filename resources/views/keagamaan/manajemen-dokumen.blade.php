@extends('layouts.keagamaan')

@section('content')
@php
    $page_title = 'Manajemen Dokumen - Keagamaan';
@endphp

<!-- Page Header -->
<div class="mb-6 reveal">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Dokumen</h1>
            <p class="text-gray-600 mt-1">Kelola semua dokumen keagamaan</p>
        </div>
        <button onclick="uploadModal()" class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition flex items-center gap-2">
            <i class="fas fa-upload"></i>
            <span>Upload Dokumen</span>
        </button>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6 reveal">
    <div class="stat-card bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-file-alt text-xl text-blue-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-800">2,456</p>
                <p class="text-sm text-gray-600">Total Dokumen</p>
            </div>
        </div>
    </div>

    <div class="stat-card bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-check-circle text-xl text-emerald-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-800">2,180</p>
                <p class="text-sm text-gray-600">Terverifikasi</p>
            </div>
        </div>
    </div>

    <div class="stat-card bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-clock text-xl text-yellow-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-800">234</p>
                <p class="text-sm text-gray-600">Menunggu Verifikasi</p>
            </div>
        </div>
    </div>

    <div class="stat-card bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-hdd text-xl text-purple-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-800">1.2 GB</p>
                <p class="text-sm text-gray-600">Total Ukuran</p>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm mb-6 reveal">
    <div class="flex flex-col md:flex-row gap-4">
        <div class="flex-1">
            <input type="text" placeholder="Cari dokumen..." class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
        </div>
        <select class="px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
            <option>Semua Jenis</option>
            <option>Akta Nikah</option>
            <option>Akta Cerai</option>
            <option>Buku Nikah</option>
            <option>Lainnya</option>
        </select>
        <select class="px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
            <option>Semua Status</option>
            <option>Terverifikasi</option>
            <option>Menunggu Verifikasi</option>
            <option>Ditolak</option>
        </select>
        <select class="px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
            <option>Terbaru</option>
            <option>Terlama</option>
            <option>Nama A-Z</option>
            <option>Nama Z-A</option>
        </select>
    </div>
</div>

<!-- Documents Grid -->
<div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm reveal">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-bold text-gray-800">Daftar Dokumen</h3>
        <div class="flex gap-2">
            <button class="p-2 bg-teal-50 text-teal-600 rounded-lg transition">
                <i class="fas fa-th-large"></i>
            </button>
            <button class="p-2 hover:bg-gray-100 text-gray-600 rounded-lg transition">
                <i class="fas fa-list"></i>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Document Card 1 -->
        <div class="border border-gray-200 rounded-xl p-4 hover:shadow-md transition group">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-file-pdf text-2xl text-blue-600"></i>
                </div>
                <div class="flex gap-1">
                    <button class="p-2 hover:bg-gray-100 rounded-lg transition opacity-0 group-hover:opacity-100">
                        <i class="fas fa-eye text-gray-600"></i>
                    </button>
                    <button class="p-2 hover:bg-gray-100 rounded-lg transition opacity-0 group-hover:opacity-100">
                        <i class="fas fa-download text-gray-600"></i>
                    </button>
                </div>
            </div>
            <h4 class="font-semibold text-gray-800 mb-1">Akta Nikah - Budi & Siti</h4>
            <p class="text-sm text-gray-600 mb-3">KAG-001234 • Akta Nikah</p>
            <div class="flex items-center justify-between">
                <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-medium">Terverifikasi</span>
                <span class="text-xs text-gray-500">2.4 MB</span>
            </div>
        </div>

        <!-- Document Card 2 -->
        <div class="border border-gray-200 rounded-xl p-4 hover:shadow-md transition group">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-file-pdf text-2xl text-red-600"></i>
                </div>
                <div class="flex gap-1">
                    <button class="p-2 hover:bg-gray-100 rounded-lg transition opacity-0 group-hover:opacity-100">
                        <i class="fas fa-eye text-gray-600"></i>
                    </button>
                    <button class="p-2 hover:bg-gray-100 rounded-lg transition opacity-0 group-hover:opacity-100">
                        <i class="fas fa-download text-gray-600"></i>
                    </button>
                </div>
            </div>
            <h4 class="font-semibold text-gray-800 mb-1">Buku Nikah - Ahmad & Rina</h4>
            <p class="text-sm text-gray-600 mb-3">KAG-001235 • Buku Nikah</p>
            <div class="flex items-center justify-between">
                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">Menunggu</span>
                <span class="text-xs text-gray-500">1.8 MB</span>
            </div>
        </div>

        <!-- Document Card 3 -->
        <div class="border border-gray-200 rounded-xl p-4 hover:shadow-md transition group">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-file-image text-2xl text-green-600"></i>
                </div>
                <div class="flex gap-1">
                    <button class="p-2 hover:bg-gray-100 rounded-lg transition opacity-0 group-hover:opacity-100">
                        <i class="fas fa-eye text-gray-600"></i>
                    </button>
                    <button class="p-2 hover:bg-gray-100 rounded-lg transition opacity-0 group-hover:opacity-100">
                        <i class="fas fa-download text-gray-600"></i>
                    </button>
                </div>
            </div>
            <h4 class="font-semibold text-gray-800 mb-1">Foto Pernikahan - Joko & Maria</h4>
            <p class="text-sm text-gray-600 mb-3">KAG-001236 • Dokumentasi</p>
            <div class="flex items-center justify-between">
                <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-medium">Terverifikasi</span>
                <span class="text-xs text-gray-500">5.2 MB</span>
            </div>
        </div>

        <!-- Document Card 4 -->
        <div class="border border-gray-200 rounded-xl p-4 hover:shadow-md transition group">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-file-alt text-2xl text-purple-600"></i>
                </div>
                <div class="flex gap-1">
                    <button class="p-2 hover:bg-gray-100 rounded-lg transition opacity-0 group-hover:opacity-100">
                        <i class="fas fa-eye text-gray-600"></i>
                    </button>
                    <button class="p-2 hover:bg-gray-100 rounded-lg transition opacity-0 group-hover:opacity-100">
                        <i class="fas fa-download text-gray-600"></i>
                    </button>
                </div>
            </div>
            <h4 class="font-semibold text-gray-800 mb-1">Surat Cerai - Dedi & Lestari</h4>
            <p class="text-sm text-gray-600 mb-3">KAG-001237 • Akta Cerai</p>
            <div class="flex items-center justify-between">
                <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-medium">Terverifikasi</span>
                <span class="text-xs text-gray-500">1.2 MB</span>
            </div>
        </div>

        <!-- Document Card 5 -->
        <div class="border border-gray-200 rounded-xl p-4 hover:shadow-md transition group">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-file-image text-2xl text-orange-600"></i>
                </div>
                <div class="flex gap-1">
                    <button class="p-2 hover:bg-gray-100 rounded-lg transition opacity-0 group-hover:opacity-100">
                        <i class="fas fa-eye text-gray-600"></i>
                    </button>
                    <button class="p-2 hover:bg-gray-100 rounded-lg transition opacity-0 group-hover:opacity-100">
                        <i class="fas fa-download text-gray-600"></i>
                    </button>
                </div>
            </div>
            <h4 class="font-semibold text-gray-800 mb-1">KTP Pasangan - Rudi & Dewi</h4>
            <p class="text-sm text-gray-600 mb-3">KAG-001238 • Persyaratan</p>
            <div class="flex items-center justify-between">
                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">Menunggu</span>
                <span class="text-xs text-gray-500">800 KB</span>
            </div>
        </div>

        <!-- Add New Card -->
        <div onclick="uploadModal()" class="border-2 border-dashed border-gray-300 rounded-xl p-4 flex flex-col items-center justify-center cursor-pointer hover:border-teal-500 hover:bg-teal-50 transition group min-h-[200px]">
            <div class="w-16 h-16 bg-gray-100 group-hover:bg-teal-100 rounded-xl flex items-center justify-center mb-4 transition">
                <i class="fas fa-plus text-3xl text-gray-400 group-hover:text-teal-600 transition"></i>
            </div>
            <p class="font-semibold text-gray-600 group-hover:text-teal-700 transition">Upload Dokumen Baru</p>
            <p class="text-sm text-gray-500 mt-1">Klik atau drag file di sini</p>
        </div>
    </div>

    <!-- Pagination -->
    <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-200">
        <p class="text-sm text-gray-600">Menampilkan 1-6 dari 2,456 dokumen</p>
        <div class="flex gap-2">
            <button class="px-4 py-2 border border-gray-200 rounded-lg text-sm hover:bg-gray-50 transition disabled:opacity-50" disabled>
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="px-4 py-2 bg-teal-600 text-white rounded-lg text-sm">1</button>
            <button class="px-4 py-2 border border-gray-200 rounded-lg text-sm hover:bg-gray-50 transition">2</button>
            <button class="px-4 py-2 border border-gray-200 rounded-lg text-sm hover:bg-gray-50 transition">3</button>
            <button class="px-4 py-2 border border-gray-200 rounded-lg text-sm hover:bg-gray-50 transition">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</div>

<script>
    function uploadModal() {
        Swal.fire({
            title: 'Upload Dokumen',
            html: `
                <div class="text-left">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Dokumen</label>
                        <select class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                            <option>Akta Nikah</option>
                            <option>Akta Cerai</option>
                            <option>Buku Nikah</option>
                            <option>Dokumentasi</option>
                            <option>Persyaratan</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">ID Keagamaan</label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500" placeholder="KAG-XXXXXX">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">File</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center cursor-pointer hover:border-teal-500 transition">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                            <p class="text-sm text-gray-600">Drag & drop atau klik untuk pilih file</p>
                            <p class="text-xs text-gray-500 mt-1">PDF, JPG, PNG (Maks. 10 MB)</p>
                        </div>
                    </div>
                </div>
            `,
            confirmButtonText: 'Upload',
            confirmButtonColor: '#0d9488',
            showCancelButton: true,
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Dokumen berhasil diupload',
                    confirmButtonColor: '#0d9488'
                });
            }
        });
    }

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
