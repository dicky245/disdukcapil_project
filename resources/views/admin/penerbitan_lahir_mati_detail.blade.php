@extends('layouts.admin')
@section('content')
<div class="container-fluid p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Detail Permohonan Lahir Mati
        </h1>
        <a href="{{ route('admin.penerbitan-lahir-mati') }}"
        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm">
            Kembali
        </a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Informasi Bayi --}}
        <div class="bg-white p-6 rounded-xl shadow border">
            <h2 class="text-lg font-semibold mb-6 text-gray-700">
                Informasi Bayi
            </h2>
            <div class="space-y-4 text-sm">
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-500">Nama Bayi</span>
                    <span class="font-semibold">{{ $berkas->nama_bayi }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-500">Jenis Kelamin</span>
                    <span class="font-semibold">{{ $berkas->jenis_kelamin }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-500">Tanggal & Waktu Lahir</span>
                    <span class="font-semibold">{{ \Carbon\Carbon::parse($berkas->tgl_lahir)->format('d M Y H:i') }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-500">Tempat Lahir</span>
                    <span class="font-semibold">{{ $berkas->tempat_lahir }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-500">Keterangan</span>
                    <span class="font-semibold">{{ $berkas->keterangan ?? '-' }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-500">Tanggal Pengajuan</span>
                    <span class="font-semibold">{{ $berkas->created_at->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Status</span>
                    <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700 font-semibold">
                        {{ $berkas->status }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Informasi Orang Tua + Dokumen --}}
        <div class="bg-white p-6 rounded-xl shadow border">
            <h2 class="text-lg font-semibold mb-6 text-gray-700">
                Informasi Orang Tua
            </h2>
            <div class="space-y-4 text-sm">
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-500">Nama Ayah</span>
                    <span class="font-semibold">{{ $berkas->nama_ayah }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-500">NIK Ayah</span>
                    <span class="font-semibold">{{ $berkas->nik_ayah }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-500">Nama Ibu</span>
                    <span class="font-semibold">{{ $berkas->nama_ibu }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">NIK Ibu</span>
                    <span class="font-semibold">{{ $berkas->nik_ibu }}</span>
                </div>
            </div>

            <h2 class="text-lg font-semibold mt-8 mb-6 text-gray-700">
                Dokumen Persyaratan
            </h2>
            <div class="grid grid-cols-1 gap-4">
                @php
                    $dokumen = [
                        ['label' => 'Surat Keterangan Lahir Mati', 'field' => 'surat_keterangan_lahir_mati'],
                        ['label' => 'KTP Ayah', 'field' => 'ktp_ayah'],
                        ['label' => 'KTP Ibu', 'field' => 'ktp_ibu'],
                    ];
                @endphp
                @foreach($dokumen as $dok)
                <div class="border rounded-lg p-4 text-center">
                    <p class="text-sm font-semibold mb-3">{{ $dok['label'] }}</p>
                    @if($berkas->{$dok['field']})
                        <button onclick="openPreview('{{ asset('storage/'.$berkas->{$dok['field']}) }}')"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg text-sm">
                            Lihat Berkas
                        </button>
                    @else
                        <span class="text-gray-400 text-sm">Tidak diupload</span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- Preview Modal --}}
<div id="previewModal"
class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">
    <div class="bg-white w-11/12 md:w-3/4 h-5/6 rounded-xl relative p-4">
        <button onclick="closePreview()"
        class="absolute top-3 right-3 bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
            Tutup
        </button>
        <iframe id="previewFrame"
        class="w-full h-full rounded-lg"></iframe>
    </div>
</div>
<script>
function openPreview(fileUrl){
    document.getElementById("previewFrame").src = fileUrl;
    const modal = document.getElementById("previewModal");
    modal.classList.remove("hidden");
    modal.classList.add("flex");
}
function closePreview(){
    const modal = document.getElementById("previewModal");
    modal.classList.remove("flex");
    modal.classList.add("hidden");
    document.getElementById("previewFrame").src = "";
}
</script>
@endsection
