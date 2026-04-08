@extends('layouts.admin')

@section('content')
<div class="container-fluid p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Detail Permohonan Akte Lahir
        </h1>
        <a href="{{ route('admin.penerbitan-akte-lahir') }}"
        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm shadow">
            Kembali
        </a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-xl shadow border">
            <h2 class="text-lg font-semibold mb-6 text-gray-700 border-b pb-3">
                Informasi Pemohon
            </h2>
            <div class="space-y-4 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Nama Pemohon</span>
                    <span class="font-semibold text-gray-800">{{ $berkas->nama }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Nomor Registrasi</span>
                    <span class="font-semibold text-gray-800">{{ $berkas->nomor_registrasi }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Alamat</span>
                    <span class="font-semibold text-gray-800">{{ $berkas->alamat }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Tanggal Pengajuan</span>
                    <span class="font-semibold text-gray-800">
                        {{ $berkas->created_at->format('d M Y') }}
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-500">Status</span>
                    <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700 font-semibold">
                        {{ $berkas->status }}
                    </span>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow border">
            <h2 class="text-lg font-semibold mb-6 text-gray-700 border-b pb-3">
                Dokumen Persyaratan
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="border rounded-lg p-4 text-center hover:shadow">
                    <p class="text-sm font-semibold mb-3">
                        Fotokopi Buku Nikah
                    </p>
                    <a href="{{ asset('storage/'.$berkas->fotokopi_buku_nikah) }}"
                    target="_blank"
                    class="block w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg text-sm">
                        Lihat Berkas
                    </a>
                </div>
                <div class="border rounded-lg p-4 text-center hover:shadow">
                    <p class="text-sm font-semibold mb-3">
                        Surat Bidan
                    </p>
                    <a href="{{ asset('storage/'.$berkas->surat_bidan) }}"
                    target="_blank"
                    class="block w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg text-sm">
                        Lihat Berkas
                    </a>
                </div>
                <div class="border rounded-lg p-4 text-center hover:shadow">
                    <p class="text-sm font-semibold mb-3">
                        Foto KTP Orang Tua
                    </p>
                    <a href="{{ asset('storage/'.$berkas->ktp_orangtua) }}"
                    target="_blank"
                    class="block w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg text-sm">
                        Lihat Berkas
                    </a>
                </div>
                <div class="border rounded-lg p-4 text-center hover:shadow">
                    <p class="text-sm font-semibold mb-3">
                        Fotokopi Kartu Keluarga
                    </p>
                    <a href="{{ asset('storage/'.$berkas->fotokopi_kk) }}"
                    target="_blank"
                    class="block w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg text-sm">
                        Lihat Berkas
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="previewModal"
class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">
    <div class="bg-white w-[90%] md:w-[70%] h-[85%] rounded-xl shadow-lg flex flex-col">
        <div class="flex justify-between items-center border-b p-3">
            <h3 class="font-semibold text-gray-700">Preview Dokumen</h3>
            <button onclick="closePreview()"
            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                Tutup
            </button>
        </div>
        <div class="flex-1 overflow-hidden">
            <iframe id="previewFrame"
            class="w-full h-full border-0"></iframe>
        </div>
    </div>
</div>
@endsection