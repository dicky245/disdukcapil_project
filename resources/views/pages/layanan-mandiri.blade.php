@extends('layouts.user')

@section('content')
@php
    $serviceConfig = [
        1 => [
            'icon' => 'fa-address-card',
            'color' => 'blue',
            'id' => 'kk',
            'persyaratan' => [
                'Kartu Keluarga Lama',
                'Fotokopi surat keterangan/bukti perubahan Peristiwa Kependudukan (cth: Paspor, SKPWNI) dan Peristiwa Penting.Catatan:Peristiwa kependudukan yang dimaksud adalah pindah penduduk dalam NKRI atau antar negara.',
                'Dasar Hukum Pasal 12 Perpres 96/2018',
            ],
            'penjelasan' => [
                'Penduduk mengisi F-1.02',
                'Penduduk melampirkan KK lama',
                'Penduduk mengisi F-1.06 karena perubahan elemen data dalam KK',
                'Penduduk melampirkan fotokopi bukti peristiwa kependudukan dan peristiwa penting',
                'Penduduk melampirkan surat pernyataan pengasuhan dari orangtua jika pindah KK dan surat pernyataan bersedia menampung dari kepala keluarga KK yang ditumpangi khusus pindah datang bagi penduduk yang berusia kurang dari 17 tahun',
                'Dinas menerbitkan KK Baru. Catatan Untuk pelayanan online/daring, persyaratan yang discan/difoto untuk diunggah harus aslinya'
            ],
            'template_url' => '#',
            'fields' => [
                ['name' => 'layanan_id', 'value' => '1', 'type' => 'hidden'],
                ['name' => 'nomor_registrasi', 'label' => 'Nomor Registrasi', 'placeholder' => 'Masukkan Nomor Registrasi', 'type' => 'text'],
                ['name' => 'nama', 'label' => 'Nama Kepala Keluarga', 'placeholder' => 'Masukkan Nama Kepala Keluarga', 'type' => 'text'],
                ['name' => 'alamat', 'label' => 'Alamat', 'placeholder' => 'Masukkan Alamat', 'type' => 'textarea'],
                ['name' => 'kutipan_perkawinan', 'label' => 'Kutipan Perkawinan', 'placeholder' => 'Masukkan Kutipan Perkawinan', 'type' => 'text'],
                ['name' => 'keterangan_pindah', 'label' => 'Keterangan Pindah', 'placeholder' => 'Masukkan Keterangan Pindah', 'type' => 'text'],
            ],
            'files' => [
                ['name' => 'kk_lama', 'label' => 'Kartu Keluarga Sebelumnya'],
                ['name' => 'surat_keterangan_pengganti', 'label' => 'Surat Keterangan Pengganti'],
                ['name' => 'salinan_kepres', 'label' => 'Salinan Kepres'],
                ['name' => 'izin_tinggal_asing', 'label' => 'Surat Izin Tinggal Bagi Asing'],
            ],
        ],
        2 => [
            'icon' => 'fa-baby',
            'color' => 'blue',
            'id' => 'akte_kelahiran',
            'persyaratan' => [
                'Fotokopi buku nikah/akta perkawinan orang tua',
                'Surat keterangan kelahiran dari bidan/dokter/rumah sakit',
                'Fotokopi KTP kedua orang tua',
                'Fotokopi Kartu Keluarga',
            ],
            'penjelasan' => [
                'Penduduk mengisi formulir permohonan pencatatan kelahiran',
                'Melampirkan semua persyaratan yang telah ditentukan',
                'Petugas melakukan verifikasi berkas',
                'Dinas menerbitkan Kutipan Akta Kelahiran',
            ],
            'template_url' => '#',
            'fields' => [
                ['name' => 'layanan_id', 'value' => '2', 'type' => 'hidden'],
                ['name' => 'nomor_registrasi', 'label' => 'Nomor Registrasi', 'placeholder' => 'Masukkan Nomor Registrasi', 'type' => 'text'],
                ['name' => 'nama', 'label' => 'Nama Kepala Keluarga', 'placeholder' => 'Masukkan Nama Kepala Keluarga', 'type' => 'text'],
                ['name' => 'alamat', 'label' => 'Alamat', 'placeholder' => 'Masukkan Alamat', 'type' => 'textarea'],
                ['name' => 'identitas_saksi', 'label' => 'Identitas Saksi', 'placeholder' => 'Masukkan Data Identitas Saksi', 'type' => 'text'],
            ],
            'files' => [
                ['name' => 'fotokopi_buku_nikah', 'label' => 'Foto Buku Nikah Orang Tua'],
                ['name' => 'surat_bidan', 'label' => 'Surat Keterangan dari Bidan'],
                ['name' => 'ktp_orangtua', 'label' => 'Foto KTP Orang Tua'],
                ['name' => 'fotokopi_kk', 'label' => 'Foto Kartu Keluarga'],
            ],
        ],
        5 => [
            'icon' => 'fa-ring',
            'color' => 'blue',
            'id' => 'layanan-pernikahan',
            'persyaratan' => [
                'Kutipan akta kelahiran masing-masing pihak',
                'Surat keterangan belum pernah kawin dari Kepala Desa/Lurah',
                'KTP dan KK kedua calon mempelai',
                'Pas foto berdampingan 4x6 sebanyak 5 lembar',
            ],
            'penjelasan' => [
                'Penduduk mengisi formulir permohonan pencatatan perkawinan',
                'Melampirkan semua persyaratan yang ditentukan',
                'Petugas melakukan verifikasi dokumen',
                'Dinas menerbitkan Kutipan Akta Perkawinan',
            ],
            'template_url' => '#',
            'fields' => [
                ['name' => 'nomor_antrian', 'label' => 'Kode Antrian', 'type' => 'text', 'placeholder' => 'Masukkan kode antrian Anda'],
                ['name' => 'tanggal_perkawinan', 'label' => 'Tanggal Perkawinan', 'type' => 'date'],
                ['name' => 'nama_lengkap_suami', 'label' => 'Nama Suami Lengkap', 'type' => 'text', 'placeholder' => 'Nama sesuai KTP'],
                ['name' => 'nik_suami', 'label' => 'NIK Suami', 'type' => 'number', 'placeholder' => '16 digit NIK'],
                ['name' => 'nama_lengkap_istri', 'label' => 'Nama Istri Lengkap', 'type' => 'text', 'placeholder' => 'Nama sesuai KTP'],
                ['name' => 'nik_istri', 'label' => 'NIK Istri', 'type' => 'number', 'placeholder' => '16 digit NIK'],
            ],
            'files' => [
                ['name' => 'akta_pernikahan', 'label' => 'Upload Akta Pernikahan (Opsional)', 'required' => false],
            ],
        ],
    ];

    $layananList = \App\Models\Layanan_Model::take(5)->get();
@endphp

<main class="pt-0">
    {{-- Page Loading --}}
    <div id="pageLoading" class="page-loading">
        <div class="loading-logo bg-white rounded-2xl shadow-2xl overflow-hidden flex items-center justify-center">
            <img src="{{ asset('images/logo_toba.jpeg') }}" alt="Logo Kabupaten Toba" class="w-full h-full object-contain p-3">
        </div>
        <div class="loading-spinner"></div>
        <div class="loading-text">Disdukcapil Kabupaten Toba</div>
        <div class="loading-subtext">Memuat layanan mandiri...</div>
        <div class="loading-dots">
            <span></span><span></span><span></span>
        </div>
    </div>

    {{-- Hero Section --}}
    <section class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-cyan-800 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm text-sm font-medium mb-4">
                    <i class="fas fa-rocket"></i>
                    Layanan Mandiri
                </div>
                <h1 class="text-3xl md:text-4xl font-extrabold mb-4">Pilih Jenis Layanan</h1>
                <p class="text-base text-blue-100 mb-6">
                    Pilih jenis layanan yang Anda butuhkan dan isi form pendaftaran secara online.
                </p>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#f9fafb"/>
            </svg>
        </div>
    </section>
    <section class="py-12 bg-gray-50 -mt-6 relative z-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8 bg-blue-50 border border-blue-200 rounded-2xl p-5 reveal shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-blue-200">
                        <i class="fas fa-info-circle text-xl text-white"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-base mb-1">Panduan Pengajuan</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Silakan pilih salah satu kartu layanan di bawah ini. Pastikan Anda menyiapkan data pendukung yang diperlukan sebelum mengisi formulir untuk mempercepat proses verifikasi oleh petugas Disdukcapil.
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 lg:gap-6">
                @foreach($layananList as $layanan)
                    @php
                        $config = $serviceConfig[$layanan->layanan_id] ?? [
                            'icon' => 'fa-file-alt',
                            'color' => 'blue',
                            'id' => 'layanan-' . $layanan->layanan_id,
                            'fields' => [],
                            'files' => [],
                            'persyaratan' => [],
                            'penjelasan' => [],
                            'template_url' => '#',
                        ];
                        $serviceIcon = $config['icon'];
                        $serviceColor = $config['color'];
                        $serviceId = $config['id'];
                        $serviceName = $layanan->nama_layanan;
                        $shortDesc = $layanan->keterangan ?? str_replace('Penerbitan ', '', $layanan->nama_layanan);
                        $configJson = json_encode([
                            'id' => $config['id'],
                            'icon' => $config['icon'],
                            'color' => $config['color'],
                            'persyaratan' => $config['persyaratan'],
                            'penjelasan' => $config['penjelasan'],
                            'template_url' => $config['template_url'],
                            'fields' => $config['fields'],
                            'files' => $config['files'],
                        ]);
                    @endphp
                    <div class="reveal" style="animation-delay: {{ $loop->index * 100 }}ms">
                        <button onclick='openServiceModal({{ $configJson }}, {{ json_encode($serviceName) }})'
                                class="service-card group bg-white rounded-2xl p-6 text-center
                                       hover:shadow-2xl transition-all duration-300 hover:-translate-y-1
                                       border-2 border-gray-100 hover:border-{{ $serviceColor }}-400 min-h-[180px] flex flex-col w-full">
                            <div class="flex-1">
                                <div class="w-16 h-16 bg-{{ $serviceColor }}-100 rounded-2xl flex items-center justify-center mx-auto mb-3
                                            group-hover:bg-{{ $serviceColor }}-500 transition-all duration-300 group-hover:scale-110">
                                    <i class="fas {{ $serviceIcon }} text-3xl text-{{ $serviceColor }}-600 group-hover:text-white transition-colors duration-300"></i>
                                </div>
                                <h3 class="font-bold text-gray-800 text-sm mb-2 leading-tight">{{ $serviceName }}</h3>
                                <p class="text-xs text-gray-500 leading-relaxed line-clamp-2">{{ $shortDesc }}</p>
                            </div>
                            <div class="mt-auto pt-3">
                                <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-{{ $serviceColor }}-50 text-{{ $serviceColor }}-700
                                             rounded-lg text-xs font-semibold group-hover:bg-{{ $serviceColor }}-500
                                             group-hover:text-white transition-all duration-300">
                                    <i class="fas fa-plus text-xs"></i>
                                    <span>Pilih</span>
                                </span>
                            </div>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="py-12 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10 reveal">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Keuntungan Layanan Mandiri</h2>
            </div>
            <div class="grid md:grid-cols-3 gap-6 reveal">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 text-center border border-blue-200">
                    <div class="w-14 h-14 bg-blue-600 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-clock text-2xl text-white"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">Hemat Waktu</h3>
                    <p class="text-gray-600 text-sm">Tanpa antri di kantor dukcapil</p>
                </div>
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 text-center border border-purple-200">
                    <div class="w-14 h-14 bg-purple-600 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-home text-2xl text-white"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">Dari Mana Saja</h3>
                    <p class="text-gray-600 text-sm">Proses online 24 jam</p>
                </div>
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 text-center border border-green-200">
                    <div class="w-14 h-14 bg-green-600 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-check-circle text-2xl text-white"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">Pantau Status</h3>
                    <p class="text-gray-600 text-sm">Update status secara real-time</p>
                </div>
            </div>
        </div>
    </section>
</main>
<div id="serviceModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full max-h-[92vh] overflow-y-auto transform transition-all relative z-10" id="modalContent">
            <div id="modalHeader" class="sticky top-0 z-20 bg-white p-5 border-b border-gray-100 rounded-t-3xl">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div id="modalIcon" class="w-11 h-11 rounded-xl flex items-center justify-center"></div>
                        <div>
                            <h3 id="modalTitle" class="text-lg font-bold text-gray-800"></h3>
                            <p id="modalStepLabel" class="text-xs text-gray-400 font-medium"></p>
                        </div>
                    </div>
                    <button onclick="closeModal()" class="w-9 h-9 rounded-xl flex items-center justify-center bg-gray-100 hover:bg-gray-200 transition flex-shrink-0">
                        <i class="fas fa-times text-gray-500 text-sm"></i>
                    </button>
                </div>
                <div class="flex items-center gap-1">
                    @foreach(['Informasi', 'Data Diri', 'Berkas', 'Konfirmasi'] as $i => $stepName)
                    <div class="flex-1 flex flex-col items-center">
                        <div class="step-indicator w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold mb-1 transition-all duration-300"
                             id="stepDot{{ $i + 1 }}"
                             data-step="{{ $i + 1 }}">
                            {{ $i + 1 }}
                        </div>
                        <span class="text-[9px] font-semibold step-label text-gray-400" id="stepLabel{{ $i + 1 }}">{{ $stepName }}</span>
                    </div>
                    @if($i < 3)
                    <div class="flex-1 h-0.5 bg-gray-200 rounded mb-5" id="stepLine{{ $i + 1 }}"></div>
                    @endif
                    @endforeach
                </div>
            </div>
            @if ($errors->any())
            <div class="mx-5 mt-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl">
                <div class="flex items-center mb-2">
                    <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                    <span class="text-red-800 font-bold text-sm">Terjadi Kesalahan Validasi:</span>
                </div>
                <ul class="list-disc list-inside text-xs text-red-600 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form id="serviceForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div id="step1" class="step-content p-5 space-y-5">
                    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-info-circle text-blue-600"></i>
                            <h4 class="font-bold text-blue-800 text-sm">Informasi Layanan</h4>
                        </div>
                        <p id="infoLayanan" class="text-sm text-blue-700 leading-relaxed"></p>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-6 h-6 bg-orange-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-list-check text-orange-600 text-xs"></i>
                            </div>
                            <h4 class="font-bold text-gray-800 text-sm">Persyaratan</h4>
                        </div>
                        <ul id="listPersyaratan" class="space-y-2"></ul>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-6 h-6 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-route text-green-600 text-xs"></i>
                            </div>
                            <h4 class="font-bold text-gray-800 text-sm">Alur Pengajuan</h4>
                        </div>
                        <ol id="listPenjelasan" class="space-y-2"></ol>
                    </div>
                    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-file-pdf text-red-500"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">Template Dokumen</p>
                                <p class="text-xs text-gray-500">Unduh dan isi sebelum melanjutkan</p>
                            </div>
                        </div>
                        <a id="btnDownloadTemplate" href="#" target="_blank"
                           class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 text-white rounded-xl text-xs font-semibold hover:bg-blue-700 transition">
                            <i class="fas fa-download"></i> Unduh
                        </a>
                    </div>

                    <button type="button" onclick="goToStep(2)"
                            class="w-full py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg flex items-center justify-center gap-2">
                        Selanjutnya
                        <i class="fas fa-arrow-right text-sm"></i>
                    </button>
                </div>
                <div id="step2" class="step-content p-5 space-y-4 hidden">
                    <p class="text-sm text-gray-500 mb-1">Lengkapi data diri Anda dengan benar sesuai dokumen resmi.</p>
                    <div id="formFields" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>

                    <div class="flex gap-3 mt-6 pt-4 border-t border-gray-100">
                        <button type="button" onclick="goToStep(1)"
                                class="flex-1 py-3 border-2 border-gray-200 text-gray-600 rounded-xl font-bold hover:bg-gray-50 transition flex items-center justify-center gap-2">
                            <i class="fas fa-arrow-left text-sm"></i> Kembali
                        </button>
                        <button type="button" onclick="validateAndGoStep3()"
                                class="flex-1 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg flex items-center justify-center gap-2">
                            Selanjutnya <i class="fas fa-arrow-right text-sm"></i>
                        </button>
                    </div>
                </div>
                <div id="step3" class="step-content p-5 space-y-4 hidden">
                    <p class="text-sm text-gray-500 mb-1">Upload berkas persyaratan dalam format <strong>PDF</strong>. Pastikan dokumen terbaca dengan jelas.</p>
                    <div id="fileFields" class="space-y-4"></div>

                    <div class="flex gap-3 mt-6 pt-4 border-t border-gray-100">
                        <button type="button" onclick="goToStep(2)"
                                class="flex-1 py-3 border-2 border-gray-200 text-gray-600 rounded-xl font-bold hover:bg-gray-50 transition flex items-center justify-center gap-2">
                            <i class="fas fa-arrow-left text-sm"></i> Kembali
                        </button>
                        <button type="button" onclick="goToStep(4)"
                                class="flex-1 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg flex items-center justify-center gap-2">
                            Selanjutnya <i class="fas fa-arrow-right text-sm"></i>
                        </button>
                    </div>
                </div>
                <div id="step4" class="step-content p-5 space-y-4 hidden">
                    <div class="bg-green-50 border border-green-200 rounded-2xl p-4 text-center">
                        <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                        </div>
                        <h4 class="font-bold text-green-800 text-base mb-1">Data Siap Dikirim</h4>
                        <p class="text-green-700 text-sm">Pastikan semua data dan berkas yang Anda isi sudah benar sebelum mengirim pengajuan.</p>
                    </div>

                    {{-- Ringkasan data --}}
                    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4">
                        <h5 class="font-bold text-gray-700 text-sm mb-3 flex items-center gap-2">
                            <i class="fas fa-clipboard-list text-blue-500"></i> Ringkasan Pengajuan
                        </h5>
                        <div id="summaryData" class="space-y-2 text-sm text-gray-600"></div>
                    </div>

                    <div class="flex gap-3 mt-6 pt-4 border-t border-gray-100">
                        <button type="button" onclick="goToStep(3)"
                                class="flex-1 py-3 border-2 border-gray-200 text-gray-600 rounded-xl font-bold hover:bg-gray-50 transition flex items-center justify-center gap-2">
                            <i class="fas fa-arrow-left text-sm"></i> Kembali
                        </button>
                        <button type="submit" id="btnSubmit"
                                class="flex-1 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl font-bold hover:from-green-700 hover:to-green-800 transition-all shadow-lg flex items-center justify-center gap-2">
                            <i class="fas fa-paper-plane text-sm"></i> Kirim Pengajuan
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .reveal { opacity: 0; transform: translateY(30px); transition: all 0.6s ease-out; }
    .reveal.active { opacity: 1; transform: translateY(0); }
    .service-card { position: relative; overflow: hidden; }
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .step-indicator { background: #e5e7eb; color: #9ca3af; }
    .step-indicator.active { background: #2563eb; color: #fff; box-shadow: 0 0 0 3px #bfdbfe; }
    .step-indicator.done { background: #16a34a; color: #fff; }
    .step-label.active { color: #2563eb !important; }
    .step-label.done { color: #16a34a !important; }
    #stepLine1.done, #stepLine2.done, #stepLine3.done { background: #16a34a; }
    .step-content { animation: fadeSlide 0.3s ease-out; }
    @keyframes fadeSlide { from { opacity: 0; transform: translateX(18px); } to { opacity: 1; transform: translateX(0); } }
    .form-input {
        width: 100%; padding: 0.6rem 1rem;
        border: 2px solid #e5e7eb; border-radius: 0.75rem;
        font-size: 0.875rem; transition: border-color 0.2s;
        outline: none; background: #fff;
    }
    .form-input:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px #dbeafe; }
    .bg-blue-100{background-color:#dbeafe}.text-blue-600{color:#2563eb}.border-blue-400{border-color:#60a5fa}
    .bg-orange-100{background-color:#ffedd5}.text-orange-600{color:#ea580c}.border-orange-400{border-color:#fb923c}
    .bg-red-100{background-color:#fee2e2}.text-red-600{color:#dc2626}.border-red-400{border-color:#f87171}
    .bg-purple-100{background-color:#f3e8ff}.text-purple-600{color:#9333ea}.border-purple-400{border-color:#c084fc}
    .bg-pink-100{background-color:#fce7f3}.text-pink-600{color:#db2777}.border-pink-400{border-color:#f472b6}
    .bg-blue-50{background-color:#eff6ff}.text-blue-700{color:#1d4ed8}.bg-blue-500{background-color:#3b82f6}
    .hover\:border-blue-400:hover{border-color:#60a5fa}
    .hover\:bg-blue-500:hover{background-color:#3b82f6}
    .group:hover .group-hover\:bg-blue-500{background-color:#3b82f6}
    .group:hover .group-hover\:text-white{color:#fff}
</style>
@endpush
@push('scripts')
<script>
    let currentStep = 1;
    let currentConfig = {};
    let currentServiceName = '';
    function reveal() {
        document.querySelectorAll('.reveal').forEach(el => {
            if (el.getBoundingClientRect().top < window.innerHeight - 50) el.classList.add('active');
        });
    }
    window.addEventListener('scroll', reveal);
    window.addEventListener('load', reveal);
    function openServiceModal(config, serviceName) {
        currentConfig = config;
        currentServiceName = serviceName;
        document.getElementById('modalTitle').textContent = serviceName;
        const icon = document.getElementById('modalIcon');
        icon.className = `w-11 h-11 rounded-xl flex items-center justify-center bg-${config.color}-100`;
        icon.innerHTML = `<i class="fas ${config.icon} text-xl text-${config.color}-600"></i>`;

        const form = document.getElementById('serviceForm');
        if (config.id === 'kk') {
            form.action = "{{ route('kk.store') }}";
        } else if (config.id === 'akte_kelahiran') {
            form.action = "{{ route('aktelahir.store') }}";
        } else {
            form.action = "#";
        }
        document.getElementById('infoLayanan').textContent =
            `Layanan ${serviceName} adalah layanan kependudukan yang dapat diajukan secara online melalui portal Disdukcapil Kabupaten Toba. Proses verifikasi dilakukan oleh petugas dalam 2-3 hari kerja.`;
        const ul = document.getElementById('listPersyaratan');
        ul.innerHTML = config.persyaratan.map((p, i) => `
            <li class="flex items-start gap-3 bg-white border border-gray-100 rounded-xl p-3">
                <div class="w-5 h-5 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                    <span class="text-orange-600 font-bold text-[10px]">${i + 1}</span>
                </div>
                <span class="text-sm text-gray-700 leading-relaxed">${p}</span>
            </li>
        `).join('');
        const ol = document.getElementById('listPenjelasan');
        ol.innerHTML = config.penjelasan.map((p, i) => `
            <li class="flex items-start gap-3">
                <div class="w-6 h-6 bg-green-600 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                    <span class="text-white font-bold text-[10px]">${i + 1}</span>
                </div>
                <span class="text-sm text-gray-700 leading-relaxed">${p}</span>
            </li>
        `).join('');
        document.getElementById('btnDownloadTemplate').href = config.template_url;
        const formFields = document.getElementById('formFields');
        const hiddenAndText = config.fields.filter(f => f.type !== 'file');
        formFields.innerHTML = hiddenAndText.map(field => {
            if (field.type === 'hidden') {
                return `<input type="hidden" name="${field.name}" value="${field.value}">`;
            }
            const isFullWidth = field.type === 'textarea' ? 'md:col-span-2' : '';
            return `
                <div class="${isFullWidth}">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">
                        ${field.label} <span class="text-red-400">*</span>
                    </label>
                    ${renderField(field)}
                </div>
            `;
        }).join('');
        const fileFields = document.getElementById('fileFields');
        fileFields.innerHTML = config.files.map(file => `
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">
                    ${file.label} ${file.required !== false ? '<span class="text-red-400">*</span>' : '<span class="text-gray-400 font-normal">(opsional)</span>'}
                </label>
                <label class="flex flex-col items-center justify-center w-full px-4 py-5
                              border-2 border-dashed border-gray-300 rounded-2xl bg-gray-50
                              hover:bg-blue-50 hover:border-blue-400 transition-all cursor-pointer">
                    <i class="fas fa-file-pdf text-2xl text-gray-400 mb-2" id="icon-${file.name}"></i>
                    <p class="text-sm font-semibold text-gray-600">Pilih File PDF</p>
                    <p class="text-[10px] text-gray-400 mt-1 uppercase tracking-wider">Format: PDF</p>
                    <input type="file" name="${file.name}" accept=".pdf"
                           ${file.required !== false ? 'required' : ''}
                           class="hidden" onchange="handleFileSelect(this, '${file.name}')">
                </label>
                <div id="name-${file.name}" class="mt-1.5 px-2 text-[11px] text-blue-600 font-medium hidden">
                    <i class="fas fa-check-circle mr-1"></i><span class="file-label"></span>
                </div>
            </div>
        `).join('');
        goToStep(1);
        document.getElementById('serviceModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function renderField(field) {
        const cls = 'form-input';
        if (field.type === 'textarea') {
            return `<textarea name="${field.name}" placeholder="${field.placeholder || ''}" class="${cls} h-24 resize-none" required></textarea>`;
        }
        if (field.type === 'select') {
            return `<select name="${field.name}" class="${cls}" required>
                <option value="">Pilih...</option>
                ${field.options.map(o => `<option value="${o}">${o}</option>`).join('')}
            </select>`;
        }
        return `<input type="${field.type}" name="${field.name}" placeholder="${field.placeholder || ''}" class="${cls}" required>`;
    }
    function goToStep(step) {
        currentStep = step;
        document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
        const active = document.getElementById('step' + step);
        if (active) {
            active.classList.remove('hidden');
            active.style.animation = 'none';
            active.offsetHeight; 
            active.style.animation = '';
        }
        const stepLabels = ['Informasi', 'Data Diri', 'Berkas', 'Konfirmasi'];
        for (let i = 1; i <= 4; i++) {
            const dot = document.getElementById('stepDot' + i);
            const lbl = document.getElementById('stepLabel' + i);
            dot.className = 'step-indicator w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold mb-1 transition-all duration-300';
            lbl.className = 'text-[9px] font-semibold step-label text-gray-400';
            if (i < step) {
                dot.classList.add('done');
                dot.innerHTML = '<i class="fas fa-check text-[10px]"></i>';
                lbl.classList.add('done');
            } else if (i === step) {
                dot.classList.add('active');
                dot.textContent = i;
                lbl.classList.add('active');
            } else {
                dot.textContent = i;
            }
            if (i < 4) {
                const line = document.getElementById('stepLine' + i);
                if (line) {
                    line.className = 'flex-1 h-0.5 rounded mb-5 transition-all duration-500 ' + (i < step ? 'bg-green-400' : 'bg-gray-200');
                }
            }
        }
        document.getElementById('modalStepLabel').textContent = `Langkah ${step} dari 4 — ${stepLabels[step - 1]}`;
        document.getElementById('modalContent').scrollTop = 0;
        if (step === 4) buildSummary();
    }
    function validateAndGoStep3() {
        const step2 = document.getElementById('step2');
        const inputs = step2.querySelectorAll('input[required], textarea[required], select[required]');
        let valid = true;
        inputs.forEach(input => {
            input.style.borderColor = '';
            if (!input.value.trim()) {
                input.style.borderColor = '#ef4444';
                valid = false;
            }
        });
        if (!valid) {
            showToast('Harap lengkapi semua data yang diperlukan.', 'error');
            return;
        }
        goToStep(3);
    }

    function buildSummary() {
        const summary = document.getElementById('summaryData');
        let html = '';
        currentConfig.fields.forEach(f => {
            if (f.type === 'hidden' || f.type === 'file') return;
            const el = document.querySelector(`[name="${f.name}"]`);
            const val = el ? el.value : '-';
            html += `
                <div class="flex justify-between py-1.5 border-b border-gray-100 last:border-0">
                    <span class="text-gray-500 text-xs">${f.label}</span>
                    <span class="font-semibold text-gray-800 text-xs text-right max-w-[60%] truncate">${val || '-'}</span>
                </div>`;
        });
        currentConfig.files.forEach(f => {
            const el = document.querySelector(`[name="${f.name}"]`);
            const val = el && el.files[0] ? el.files[0].name : '(belum dipilih)';
            html += `
                <div class="flex justify-between py-1.5 border-b border-gray-100 last:border-0">
                    <span class="text-gray-500 text-xs">${f.label}</span>
                    <span class="font-semibold text-xs text-right max-w-[60%] truncate ${el && el.files[0] ? 'text-green-600' : 'text-gray-400'}">${val}</span>
                </div>`;
        });
        summary.innerHTML = html;
    }
    function handleFileSelect(input, fieldName) {
        const displayDiv = document.getElementById(`name-${fieldName}`);
        const icon = document.getElementById(`icon-${fieldName}`);
        if (input.files && input.files[0]) {
            displayDiv.querySelector('.file-label').textContent = input.files[0].name;
            displayDiv.classList.remove('hidden');
            if (icon) { icon.className = 'fas fa-check-circle text-2xl text-green-500 mb-2'; }
        } else {
            displayDiv.classList.add('hidden');
            if (icon) { icon.className = 'fas fa-file-pdf text-2xl text-gray-400 mb-2'; }
        }
    }
    function showToast(message, type = 'error') {
        const colors = { error: 'bg-red-500', success: 'bg-green-500' };
        const toast = document.createElement('div');
        toast.className = `fixed top-5 right-5 z-[9999] px-5 py-3 rounded-xl text-white text-sm font-semibold shadow-lg ${colors[type]} transition-all`;
        toast.innerHTML = `<i class="fas ${type === 'error' ? 'fa-exclamation-circle' : 'fa-check-circle'} mr-2"></i>${message}`;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3500);
    }
    document.getElementById('serviceForm').addEventListener('submit', function () {
        Swal.fire({
            title: 'Memproses...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });
    });
    function closeModal() {
        document.getElementById('serviceModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>
@endpush
@endsection