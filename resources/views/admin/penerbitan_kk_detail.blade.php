@extends('layouts.admin')

@section('content')
<div class="container-fluid p-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Detail Permohonan Kartu Keluarga
        </h1>
        <a href="{{ route('admin.penerbitan-kk') }}"
        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm">
            Kembali
        </a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-xl shadow border">
            <h2 class="text-lg font-semibold mb-6 text-gray-700">
                Informasi Pemohon
            </h2>
            <div class="space-y-4 text-sm">
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-500">Nama Pemohon</span>
                    <span class="font-semibold">{{ $berkas->nama_pemohon }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-500">Nomor Antrian</span>
                    <span class="font-semibold">{{ $berkas->nomor_antrian }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-500">Alamat</span>
                    <span class="font-semibold">{{ $berkas->alamat_pemohon }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-500">Jenis Layanan</span>
                    <span class="font-semibold">{{ $jenis }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-500">Tanggal Pengajuan</span>
                    <span class="font-semibold">
                        {{ $berkas->created_at->format('d M Y') }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Status</span>
                    <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700 font-semibold">
                        {{ $berkas->status }}
                    </span>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow border">
            <h2 class="text-lg font-semibold mb-6 text-gray-700">
                Dokumen Persyaratan
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @if($jenis == 'Perubahan Data')
                    @include('admin.partials.dokumen', [
                        'label' => 'Formulir F-1.02',
                        'field' => 'formulir_f102'
                    ])
                    @include('admin.partials.dokumen', [
                        'label' => 'KTP Pemohon',
                        'field' => 'ktp_pemohon'
                    ])
                    @include('admin.partials.dokumen', [
                        'label' => 'KK Pemohon',
                        'field' => 'kk_pemohon'
                    ])
                    @include('admin.partials.dokumen', [
                        'label' => 'Formulir F-1.06',
                        'field' => 'formulir_f106'
                    ])
                    @include('admin.partials.dokumen', [
                        'label' => 'Suket Perubahan',
                        'field' => 'surat_keterangan_perubahan'
                    ])

                    @if($berkas->pernyataan_pindah_kk)
                        @include('admin.partials.dokumen', [
                            'label' => 'Pernyataan Pindah KK',
                            'field' => 'pernyataan_pindah_kk'
                        ])
                    @endif
                @endif

                @if($jenis == 'Ganti Kepala')
                    @include('admin.partials.dokumen', [
                        'label' => 'Formulir F-1.02',
                        'field' => 'formulir_f102'
                    ])
                    @include('admin.partials.dokumen', [
                        'label' => 'KTP Pemohon',
                        'field' => 'ktp_pemohon'
                    ])
                    @include('admin.partials.dokumen', [
                        'label' => 'KK Pemohon',
                        'field' => 'kk_pemohon'
                    ])
                    @include('admin.partials.dokumen', [
                        'label' => 'Akta Kematian',
                        'field' => 'fotokopi_akta_kematian'
                    ])

                    @if($berkas->surat_pernyataan_wali)
                        @include('admin.partials.dokumen', [
                            'label' => 'Surat Pernyataan Wali',
                            'field' => 'surat_pernyataan_wali'
                        ])
                    @endif
                @endif

                @if($jenis == 'Hilang Rusak')
                    @include('admin.partials.dokumen', [
                        'label' => 'Formulir F-1.02',
                        'field' => 'formulir_f102'
                    ])
                    @include('admin.partials.dokumen', [
                        'label' => 'KTP Pemohon',
                        'field' => 'ktp_pemohon'
                    ])
                    @include('admin.partials.dokumen', [
                        'label' => 'Surat Kehilangan/Rusak',
                        'field' => 'suket_hilang_rusak'
                    ])
                @endif

                @if($jenis == 'Pisah KK')
                    @include('admin.partials.dokumen', [
                        'label' => 'Formulir F-1.02',
                        'field' => 'formulir_f102'
                    ])
                    @include('admin.partials.dokumen', [
                        'label' => 'KTP Pemohon',
                        'field' => 'ktp_pemohon'
                    ])
                    @include('admin.partials.dokumen', [
                        'label' => 'KK Pemohon',
                        'field' => 'kk_pemohon'
                    ])
                    @include('admin.partials.dokumen', [
                        'label' => 'Buku Nikah',
                        'field' => 'fotokopi_buku_nikah'
                    ])
                    @include('admin.partials.dokumen', [
                        'label' => 'KK Lama',
                        'field' => 'kk_lama'
                    ])
                @endif
            </div>
            @if($berkas->foto_wajah)
            <div class="bg-white p-6 rounded-xl shadow border mt-6">
                <h2 class="text-lg font-semibold mb-4 text-gray-700">
                    Foto Verifikasi Wajah
                </h2>
                <div class="flex items-center gap-6">
                    <img 
                        src="{{ route('admin.lihat-berkas', [$berkas->uuid, $jenis, 'foto_wajah']) }}"
                        alt="Foto Wajah Pemohon"
                        class="w-40 h-40 rounded-xl object-cover border-2 border-gray-200 shadow"
                    >
                    <div class="text-sm text-gray-500">
                        <p class="font-semibold text-gray-700 mb-1">Foto Verifikasi Liveness</p>
                        <p class="text-xs text-gray-400 mt-1">Diambil otomatis saat kedipan mata ke-2 terdeteksi.</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection