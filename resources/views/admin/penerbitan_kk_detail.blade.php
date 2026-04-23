@extends('layouts.admin')

@section('content')
<div class="container-fluid p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Detail Permohonan KK ({{ $jenis }})
        </h1>
        <a href="{{ route('admin.penerbitan-kk') }}"
        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Kolom Kiri: Informasi Pemohon & Status --}}
        <div class="lg:col-span-1 space-y-6">
            
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h2 class="text-lg font-bold mb-5 text-gray-800 flex items-center gap-2">
                    <i class="fas fa-user-circle text-blue-500"></i> Informasi Pemohon
                </h2>
                <div class="space-y-3 text-sm">
                    <div class="grid grid-cols-3 border-b border-gray-50 pb-2">
                        <span class="text-gray-500 col-span-1">No. Antrian</span>
                        <span class="font-bold text-blue-600 col-span-2 text-right">{{ $berkas->nomor_antrian ?? '-' }}</span>
                    </div>
                    <div class="grid grid-cols-3 border-b border-gray-50 pb-2">
                        <span class="text-gray-500 col-span-1">Nama</span>
                        <span class="font-semibold text-gray-800 col-span-2 text-right">{{ $berkas->nama_pemohon }}</span>
                    </div>
                    <div class="grid grid-cols-3 border-b border-gray-50 pb-2">
                        <span class="text-gray-500 col-span-1">Layanan</span>
                        <span class="font-semibold text-gray-800 col-span-2 text-right">{{ $jenis }}</span>
                    </div>
                    <div class="flex flex-col border-b border-gray-50 pb-2">
                        <span class="text-gray-500 mb-1">Alamat</span>
                        <span class="font-semibold text-gray-800 leading-relaxed">{{ $berkas->alamat_pemohon }}</span>
                    </div>
                    <div class="grid grid-cols-3 pt-1">
                        <span class="text-gray-500 col-span-1">Tgl Pengajuan</span>
                        <span class="font-semibold text-gray-800 col-span-2 text-right">{{ $berkas->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h2 class="text-lg font-bold mb-4 text-gray-800 flex items-center gap-2">
                    <i class="fas fa-tasks text-blue-500"></i> Status Pengajuan
                </h2>
                <div class="text-center p-3 rounded-lg border 
                    {{ $berkas->status == 'Tolak' ? 'bg-red-50 border-red-200 text-red-700' : 'bg-blue-50 border-blue-200 text-blue-700' }}">
                    <p class="text-xs uppercase tracking-wider mb-1 font-semibold">Status Terkini</p>
                    <p class="text-lg font-bold">{{ $berkas->status }}</p>
                </div>
                @if($berkas->status == 'Tolak')
                <div class="mt-4 p-4 bg-red-50 border border-red-100 rounded-lg text-sm text-red-800">
                    <strong class="flex items-center gap-1 mb-1"><i class="fas fa-exclamation-triangle"></i> Alasan Penolakan:</strong>
                    <p class="leading-relaxed">{{ $berkas->alasan_penolakan ?? $berkas->alasan }}</p>
                </div>
                @endif
            </div>

        </div>

        {{-- Kolom Kanan: Dokumen Persyaratan & Foto Verifikasi --}}
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 h-auto">
                <h2 class="text-lg font-bold mb-6 text-gray-800 flex items-center gap-2">
                    <i class="fas fa-folder-open text-blue-500"></i> Dokumen Persyaratan
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @php
                        // Mengambil array logika dokumen asli Anda
                        $dokumen = [];
                        if($jenis == 'Perubahan Data') {
                            $dokumen[] = ['label' => 'Formulir F-1.02', 'field' => 'formulir_f102', 'icon' => 'fa-file-signature', 'color' => 'blue'];
                            $dokumen[] = ['label' => 'KTP Pemohon', 'field' => 'ktp_pemohon', 'icon' => 'fa-id-card', 'color' => 'green'];
                            $dokumen[] = ['label' => 'KK Pemohon', 'field' => 'kk_pemohon', 'icon' => 'fa-users', 'color' => 'green'];
                            $dokumen[] = ['label' => 'Formulir F-1.06', 'field' => 'formulir_f106', 'icon' => 'fa-file-alt', 'color' => 'blue'];
                            $dokumen[] = ['label' => 'Suket Perubahan', 'field' => 'surat_keterangan_perubahan', 'icon' => 'fa-file-contract', 'color' => 'red'];
                            if($berkas->pernyataan_pindah_kk) $dokumen[] = ['label' => 'Pernyataan Pindah KK', 'field' => 'pernyataan_pindah_kk', 'icon' => 'fa-exchange-alt', 'color' => 'yellow'];
                        }
                        elseif($jenis == 'Ganti Kepala') {
                            $dokumen[] = ['label' => 'Formulir F-1.02', 'field' => 'formulir_f102', 'icon' => 'fa-file-signature', 'color' => 'blue'];
                            $dokumen[] = ['label' => 'KTP Pemohon', 'field' => 'ktp_pemohon', 'icon' => 'fa-id-card', 'color' => 'green'];
                            $dokumen[] = ['label' => 'KK Pemohon', 'field' => 'kk_pemohon', 'icon' => 'fa-users', 'color' => 'green'];
                            $dokumen[] = ['label' => 'Akta Kematian', 'field' => 'fotokopi_akta_kematian', 'icon' => 'fa-file-medical', 'color' => 'gray'];
                            if($berkas->surat_pernyataan_wali) $dokumen[] = ['label' => 'Surat Pernyataan Wali', 'field' => 'surat_pernyataan_wali', 'icon' => 'fa-file-contract', 'color' => 'yellow'];
                        }
                        elseif($jenis == 'Hilang Rusak') {
                            $dokumen[] = ['label' => 'Formulir F-1.02', 'field' => 'formulir_f102', 'icon' => 'fa-file-signature', 'color' => 'blue'];
                            $dokumen[] = ['label' => 'KTP Pemohon', 'field' => 'ktp_pemohon', 'icon' => 'fa-id-card', 'color' => 'green'];
                            $dokumen[] = ['label' => 'Surat Kehilangan/Rusak', 'field' => 'suket_hilang_rusak', 'icon' => 'fa-file-excel', 'color' => 'red'];
                        }
                        elseif($jenis == 'Pisah KK') {
                            $dokumen[] = ['label' => 'Formulir F-1.02', 'field' => 'formulir_f102', 'icon' => 'fa-file-signature', 'color' => 'blue'];
                            $dokumen[] = ['label' => 'KTP Pemohon', 'field' => 'ktp_pemohon', 'icon' => 'fa-id-card', 'color' => 'green'];
                            $dokumen[] = ['label' => 'KK Pemohon', 'field' => 'kk_pemohon', 'icon' => 'fa-users', 'color' => 'green'];
                            $dokumen[] = ['label' => 'Buku Nikah', 'field' => 'fotokopi_buku_nikah', 'icon' => 'fa-book', 'color' => 'red'];
                            $dokumen[] = ['label' => 'KK Lama', 'field' => 'kk_lama', 'icon' => 'fa-users', 'color' => 'gray'];
                        }
                    @endphp
                    
                    @foreach($dokumen as $dok)
                    <div class="border border-gray-200 rounded-xl p-4 flex flex-col justify-between hover:shadow-md transition-all bg-gray-50/50">
                        <div class="flex items-start gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center bg-{{ $dok['color'] }}-100 text-{{ $dok['color'] }}-600 flex-shrink-0">
                                <i class="fas {{ $dok['icon'] }}"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800 leading-tight">{{ $dok['label'] }}</p>
                                @if($berkas->{$dok['field']})
                                    <p class="text-xs font-semibold text-green-600 mt-1"><i class="fas fa-check-circle mr-1"></i> Terunggah</p>
                                @else
                                    <p class="text-xs font-semibold text-red-500 mt-1"><i class="fas fa-times-circle mr-1"></i> Tidak Ada</p>
                                @endif
                            </div>
                        </div>
                        
                        @if($berkas->{$dok['field']})
                            <a href="{{ route('admin.lihat-berkas', [$berkas->uuid, $jenis, $dok['field']]) }}" target="_blank"
                            class="w-full bg-white border-2 border-blue-500 text-blue-600 hover:bg-blue-50 py-2 rounded-lg text-sm font-bold transition-colors text-center flex items-center justify-center">
                                <i class="fas fa-external-link-alt mr-2"></i> Buka Dokumen
                            </a>
                        @else
                            <button disabled class="w-full bg-gray-100 border-2 border-transparent text-gray-400 py-2 rounded-lg text-sm font-bold cursor-not-allowed">
                                Berkas Kosong
                            </button>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            @if($berkas->foto_wajah)
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mt-6">
                <h2 class="text-lg font-bold mb-4 text-gray-800 flex items-center gap-2">
                    <i class="fas fa-camera text-blue-500"></i> Foto Verifikasi Wajah
                </h2>
                <div class="flex items-center gap-6">
                    <img 
                        src="{{ route('admin.lihat-berkas', [$berkas->uuid, $jenis, 'foto_wajah']) }}"
                        alt="Foto Wajah Pemohon"
                        class="w-40 h-40 rounded-xl object-cover border-2 border-gray-200 shadow-sm"
                    >
                    <div class="text-sm text-gray-500">
                        <p class="font-bold text-gray-800 mb-1">Foto Verifikasi Liveness</p>
                        <p class="text-xs text-gray-400 mt-1">Diambil otomatis saat kedipan mata ke-2 terdeteksi.</p>
                    </div>
                </div>
            </div>
            @endif

        </div>

    </div>
</div>
@endsection