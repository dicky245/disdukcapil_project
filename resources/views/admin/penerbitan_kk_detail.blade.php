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
            <div class="grid grid-cols-2 md:grid-cols-2 gap-4">
                <div class="border rounded-lg p-4 text-center">
                    <p class="text-sm font-semibold mb-3">
                        Kartu Keluarga Lama
                    </p>
                    <button onclick="openPreview('{{ asset('storage/'.$berkas->kk_lama) }}')"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg text-sm">
                        Lihat Berkas
                    </button>
                </div>
                <div class="border rounded-lg p-4 text-center">
                    <p class="text-sm font-semibold mb-3">
                        Surat Keterangan Pengganti
                    </p>
                    <button onclick="openPreview('{{ asset('storage/'.$berkas->surat_keterangan_pengganti) }}')"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg text-sm">
                        Lihat Berkas
                    </button>
                </div>
                <div class="border rounded-lg p-4 text-center">
                    <p class="text-sm font-semibold mb-3">
                        Salinan Kepres
                    </p>
                    <button onclick="openPreview('{{ asset('storage/'.$berkas->salinan_kepres) }}')"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg text-sm">
                        Lihat Berkas
                    </button>
                </div>
                <div class="border rounded-lg p-4 text-center">
                    <p class="text-sm font-semibold mb-3">
                        Izin Tinggal Asing
                    </p>
                    <button onclick="openPreview('{{ asset('storage/'.$berkas->izin_tinggal_asing) }}')"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg text-sm">
                        Lihat Berkas
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
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