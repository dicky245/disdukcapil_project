@extends('layouts.admin')
@section('content')
<div class="container-fluid p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Detail Permohonan Akte Lahir
        </h1>
        <a href="{{ route('admin.penerbitan-akte-lahir') }}"
        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm">
            Kembali
        </a>
    </div>
    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-500"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-blue-700 font-semibold">
                    Seluruh dokumen persyaratan untuk mengurus akta kelahiran yang telah di unggah pengguna.
                </p>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white p-6 rounded-xl shadow border">
                <h2 class="text-lg font-semibold mb-6 text-gray-700">
                    Informasi Pemohon
                </h2>
                <div class="space-y-4 text-sm">
                    <div class="border-b pb-2">
                        <p class="text-gray-500 text-xs mb-1">Nama</p>
                        <p class="font-semibold text-base text-gray-800">{{ $berkas->nama_pemohon }}</p>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-500">NIK</span>
                        <span class="font-semibold">{{ $berkas->nik_pemohon }}</span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-500">No. KK</span>
                        <span class="font-semibold">{{ $berkas->nomor_kk_pemohon ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-500">No. Antrian</span>
                        <span class="font-semibold text-blue-600">{{ $berkas->nomor_antrian }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Tanggal Pengajuan</span>
                        <span class="font-semibold">{{ $berkas->created_at->format('d M Y - H:i') }}</span>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow border">
                <h2 class="text-lg font-semibold mb-4 text-gray-700">
                    Status Pengajuan
                </h2>
                <div class="text-center p-3 rounded-lg border 
                    {{ $berkas->status == 'Tolak' ? 'bg-red-50 border-red-200 text-red-700' : 'bg-blue-50 border-blue-200 text-blue-700' }}">
                    <p class="text-xs uppercase tracking-wider mb-1">Status</p>
                    <p class="text-lg font-bold">{{ $berkas->status }}</p>
                </div>
                @if($berkas->status == 'Tolak')
                <div class="mt-4 p-3 bg-red-100 rounded-lg text-sm text-red-800">
                    <strong>Alasan Penolakan:</strong><br>
                    {{ $berkas->alasan_penolakan }}
                </div>
                @endif
            </div>
        </div>
        <div class="lg:col-span-2">
            <div class="bg-white p-6 rounded-xl shadow border h-full">
                <h2 class="text-lg font-semibold mb-6 text-gray-700">
                    Dokumen Persyaratan
                </h2>
                @php
                $dokumen = [
                    ['label' => 'Formulir F-2.01 (Wajib)', 'field' => 'formulir_f201', 'icon' => 'fa-file-signature', 'color' => 'blue'],
                    ['label' => 'KTP Pemohon (Wajib)', 'field' => 'ktp_pemohon', 'icon' => 'fa-id-card', 'color' => 'green'],
                    ['label' => 'KTP Saksi 1 (Wajib)', 'field' => 'ktp_saksi1', 'icon' => 'fa-user-check', 'color' => 'green'],
                    ['label' => 'KTP Saksi 2 (Wajib)', 'field' => 'ktp_saksi2', 'icon' => 'fa-user-check', 'color' => 'green'],
                    ['label' => 'KK Pemohon (Wajib)', 'field' => 'kk_pemohon', 'icon' => 'fa-users', 'color' => 'green'],
                    ['label' => 'Surat Kelahiran (Wajib)', 'field' => 'file_surat_lahir', 'icon' => 'fa-file-medical', 'color' => 'blue'],
                    ['label' => 'Buku Nikah (Wajib)', 'field' => 'file_buku_nikah', 'icon' => 'fa-book', 'color' => 'green'],
                    ['label' => 'SPTJM Kelahiran (Opsional)', 'field' => 'file_sptjm_kelahiran', 'icon' => 'fa-file-signature', 'color' => 'gray'],
                    ['label' => 'SPTJM Pasutri (Opsional)', 'field' => 'file_sptjm_pasutri', 'icon' => 'fa-file-signature', 'color' => 'gray'],
                    ['label' => 'Berita Acara Polisi (Opsional)', 'field' => 'file_berita_acara_polisi', 'icon' => 'fa-file-alt', 'color' => 'gray'],
                ];
                @endphp
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($dokumen as $dok)
                    <div class="border rounded-xl p-4 flex flex-col justify-between hover:shadow-md transition bg-gray-50">
                        <div class="flex items-start gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center bg-{{ $dok['color'] }}-100 text-{{ $dok['color'] }}-600">
                                <i class="fas {{ $dok['icon'] }}"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800">{{ $dok['label'] }}</p>
                                @if($berkas->{$dok['field']})
                                    <p class="text-xs text-green-600 mt-1">
                                        <i class="fas fa-check-circle mr-1"></i> Terunggah
                                    </p>
                                @else
                                    <p class="text-xs text-red-500 mt-1">
                                        <i class="fas fa-times-circle mr-1"></i> Tidak Ada
                                    </p>
                                @endif
                            </div>
                        </div>
                        @if($berkas->{$dok['field']})
                            <a href="{{ route('admin.lihat-berkas-akta-lahir', [$berkas->uuid, $dok['field']]) }}" target="_blank"
                            class="w-full bg-white border-2 border-blue-500 text-blue-600 hover:bg-blue-50 py-2 rounded-lg text-sm font-semibold text-center flex items-center justify-center">
                                <i class="fas fa-external-link-alt mr-2"></i> Buka Dokumen
                            </a>
                        @else
                            <button disabled class="w-full bg-gray-200 text-gray-400 py-2 rounded-lg text-sm font-semibold cursor-not-allowed">
                                Berkas Kosong
                            </button>
                        @endif
                    </div>
                    @endforeach
                </div>
                @if($berkas->foto_wajah)
                <div class="mt-6 border-t pt-6">
                    <h3 class="text-md font-semibold mb-4">Foto Verifikasi Wajah</h3>
                    <img 
                        src="{{ route('admin.lihat-berkas-akta-lahir', [$berkas->uuid, 'foto_wajah']) }}"
                        class="w-40 h-40 rounded-xl object-cover border shadow"
                    >
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection