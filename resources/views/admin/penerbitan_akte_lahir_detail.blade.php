@extends('layouts.admin')

@section('content')
<div class="container-fluid p-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Detail Permohonan Akte Lahir
        </h1>
        <a href="{{ route('admin.penerbitan-akte-lahir') }}"
        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm shadow">
            Kembali
        </a>
    </div>

    <div class="space-y-6">

        <!-- DATA PELAPOR -->
        <div class="bg-white p-6 rounded-xl shadow border">
            <h2 class="font-semibold mb-3 border-b pb-2">Data Pelapor</h2>
            <div class="grid md:grid-cols-2 gap-3 text-sm">
                <p><b>Nama:</b> {{ $berkas->nama_pelapor }}</p>
                <p><b>NIK:</b> {{ $berkas->nik_pelapor }}</p>
                <p><b>No Dokumen:</b> {{ $berkas->nomor_dokumen }}</p>
                <p><b>No KK:</b> {{ $berkas->nomor_kk }}</p>
                <p><b>Kewarganegaraan:</b> {{ $berkas->kewarganegaraan_pelapor }}</p>
                <p><b>No Registrasi:</b> {{ $berkas->nomor_registrasi }}</p>
                <p><b>Status:</b> {{ $berkas->status }}</p>
            </div>
        </div>

        <!-- DATA SAKSI -->
        <div class="bg-white p-6 rounded-xl shadow border">
            <h2 class="font-semibold mb-3 border-b pb-2">Data Saksi</h2>
            <div class="grid md:grid-cols-2 gap-3 text-sm">
                <p><b>Nama Saksi 1:</b> {{ $berkas->nama_saksi1 }}</p>
                <p><b>NIK Saksi 1:</b> {{ $berkas->nik_saksi1 }}</p>
                <p><b>No KK Saksi 1:</b> {{ $berkas->nomor_kk_saksi1 }}</p>
                <p><b>Kewarganegaraan Saksi 1:</b> {{ $berkas->kewarganegaraan_saksi1 }}</p>

                <p><b>Nama Saksi 2:</b> {{ $berkas->nama_saksi2 }}</p>
                <p><b>NIK Saksi 2:</b> {{ $berkas->nik_saksi2 }}</p>
                <p><b>No KK Saksi 2:</b> {{ $berkas->nomor_kk_saksi2 }}</p>
                <p><b>Kewarganegaraan Saksi 2:</b> {{ $berkas->kewarganegaraan_saksi2 }}</p>
            </div>
        </div>

        <!-- DATA AYAH -->
        <div class="bg-white p-6 rounded-xl shadow border">
            <h2 class="font-semibold mb-3 border-b pb-2">Data Ayah</h2>
            <div class="grid md:grid-cols-2 gap-3 text-sm">
                <p><b>Nama:</b> {{ $berkas->nama_ayah }}</p>
                <p><b>NIK:</b> {{ $berkas->nik_ayah }}</p>
                <p><b>Tempat Lahir:</b> {{ $berkas->tempat_lahir_ayah }}</p>
                <p><b>Tanggal Lahir:</b> {{ $berkas->tanggal_lahir_ayah }}</p>
                <p><b>Kewarganegaraan:</b> {{ $berkas->kewarganegaraan_ayah }}</p>
            </div>
        </div>

        <!-- DATA IBU -->
        <div class="bg-white p-6 rounded-xl shadow border">
            <h2 class="font-semibold mb-3 border-b pb-2">Data Ibu</h2>
            <div class="grid md:grid-cols-2 gap-3 text-sm">
                <p><b>Nama:</b> {{ $berkas->nama_ibu }}</p>
                <p><b>NIK:</b> {{ $berkas->nik_ibu }}</p>
                <p><b>Tempat Lahir:</b> {{ $berkas->tempat_lahir_ibu }}</p>
                <p><b>Tanggal Lahir:</b> {{ $berkas->tanggal_lahir_ibu }}</p>
                <p><b>Kewarganegaraan:</b> {{ $berkas->kewarganegaraan_ibu }}</p>
            </div>
        </div>

        <!-- DATA ANAK -->
        <div class="bg-white p-6 rounded-xl shadow border">
            <h2 class="font-semibold mb-3 border-b pb-2">Data Anak</h2>
            <div class="grid md:grid-cols-2 gap-3 text-sm">
                <p><b>Nama:</b> {{ $berkas->nama_anak }}</p>
                <p><b>Jenis Kelamin:</b> {{ $berkas->jenis_kelamin }}</p>
                <p><b>Tempat Dilahirkan:</b> {{ $berkas->tempat_dilahirkan }}</p>
                <p><b>Tempat Kelahiran:</b> {{ $berkas->tempat_kelahiran }}</p>
                <p><b>Tanggal Lahir:</b> {{ $berkas->hari_tanggal_lahir }}</p>
                <p><b>Pukul:</b> {{ $berkas->pukul }}</p>
                <p><b>Jenis Kelahiran:</b> {{ $berkas->jenis_kelahiran }}</p>
                <p><b>Kelahiran Ke:</b> {{ $berkas->kelahiran_ke }}</p>
                <p><b>Penolong:</b> {{ $berkas->penolong }}</p>
                <p><b>Berat Bayi:</b> {{ $berkas->berat_bayi }}</p>
                <p><b>Panjang Bayi:</b> {{ $berkas->panjang_bayi }}</p>
            </div>
        </div>

        <!-- DOKUMEN -->
        <div class="bg-white p-6 rounded-xl shadow border">
            <h2 class="font-semibold mb-3 border-b pb-2">Dokumen</h2>

            <div class="grid md:grid-cols-3 gap-3 text-sm">

                <a href="{{ asset('storage/'.$berkas->file_surat_lahir) }}" target="_blank" class="bg-blue-500 text-white p-2 rounded text-center">
                    Surat Kelahiran
                </a>

                <a href="{{ asset('storage/'.$berkas->file_buku_nikah) }}" target="_blank" class="bg-blue-500 text-white p-2 rounded text-center">
                    Buku Nikah
                </a>

                <a href="{{ asset('storage/'.$berkas->file_kk) }}" target="_blank" class="bg-blue-500 text-white p-2 rounded text-center">
                    Kartu Keluarga
                </a>

                @if($berkas->file_sptjm_kelahiran)
                <a href="{{ asset('storage/'.$berkas->file_sptjm_kelahiran) }}" target="_blank" class="bg-gray-500 text-white p-2 rounded text-center">
                    SPTJM Kelahiran
                </a>
                @endif

                @if($berkas->file_sptjm_pasutri)
                <a href="{{ asset('storage/'.$berkas->file_sptjm_pasutri) }}" target="_blank" class="bg-gray-500 text-white p-2 rounded text-center">
                    SPTJM Pasutri
                </a>
                @endif

                @if($berkas->file_berita_acara_polisi)
                <a href="{{ asset('storage/'.$berkas->file_berita_acara_polisi) }}" target="_blank" class="bg-gray-500 text-white p-2 rounded text-center">
                    Berita Acara Polisi
                </a>
                @endif

            </div>
        </div>

        <!-- PENOLAKAN -->
        @if($berkas->alasan_penolakan)
        <div class="bg-red-100 p-4 rounded-lg text-red-700">
            <b>Alasan Penolakan:</b> {{ $berkas->alasan_penolakan }}
        </div>
        @endif

    </div>
</div>
@endsection