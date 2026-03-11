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
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="border rounded-lg p-4 flex flex-col items-center text-center">
                    <p class="text-sm font-semibold mb-3">
                        Kartu Keluarga Lama
                    </p>
                    <a href="{{ asset('storage/'.$berkas->kk_lama) }}" target="_blank"
                    target="_blank"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg text-sm">
                        Lihat Berkas
                    </a>
                </div>
                <div class="border rounded-lg p-4 flex flex-col items-center text-center">
                    <p class="text-sm font-semibold mb-3">
                        Surat Keterangan Pengganti
                    </p>
                    <a href="{{ asset('storage/'.$berkas->surat_keterangan_pengganti) }}"
                    target="_blank"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg text-sm">
                        Lihat Berkas
                    </a>
                </div>
                <div class="border rounded-lg p-4 flex flex-col items-center text-center">
                    <p class="text-sm font-semibold mb-3">
                        Salinan Keterangan Presiden
                    </p>
                    <a href="{{ asset('storage/'.$berkas->salinan_kepres) }}"
                    target="_blank"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg text-sm">
                        Lihat Berkas
                    </a>
                </div>
                <div class="border rounded-lg p-4 flex flex-col items-center text-center">
                    <p class="text-sm font-semibold mb-3">
                        Izin Tinggal Bagi Asing
                    </p>
                    <a href="{{ asset('storage/'.$berkas->izin_tinggal_asing) }}"
                    target="_blank"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg text-sm">
                        Lihat Berkas
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection