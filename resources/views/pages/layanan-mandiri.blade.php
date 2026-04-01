@extends('layouts.user')

@section('content')
@php
    // Mapping layanan ke icon, warna, dan field form yang dibutuhkan
    $serviceConfig = [

    1 => [ // KK
        'icon' => 'fa-address-card',
        'color' => 'blue',
        'id' => 'kk',
        'fields' => [
            ['name' => 'layanan_id', 'value' => '1', 'type' => 'hidden'],
            ['name' => 'nomor_registrasi', 'label' => 'Nomor Registrasi', 'placeholder' => 'Masukkan Nomor Reqistrasi', 'type' => 'text'],
            ['name' => 'nama', 'label' => 'Nama Kepala Keluarga', 'placeholder' => 'Masukkan Nama Kepala Keluarga','type' => 'text'],
            ['name' => 'alamat', 'label' => 'Alamat', 'placeholder' => 'Masukkan Alamat','type' => 'textarea'],
            ['name' => 'kutipan_perkawinan', 'label' => 'Kutipan Perkawinan', 'placeholder' => 'Masukkan Kutipan Perkawinan','type' => 'text'],
            ['name' => 'keterangan_pindah', 'label' => 'Keterangan Pindah', 'placeholder' => 'Masukkan Keterangan Pindah','type' => 'text'],
            ['name' => 'kk_lama', 'label' => 'Kartu Keluarga Sebelumnya', 'placeholder' => 'Masukkan Kartu Keluarga Sebelumnya', 'type' => 'file'],
            ['name' => 'surat_keterangan_pengganti', 'label' => 'Surat Keterangan Pengganti', 'type' => 'file'],
            ['name' => 'salinan_kepres', 'label' => 'Salinan Kepres', 'type' => 'file'],
            ['name' => 'izin_tinggal_asing', 'label' => 'Surat Izin Tinggal Bagi Asing', 'type' => 'file'],
        ]
    ],
    2 => [
        'icon' => 'fa-baby',
        'color'=> 'blue',
        'id'=>'akte_kelahiran', 
        'fields'=>[
<<<<<<< HEAD
        ['name'=>'tes', 'label'=>'tes','type'=>'text']
        ]
    ],
    3 => [ // Akte Kematian
        'icon' => 'fa-user-times',
        'color' => 'blue',
        'id' => 'akte_kematian',
        'fields' => [
            ['name' => 'layanan_id', 'value' => '3', 'type' => 'hidden'],
            ['name' => 'nama_almarhum', 'label' => 'Nama Lengkap Almarhum', 'type' => 'text', 'placeholder' => 'Sesuai KTP'],
            ['name' => 'nik_almarhum', 'label' => 'NIK Almarhum', 'type' => 'nik', 'placeholder' => '16 digit NIK'],
            ['name' => 'tgl_meninggal', 'label' => 'Tanggal Meninggal', 'type' => 'date'],
            ['name' => 'tempat_meninggal', 'label' => 'Tempat Meninggal', 'type' => 'text', 'placeholder' => 'Rumah sakit/lokasi'],
            ['name' => 'sebab_meninggal', 'label' => 'Sebab Meninggal', 'type' => 'textarea', 'placeholder' => 'Jelaskan penyebab kematian'],
            ['name' => 'nik_pelapor', 'label' => 'NIK Pelapor', 'type' => 'nik', 'placeholder' => '16 digit NIK'],
            ['name' => 'nama_pelapor', 'label' => 'Nama Pelapor', 'type' => 'text', 'placeholder' => 'Nama lengkap pelapor'],
            ['name' => 'hubungan_pelapor', 'label' => 'Hubungan dengan Almarhum', 'type' => 'select', 'options' => ['Ayah', 'Ibu', 'Suami', 'Istri', 'Anak', 'Saudara Kandung', 'Lainnya']],
            ['name' => 'surat_keterangan_kematian', 'label' => 'Surat Keterangan Kematian (RS/Kelurahan)', 'type' => 'file'],
            ['name' => 'ktp_almarhum', 'label' => 'KTP Almarhum', 'type' => 'file'],
            ['name' => 'kartu_keluarga', 'label' => 'Kartu Keluarga', 'type' => 'file'],
        ]
    ],
    4 => [ // Lahir Mati
        'icon' => 'fa-exclamation-triangle',
        'color' => 'blue',
        'id' => 'lahir_mati',
        'fields' => [
            ['name' => 'layanan_id', 'value' => '4', 'type' => 'hidden'],
            ['name' => 'nama_bayi', 'label' => 'Nama Bayi', 'type' => 'text', 'placeholder' => 'Nama lengkap bayi'],
            ['name' => 'jenis_kelamin', 'label' => 'Jenis Kelamin', 'type' => 'select', 'options' => ['Laki-laki', 'Perempuan']],
            ['name' => 'tgl_lahir', 'label' => 'Tanggal & Waktu Lahir', 'type' => 'datetime-local'],
            ['name' => 'tempat_lahir', 'label' => 'Tempat Lahir', 'type' => 'text', 'placeholder' => 'Nama RS/Klinik/Rumah'],
            ['name' => 'nama_ayah', 'label' => 'Nama Ayah', 'type' => 'text', 'placeholder' => 'Nama lengkap ayah'],
            ['name' => 'nik_ayah', 'label' => 'NIK Ayah', 'type' => 'nik', 'placeholder' => '16 digit NIK ayah'],
            ['name' => 'nama_ibu', 'label' => 'Nama Ibu', 'type' => 'text', 'placeholder' => 'Nama lengkap ibu'],
            ['name' => 'nik_ibu', 'label' => 'NIK Ibu', 'type' => 'nik', 'placeholder' => '16 digit NIK ibu'],
            ['name' => 'keterangan', 'label' => 'Keterangan', 'type' => 'textarea', 'placeholder' => 'Keterangan tambahan'],
            ['name' => 'surat_keterangan_lahir_mati', 'label' => 'Surat Keterangan Lahir Mati', 'type' => 'file'],
            ['name' => 'ktp_ayah', 'label' => 'KTP Ayah', 'type' => 'file'],
            ['name' => 'ktp_ibu', 'label' => 'KTP Ibu', 'type' => 'file'],
=======
            ['name' => 'layanan_id', 'value' => '2', 'type' => 'hidden'],
            ['name' => 'nomor_registrasi', 'label' => 'Nomor Registrasi', 'placeholder' => 'Masukkan Nomor Reqistrasi', 'type' => 'text'],
            ['name' => 'nama', 'label' => 'Nama Kepala Keluarga', 'placeholder' => 'Masukkan Nama Kepala Keluarga','type' => 'text'],
            ['name' => 'alamat', 'label' => 'Alamat', 'placeholder' => 'Masukkan Alamat','type' => 'textarea'],
            ['name' => 'fotokopi_buku_nikah','label'=>'Foto Buku Nikah Orang Tua', 'type'=>'file'],
            ['name' => 'surat_bidan','label'=>'Surat Keterangan dari Bidan', 'type'=>'file'],
            ['name' => 'ktp_orangtua','label'=>'Foto KTP Orang Tua', 'type'=>'file'],
            ['name' => 'fotokopi_kk','label'=>'Foto Kartu Keluarga', 'type'=>'file'],
            ['name' => 'identitas_saksi','label'=>'Identitas Saksi', 'placeholder' => 'Masukkan Data Identitas Saksi', 'type'=>'text'],
>>>>>>> 7d40513c353fa7162c4c073a09a61bc333a184f2
        ]
    ],
        'Penerbitan Akte Kematian' => [
            'icon' => 'fa-user-times',
            'color' => 'orange',
            'id' => 'akta-kematian',
            'fields' => [
                ['name' => 'nama_almarhum', 'label' => 'Nama Lengkap Almarhum', 'type' => 'text', 'placeholder' => 'Sesuai KTP'],
                ['name' => 'tgl_meninggal', 'label' => 'Tanggal Meninggal', 'type' => 'date'],
                ['name' => 'tempat_meninggal', 'label' => 'Tempat Meninggal', 'type' => 'text', 'placeholder' => 'Rumah sakit/lokasi'],
                ['name' => 'sebab_meninggal', 'label' => 'Sebab Meninggal', 'type' => 'textarea', 'placeholder' => 'Jelaskan penyebab'],
                ['name' => 'nik_pelapor', 'label' => 'NIK Pelapor', 'type' => 'text', 'placeholder' => '16 digit NIK'],
                ['name' => 'hubungan_pelapor', 'label' => 'Hubungan dengan Almarhum', 'type' => 'select', 'options' => ['Ayah', 'Ibu', 'Suami', 'Istri', 'Anak', 'Lainnya']],
            ]
        ],
        'Penerbitan Akte Lahir Mati' => [
            'icon' => 'fa-exclamation-triangle',
            'color' => 'red',
            'id' => 'lahir-mati',
            'fields' => [
                ['name' => 'nama_bayi', 'label' => 'Nama Bayi', 'type' => 'text', 'placeholder' => 'Nama lengkap bayi'],
                ['name' => 'tgl_lahir', 'label' => 'Tanggal Lahir', 'type' => 'datetime-local'],
                ['name' => 'nama_ayah', 'label' => 'Nama Ayah', 'type' => 'text', 'placeholder' => 'Nama lengkap ayah'],
                ['name' => 'nama_ibu', 'label' => 'Nama Ibu', 'type' => 'text', 'placeholder' => 'Nama lengkap ibu'],
                ['name' => 'nik_ayah', 'label' => 'NIK Ayah', 'type' => 'text', 'placeholder' => '16 digit NIK ayah'],
                ['name' => 'keterangan', 'label' => 'Keterangan', 'type' => 'textarea', 'placeholder' => 'Keterangan tambahan'],
            ]
        ],
        5 => [
            'icon' => 'fa-ring',
            'color' => 'blue',
            'id' => 'layanan-pernikahan',
            'fields' => [
                ['name' => 'nomor_antrian', 'label' => 'Kode Antrian', 'type' => 'text', 'placeholder' => 'Masukkan kode antrian Anda', 'required' => true],
                ['name' => 'tanggal_perkawinan', 'label' => 'Tanggal Perkawinan', 'type' => 'date', 'required' => true],
                ['name' => 'nama_lengkap_suami', 'label' => 'Nama Suami Lengkap', 'type' => 'text', 'placeholder' => 'Nama sesuai KTP', 'required' => true],
                ['name' => 'nik_suami', 'label' => 'NIK Suami', 'type' => 'number', 'placeholder' => '16 digit NIK', 'required' => true],
                ['name' => 'nama_lengkap_istri', 'label' => 'Nama Istri Lengkap', 'type' => 'text', 'placeholder' => 'Nama sesuai KTP', 'required' => true],
                ['name' => 'nik_istri', 'label' => 'NIK Istri', 'type' => 'number', 'placeholder' => '16 digit NIK', 'required' => true],
                ['name' => 'akta_pernikahan', 'label' => 'Upload Akta Pernikahan (Opsional)', 'type' => 'file', 'required' => false],
            ]
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
                    <i class="fas fa-rocket"></i>
                    Layanan Mandiri
                </div>
                <h1 class="text-4xl md:text-5xl font-extrabold mb-6">
                    Pilih Jenis Layanan
                </h1>
                <p class="text-lg text-blue-100 mb-8">
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

    {{-- Services Section --}}
    <section class="py-12 bg-gray-50 -mt-6 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Info Box (Sekarang di Atas Grid) --}}
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

            {{-- Services Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 lg:gap-6">
                @foreach($layananList as $layanan)
                    @php
                        $config = $serviceConfig[$layanan->layanan_id] ?? [
                            'icon' => 'fa-file-alt',
                            'color' => 'blue',
                            'id' => 'layanan-' . $layanan->layanan_id,
                            'fields' => []
                        ];
                        $serviceIcon = $config['icon'];
                        $serviceColor = $config['color'];
                        $serviceId = $config['id'];
                        $serviceName = $layanan->nama_layanan;
                        $shortDesc = $layanan->keterangan ?? str_replace('Penerbitan ', '', $layanan->nama_layanan);
                        $fieldsJson = json_encode($config['fields']);
                    @endphp

                    <div class="reveal" style="animation-delay: {{ $loop->index * 100 }}ms">
                        <button onclick="openServiceForm('{{ $serviceId }}', '{{ $serviceName }}', '{{ $serviceColor }}', {{ $fieldsJson }})"
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

    {{-- Benefits Section --}}
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

{{-- Modal Form Pendaftaran --}}
<div id="serviceModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto transform transition-all relative z-10" id="modalContent">
            <div id="modalHeader" class="sticky top-0 z-20 bg-white p-6 border-b">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div id="modalIcon" class="w-12 h-12 rounded-xl flex items-center justify-center"></div>
                        <div>
                            <h3 id="modalTitle" class="text-xl font-bold text-gray-800"></h3>
                            <p id="modalSubtitle" class="text-sm text-gray-500"></p>
                        </div>
                    </div>
                    <button onclick="closeModal()" class="w-10 h-10 rounded-xl flex items-center justify-center bg-gray-100 hover:bg-gray-200 transition">
                        <i class="fas fa-times text-gray-600"></i>
                    </button>
                </div>
            </div>
            @if ($errors->any())
                <div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            <div class="p-6" id="modalBody">
                {{-- Auto-fill dari Antrian Online --}}
                <div id="antrianOnlineSection" class="mb-6">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl p-5 border border-green-200">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-ticket-alt text-xl text-white"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-800 mb-2">Isi Form Otomatis dari Antrian Online</h4>
                                <p class="text-sm text-gray-600 mb-3">Sudah punya nomor antrian online? Masukkan nomor antrian untuk mengisi form secara otomatis.</p>

                                <div class="flex gap-3">
                                    <input type="text" id="nomorAntrianInput"
                                           placeholder="Contoh: ABC-123-456"
                                           class="flex-1 px-4 py-3 border-2 border-green-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition text-base uppercase">
                                    <button type="button" onclick="fetchAntrianData()"
                                            class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl font-bold hover:from-green-700 hover:to-green-800 transition-all shadow-lg">
                                        <i class="fas fa-download mr-2"></i>
                                        Ambil Data
                                    </button>
                                </div>

                                <div id="antrianLoading" class="hidden mt-3">
                                    <div class="flex items-center gap-2 text-green-600">
                                        <i class="fas fa-spinner fa-spin"></i>
                                        <span class="text-sm font-medium">Mengambil data antrian...</span>
                                    </div>
                                </div>

                                <div id="antrianSuccess" class="hidden mt-3">
                                    <div class="flex items-center gap-2 text-green-600">
                                        <i class="fas fa-check-circle"></i>
                                        <span class="text-sm font-medium">Data antrian berhasil diambil!</span>
                                    </div>
                                </div>

                                <div id="antrianError" class="hidden mt-3">
                                    <div class="flex items-center gap-2 text-red-600">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <span class="text-sm" id="antrianErrorMessage"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <form id="serviceForm" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    <div id="formFields" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Kirim Pengajuan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Service Card & Animation */
    .reveal { opacity: 0; transform: translateY(30px); transition: all 0.6s ease-out; }
    .reveal.active { opacity: 1; transform: translateY(0); }
    .service-card { position: relative; overflow: hidden; }
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    
    /* Safelist Tailwind colors for dynamic usage */
    .bg-purple-100 { background-color: #f3e8ff; } .text-purple-600 { color: #9333ea; } .bg-purple-500 { background-color: #a855f7; } .border-purple-400 { border-color: #c084fc; }
    .bg-blue-100 { background-color: #dbeafe; } .text-blue-600 { color: #2563eb; } .bg-blue-500 { background-color: #3b82f6; } .border-blue-400 { border-color: #60a5fa; }
    .bg-orange-100 { background-color: #ffedd5; } .text-orange-600 { color: #ea580c; } .bg-orange-500 { background-color: #f97316; } .border-orange-400 { border-color: #fb923c; }
    .bg-red-100 { background-color: #fee2e2; } .text-red-600 { color: #dc2626; } .bg-red-500 { background-color: #ef4444; } .border-red-400 { border-color: #f87171; }
    .bg-pink-100 { background-color: #fce7f3; } .text-pink-600 { color: #db2777; } .bg-pink-500 { background-color: #ec4899; } .border-pink-400 { border-color: #f472b6; }
</style>
@endpush

@push('scripts')
<script>
    // Reveal animation logic
    function reveal() {
        const reveals = document.querySelectorAll('.reveal');
        reveals.forEach(element => {
            const windowHeight = window.innerHeight;
            const elementTop = element.getBoundingClientRect().top;
            if (elementTop < windowHeight - 50) {
                element.classList.add('active');
            }
        });
    }
    window.addEventListener('scroll', reveal);
    window.addEventListener('load', reveal);

    let currentServiceId = null;

    // Modal logic
    function openServiceForm(serviceId, serviceName, serviceColor, fields) {
        const modal = document.getElementById('serviceModal');
        const formFields = document.getElementById('formFields');
        const modalTitle = document.getElementById('modalTitle');
        const modalSubtitle = document.getElementById('modalSubtitle');
        const modalIcon = document.getElementById('modalIcon');
        const form = document.getElementById('serviceForm');
        const antrianOnlineSection = document.getElementById('antrianOnlineSection');

        // Simpan service ID
        currentServiceId = serviceId;

        modalTitle.textContent = serviceName;
        modalSubtitle.textContent = 'Formulir pengajuan online';
        modalIcon.className = `w-12 h-12 rounded-xl flex items-center justify-center bg-${serviceColor}-100`;
        modalIcon.innerHTML = `<i class="fas ${getIconById(serviceId)} text-2xl text-${serviceColor}-600"></i>`;

        // Show antrian online section untuk semua layanan
        if (antrianOnlineSection) {
            antrianOnlineSection.classList.remove('hidden');
            resetAntrianForm();
        }

        if(serviceId === 'kk'){
            form.action = "{{ route('kk.store') }}";
        }
        formFields.innerHTML = fields.length > 0 ? fields.map(field => {
            if(field.type === 'hidden'){
                return `<input type="hidden" name="${field.name}" value="${field.value}">`;
            }
            return `
                <div class="${field.type === 'textarea' ? 'md:col-span-2' : ''} mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        ${field.label} ${field.required !== false ? '<span class="text-red-500">*</span>' : ''}
                    </label>
                    ${renderInput(field)}
                </div>
            `;
        }).join('') : '<p class="text-center col-span-2 py-4 text-gray-400">Form belum tersedia</p>';
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        document.getElementById('serviceForm').onsubmit = function() {
        Swal.fire({
        title: 'Memproses...',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });
};
    }

    function renderInput(field) {
        const req = field.required !== false ? 'required' : '';
        const baseClass = "w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition";
        
        if(field.type === 'textarea') return `<textarea name="${field.name}" ${req} placeholder="${field.placeholder}" class="${baseClass} h-24 resize-none"></textarea>`;
        if(field.type === 'select') return `<select name="${field.name}" ${req} class="${baseClass}"><option value="">Pilih...</option>${field.options.map(o => `<option value="${o}">${o}</option>`).join('')}</select>`;
        return `<input type="${field.type}" name="${field.name}" ${req} placeholder="${field.placeholder || ''}" class="${baseClass}">`;
    }

    function getIconById(id) {
        const map = { 'kk': 'fa-address-card', 'akta-lahir': 'fa-baby', 'akta-kematian': 'fa-user-times', 'lahir-mati': 'fa-exclamation-triangle', 'akta-perkawinan': 'fa-ring' };
        return map[id] || 'fa-file-alt';
    }

    function closeModal() {
        document.getElementById('serviceModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function handleSubmission(name) {
        Swal.fire({ title: 'Memproses...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
        setTimeout(() => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: `Pengajuan ${name} telah kami terima.`,
                confirmButtonColor: '#2563eb'
            }).then(() => closeModal());
        }, 1500);
    }

    // ========== ANTRIAN ONLINE AUTO-FILL FUNCTIONS ==========

    // Fetch data dari antrian online
    async function fetchAntrianData() {
        const nomorAntrianInput = document.getElementById('nomorAntrianInput');
        const nomorAntrian = nomorAntrianInput.value.trim().toUpperCase();

        // Validate nomor antrian
        if (!nomorAntrian) {
            showAntrianError('Masukkan nomor antrian');
            return;
        }

        // Format: ABC-123-456
        const antrianPattern = /^[A-Z]{3}-\d{3}-\d{3}$/;
        if (!antrianPattern.test(nomorAntrian)) {
            showAntrianError('Format nomor antrian tidak valid. Contoh: ABC-123-456');
            return;
        }

        // Show loading
        showAntrianLoading();
        hideAntrianError();

        try {
            const response = await fetch(`/antrian-online/get-data/${nomorAntrian}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            });

            const result = await response.json();

            if (result.success && result.data) {
                // Auto-fill form dengan data antrian
                autoFillFormFromAntrian(result.data);

                // Show success
                showAntrianSuccess();
            } else {
                showAntrianError(result.message || 'Antrian tidak ditemukan');
            }

        } catch (error) {
            console.error('Error fetching antrian data:', error);
            showAntrianError('Terjadi kesalahan saat mengambil data antrian');
        } finally {
            hideAntrianLoading();
        }
    }

    // Auto-fill form dari data antrian online
    function autoFillFormFromAntrian(data) {
        // Fill nama_lengkap field
        if (data.nama_lengkap) {
            const namaInput = document.querySelector('input[name="nama"]');
            if (!namaInput) {
                namaInput = document.querySelector('input[name="nama_lengkap"]');
            }
            if (!namaInput) {
                namaInput = document.querySelector('input[name="nama_kepala_keluarga"]');
            }
            if (!namaInput) {
                namaInput = document.querySelector('input[name="nama_almarhum"]');
            }
            if (!namaInput) {
                namaInput = document.querySelector('input[name="nama_ayah"]');
            }
            if (!namaInput) {
                namaInput = document.querySelector('input[name="nama_ibu"]');
            }

            if (namaInput) {
                namaInput.value = data.nama_lengkap;
                namaInput.dispatchEvent(new Event('input', { bubbles: true }));
                namaInput.dispatchEvent(new Event('change', { bubbles: true }));

                // Add visual indicator
                namaInput.classList.add('border-green-500', 'bg-green-50');
                setTimeout(() => {
                    namaInput.classList.remove('border-green-500', 'bg-green-50');
                }, 3000);
            }
        }

        // Fill alamat field
        if (data.alamat) {
            const alamatInput = document.querySelector('textarea[name="alamat"]');
            if (alamatInput) {
                alamatInput.value = data.alamat;
                alamatInput.dispatchEvent(new Event('input', { bubbles: true }));
                alamatInput.dispatchEvent(new Event('change', { bubbles: true }));

                alamatInput.classList.add('border-green-500', 'bg-green-50');
                setTimeout(() => {
                    alamatInput.classList.remove('border-green-500', 'bg-green-50');
                }, 3000);
            }
        }
    }

    // Show antrian loading
    function showAntrianLoading() {
        const loading = document.getElementById('antrianLoading');
        if (loading) loading.classList.remove('hidden');
    }

    // Hide antrian loading
    function hideAntrianLoading() {
        const loading = document.getElementById('antrianLoading');
        if (loading) loading.classList.add('hidden');
    }

    // Show antrian success
    function showAntrianSuccess() {
        const success = document.getElementById('antrianSuccess');
        if (success) {
            success.classList.remove('hidden');
            setTimeout(() => success.classList.add('hidden'), 5000);
        }
    }

    // Show antrian error
    function showAntrianError(message) {
        const error = document.getElementById('antrianError');
        const errorMessage = document.getElementById('antrianErrorMessage');

        if (error && errorMessage) {
            errorMessage.textContent = message;
            error.classList.remove('hidden');
            setTimeout(() => error.classList.add('hidden'), 5000);
        }
    }

    // Hide antrian error
    function hideAntrianError() {
        const error = document.getElementById('antrianError');
        if (error) error.classList.add('hidden');
    }

    // Reset antrian form
    function resetAntrianForm() {
        const nomorAntrianInput = document.getElementById('nomorAntrianInput');
        const success = document.getElementById('antrianSuccess');
        const error = document.getElementById('antrianError');

        if (nomorAntrianInput) nomorAntrianInput.value = '';
        if (success) success.classList.add('hidden');
        if (error) error.classList.add('hidden');
    }

</script>
@endpush
@endsection