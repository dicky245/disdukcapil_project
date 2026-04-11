@extends('layouts.admin')

@section('content')
<div class="container-fluid p-6">
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
                    <span class="font-semibold">{{ $berkas->nama }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-500">Nomor Registrasi</span>
                    <span class="font-semibold">{{ $berkas->nomor_registrasi }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-500">Alamat</span>
                    <span class="font-semibold">{{ $berkas->alamat }}</span>
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
                        'label' => 'KK Lama',
                        'field' => 'kk_lama'
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
                        'label' => 'Akta Kematian',
                        'field' => 'fotokopi_akta_kematian'
                    ])
                    @include('admin.partials.dokumen', [
                        'label' => 'KK Lama',
                        'field' => 'kk_lama'
                    ])
                    @if($berkas->surat_pernyataan_wali)
                        @include('admin.partials.dokumen', [
                            'label' => 'Surat Pernyataan Wali',
                            'field' => 'surat_pernyataan_wali'
                        ])
                    @endif
                @endif
                @if($jenis == 'Hilang/Rusak')
                    @include('admin.partials.dokumen', [
                        'label' => 'Fotokopi KTP',
                        'field' => 'fotokopi_ktp'
                    ])
                    @if($berkas->fotokopi_izin_tinggal)
                        @include('admin.partials.dokumen', [
                            'label' => 'Izin Tinggal',
                            'field' => 'fotokopi_izin_tinggal'
                        ])
                    @endif
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
                        'label' => 'Buku Nikah',
                        'field' => 'fotokopi_buku_nikah'
                    ])
                    @include('admin.partials.dokumen', [
                        'label' => 'KK Lama',
                        'field' => 'kk_lama'
                    ])
                @endif
            </div>
        </div>
    </div>
</div>
@endsection