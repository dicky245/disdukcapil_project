@extends('layouts.admin')

@section('content')
<div class="container-fluid p-6 bg-gray-50 min-h-screen">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Kelola Penerbitan Lahir Mati</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-4xl font-bold text-blue-700">{{ $jumlah }}</h3>
            <p class="text-gray-500 text-sm mt-1">Total Permohonan</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-4xl font-bold text-blue-700">{{ $menungguVerifikasi }}</h3>
            <p class="text-gray-500 text-sm mt-1">Menunggu Verifikasi</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-4xl font-bold text-blue-700">{{ $dalamProses }}</h3>
            <p class="text-gray-500 text-sm mt-1">Dalam Proses</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-4xl font-bold text-blue-700">{{ $selesai }}</h3>
            <p class="text-gray-500 text-sm mt-1">Selesai</p>
        </div>
    </div>

    <form method="GET" action="">
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6 flex items-center gap-4">
        <div class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
            </svg>
            <span class="font-semibold text-gray-700">Filter:</span>
        </div>
        <select name="status" class="border border-gray-300 rounded-lg px-4 py-2 text-sm">
            <option value="">Semua Status</option>
            <option value="Dokumen Diterima" {{ request('status') == 'Dokumen Diterima' ? 'selected' : '' }}>Dokumen Diterima</option>
            <option value="Verifikasi Data" {{ request('status') == 'Verifikasi Data' ? 'selected' : '' }}>Verifikasi Data</option>
            <option value="Proses Cetak" {{ request('status') == 'Proses Cetak' ? 'selected' : '' }}>Proses Cetak</option>
            <option value="Siap Pengambilan" {{ request('status') == 'Siap Pengambilan' ? 'selected' : '' }}>Siap Pengambilan</option>
            <option value="Tolak" {{ request('status') == 'Tolak' ? 'selected' : '' }}>Ditolak</option>
        </select>
        <button class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm">Terapkan</button>
    </div>
    </form>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-blue-700 text-white">
                    <th class="p-4 font-semibold uppercase text-xs">No</th>
                    <th class="p-4 font-semibold uppercase text-xs">Nomor Antrian</th>
                    <th class="p-4 font-semibold uppercase text-xs">Nama Pemohon</th>
                    <th class="p-4 font-semibold uppercase text-xs">NIK Pemohon</th>
                    <th class="p-4 font-semibold uppercase text-xs">Tgl Pengajuan</th>
                    <th class="p-4 font-semibold uppercase text-xs text-center">Status</th>
                    <th class="p-4 font-semibold uppercase text-xs text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($dataLahirMati as $data)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="p-4 text-sm text-gray-700">{{ $loop->iteration }}</td>
                    <td class="p-4 text-sm text-gray-700">{{ $data->nomor_antrian }}</td>
                    <td class="p-4 text-sm font-bold text-gray-800">{{ $data->nama_pemohon }}</td>
                    <td class="p-4 text-sm text-gray-700">{{ $data->nik_pemohon }}</td>
                    <td class="p-4 text-sm text-gray-700">{{ $data->created_at->format('d M Y') }}</td>
                    <td class="p-4 text-center">
                        @php
                            $statusColor = match($data->status) {
                                'Dokumen Diterima' => 'bg-orange-50 text-orange-600 border-orange-100',
                                'Verifikasi Data' => 'bg-blue-50 text-blue-600 border-blue-100',
                                'Proses Cetak' => 'bg-yellow-50 text-yellow-600 border-yellow-100',
                                'Siap Pengambilan' => 'bg-green-50 text-green-600 border-green-100',
                                'Tolak' => 'bg-red-50 text-red-600 border-red-100',
                                default => 'bg-gray-50 text-gray-600 border-gray-100',
                            };
                        @endphp
                        <span class="{{ $statusColor }} px-3 py-1 rounded-full text-xs font-bold border">
                            {{ $data->status }}
                        </span>
                    </td>
                    <td class="p-4">
                        <div class="flex flex-col gap-1 items-center">
                            <a href="{{ route('admin.lahir-mati.detail', $data->uuid) }}"
                            class="w-28 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-3 py-1 rounded-lg text-xs font-semibold text-center transition">
                                Cek Berkas
                            </a>
                            @if($data->status == 'Dokumen Diterima')
                                <form action="{{ route('admin.lahir-mati.status', $data->uuid) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="Verifikasi Data">
                                    <button class="w-28 bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-1 rounded-lg text-xs font-semibold">Verifikasi</button>
                                </form>
                                <form action="{{ route('admin.lahir-mati.status', $data->uuid) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="Tolak">
                                    <button class="w-28 bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-xs font-semibold">Tolak</button>
                                </form>
                            @endif
                            @if($data->status == 'Verifikasi Data')
                                <form action="{{ route('admin.lahir-mati.status', $data->uuid) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="Proses Cetak">
                                    <button class="w-28 bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-xs font-semibold">Proses Cetak</button>
                                </form>
                            @endif
                            @if($data->status == 'Proses Cetak')
                                <form action="{{ route('admin.lahir-mati.status', $data->uuid) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="Siap Pengambilan">
                                    <button class="w-28 bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg text-xs font-semibold">Siap Diambil</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-8 text-center text-gray-400">
                        <div class="text-4xl mb-2"><i class="fas fa-clipboard-list"></i></div>
                        <p class="font-semibold">Belum ada permohonan lahir mati</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection