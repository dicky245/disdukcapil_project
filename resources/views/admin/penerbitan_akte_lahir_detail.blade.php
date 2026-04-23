@extends('layouts.admin')

@section('content')
<div class="container-fluid p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Detail Permohonan Akte Lahir
        </h1>
        <a href="{{ route('admin.penerbitan-akte-lahir') }}"
        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Kolom Kiri: Informasi Pelapor & Status --}}
        <div class="lg:col-span-1 space-y-6">
            
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h2 class="text-lg font-bold mb-5 text-gray-800 flex items-center gap-2">
                    <i class="fas fa-user-circle text-blue-500"></i> Data Pelapor
                </h2>
                <div class="space-y-3 text-sm">
                    <div class="grid grid-cols-3 border-b border-gray-50 pb-2">
                        <span class="text-gray-500 col-span-1">No. Registrasi</span>
                        <span class="font-bold text-blue-600 col-span-2 text-right">{{ $berkas->nomor_registrasi ?? '-' }}</span>
                    </div>
                    <div class="grid grid-cols-3 border-b border-gray-50 pb-2">
                        <span class="text-gray-500 col-span-1">Nama</span>
                        <span class="font-semibold text-gray-800 col-span-2 text-right">{{ $berkas->nama_pelapor }}</span>
                    </div>
                    <div class="grid grid-cols-3 border-b border-gray-50 pb-2">
                        <span class="text-gray-500 col-span-1">NIK</span>
                        <span class="font-semibold text-gray-800 col-span-2 text-right">{{ $berkas->nik_pelapor }}</span>
                    </div>
                    <div class="grid grid-cols-3 border-b border-gray-50 pb-2">
                        <span class="text-gray-500 col-span-1">No. Dokumen</span>
                        <span class="font-semibold text-gray-800 col-span-2 text-right">{{ $berkas->nomor_dokumen ?? '-' }}</span>
                    </div>
                    <div class="grid grid-cols-3 border-b border-gray-50 pb-2">
                        <span class="text-gray-500 col-span-1">No. KK</span>
                        <span class="font-semibold text-gray-800 col-span-2 text-right">{{ $berkas->nomor_kk ?? '-' }}</span>
                    </div>
                    <div class="grid grid-cols-3 pt-1">
                        <span class="text-gray-500 col-span-1">Warga Negara</span>
                        <span class="font-semibold text-gray-800 col-span-2 text-right">{{ $berkas->kewarganegaraan_pelapor }}</span>
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
                @if($berkas->status == 'Tolak' && $berkas->alasan_penolakan)
                <div class="mt-4 p-4 bg-red-50 border border-red-100 rounded-lg text-sm text-red-800">
                    <strong class="flex items-center gap-1 mb-1"><i class="fas fa-exclamation-triangle"></i> Alasan Penolakan:</strong>
                    <p class="leading-relaxed">{{ $berkas->alasan_penolakan }}</p>
                </div>
                @endif
            </div>

        </div>

        {{-- Kolom Kanan: Rincian Keluarga & Dokumen --}}
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h2 class="text-lg font-bold mb-4 text-gray-800 flex items-center gap-2">
                    <i class="fas fa-child text-blue-500"></i> Data Anak
                </h2>
                <div class="grid md:grid-cols-2 gap-4 text-sm bg-blue-50/50 p-4 rounded-lg">
                    <p><b>Nama:</b> {{ $berkas->nama_anak }}</p>
                    <p><b>Jenis Kelamin:</b> {{ $berkas->jenis_kelamin }}</p>
                    <p><b>Tgl Lahir:</b> {{ $berkas->hari_tanggal_lahir }} ({{ $berkas->pukul }})</p>
                    <p><b>Tempat Dilahirkan:</b> {{ $berkas->tempat_dilahirkan }}</p>
                    <p><b>Tempat Kelahiran:</b> {{ $berkas->tempat_kelahiran }}</p>
                    <p><b>Jenis Kelahiran:</b> {{ $berkas->jenis_kelahiran }}</p>
                    <p><b>Kelahiran Ke:</b> {{ $berkas->kelahiran_ke }}</p>
                    <p><b>Penolong:</b> {{ $berkas->penolong }}</p>
                    <p><b>Berat Bayi:</b> {{ $berkas->berat_bayi }} kg</p>
                    <p><b>Panjang Bayi:</b> {{ $berkas->panjang_bayi }} cm</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h2 class="font-bold mb-3 border-b border-gray-100 pb-2 text-gray-800"><i class="fas fa-male text-blue-500 mr-2"></i>Data Ayah</h2>
                    <div class="space-y-2 text-sm text-gray-700">
                        <p><b>Nama:</b> {{ $berkas->nama_ayah }}</p>
                        <p><b>NIK:</b> {{ $berkas->nik_ayah }}</p>
                        <p><b>Lahir:</b> {{ $berkas->tempat_lahir_ayah }}, {{ $berkas->tanggal_lahir_ayah }}</p>
                        <p><b>Kewarganegaraan:</b> {{ $berkas->kewarganegaraan_ayah }}</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h2 class="font-bold mb-3 border-b border-gray-100 pb-2 text-gray-800"><i class="fas fa-female text-blue-500 mr-2"></i>Data Ibu</h2>
                    <div class="space-y-2 text-sm text-gray-700">
                        <p><b>Nama:</b> {{ $berkas->nama_ibu }}</p>
                        <p><b>NIK:</b> {{ $berkas->nik_ibu }}</p>
                        <p><b>Lahir:</b> {{ $berkas->tempat_lahir_ibu }}, {{ $berkas->tanggal_lahir_ibu }}</p>
                        <p><b>Kewarganegaraan:</b> {{ $berkas->kewarganegaraan_ibu }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h2 class="text-lg font-bold mb-4 text-gray-800 flex items-center gap-2">
                    <i class="fas fa-users text-blue-500"></i> Data Saksi
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                        <p class="font-semibold mb-1 text-gray-800 border-b pb-1">Saksi 1</p>
                        <div class="space-y-1 mt-2">
                            <p><b>Nama:</b> {{ $berkas->nama_saksi1 }}</p>
                            <p><b>NIK:</b> {{ $berkas->nik_saksi1 }}</p>
                            <p><b>No KK:</b> {{ $berkas->nomor_kk_saksi1 }}</p>
                            <p><b>Warga Negara:</b> {{ $berkas->kewarganegaraan_saksi1 }}</p>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                        <p class="font-semibold mb-1 text-gray-800 border-b pb-1">Saksi 2</p>
                        <div class="space-y-1 mt-2">
                            <p><b>Nama:</b> {{ $berkas->nama_saksi2 }}</p>
                            <p><b>NIK:</b> {{ $berkas->nik_saksi2 }}</p>
                            <p><b>No KK:</b> {{ $berkas->nomor_kk_saksi2 }}</p>
                            <p><b>Warga Negara:</b> {{ $berkas->kewarganegaraan_saksi2 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h2 class="text-lg font-bold mb-6 text-gray-800 flex items-center gap-2">
                    <i class="fas fa-folder-open text-blue-500"></i> Dokumen Persyaratan
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @php
                        $dokumen = [
                            ['label' => 'Surat Kelahiran', 'field' => 'file_surat_lahir', 'icon' => 'fa-file-medical', 'color' => 'blue'],
                            ['label' => 'Buku Nikah', 'field' => 'file_buku_nikah', 'icon' => 'fa-book', 'color' => 'red'],
                            ['label' => 'Kartu Keluarga', 'field' => 'file_kk', 'icon' => 'fa-users', 'color' => 'green'],
                        ];
                        if($berkas->file_sptjm_kelahiran) $dokumen[] = ['label' => 'SPTJM Kelahiran', 'field' => 'file_sptjm_kelahiran', 'icon' => 'fa-file-signature', 'color' => 'yellow'];
                        if($berkas->file_sptjm_pasutri) $dokumen[] = ['label' => 'SPTJM Pasutri', 'field' => 'file_sptjm_pasutri', 'icon' => 'fa-file-signature', 'color' => 'yellow'];
                        if($berkas->file_berita_acara_polisi) $dokumen[] = ['label' => 'Berita Acara Polisi', 'field' => 'file_berita_acara_polisi', 'icon' => 'fa-shield-alt', 'color' => 'gray'];
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
                            <a href="{{ asset('storage/'.$berkas->{$dok['field']}) }}" target="_blank"
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

        </div>
    </div>
</div>
@endsection