@extends('layouts.admin')

@section('content')
<div class="container-fluid p-6 bg-gray-50 min-h-screen">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Kelola Penerbitan Kartu Keluarga</h1>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-6 rounded-xl border">
            <h3 class="text-3xl font-bold text-blue-700">{{ $jumlahkk }}</h3>
            <p class="text-gray-500 text-sm">Total Permohonan</p>
        </div>
        <div class="bg-white p-6 rounded-xl border">
            <h3 class="text-3xl font-bold text-blue-700">{{ $menungguVerifikasi }}</h3>
            <p class="text-gray-500 text-sm">Menunggu Verifikasi</p>
        </div>
        <div class="bg-white p-6 rounded-xl border">
            <h3 class="text-3xl font-bold text-blue-700">{{ $dalamProses }}</h3>
            <p class="text-gray-500 text-sm">Dalam Proses</p>
        </div>
        <div class="bg-white p-6 rounded-xl border">
            <h3 class="text-3xl font-bold text-blue-700">{{ $selesai }}</h3>
            <p class="text-gray-500 text-sm">Selesai</p>
        </div>
    </div>
    <form method="GET" class="mb-6">
        <div class="bg-white p-4 rounded-xl border flex gap-3 items-center">
            <span class="font-semibold text-gray-700">Filter:</span>
            <select name="status" class="border rounded-lg px-3 py-2 text-sm">
                <option value="">Semua Status</option>
                <option value="Dokumen Diterima">Dokumen Diterima</option>
                <option value="Verifikasi Data">Verifikasi Data</option>
                <option value="Proses Cetak">Proses Cetak</option>
                <option value="Siap Pengambilan">Siap Pengambilan</option>
            </select>
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
                Terapkan
            </button>
        </div>
    </form>
    <div class="bg-white rounded-xl border overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-blue-700 text-white">
                <tr>
                    <th class="p-4 text-left">No</th>
                    <th class="p-4 text-left">Nama</th>
                    <th class="p-4 text-left">Alamat</th>
                    <th class="p-4 text-center">Status</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach ($datakk as $data)
                <tr class="hover:bg-gray-50">
                    <td class="p-4">{{ $loop->iteration }}</td>
                    <td class="p-4 font-semibold">{{ $data->nama }}</td>
                    <td class="p-4">{{ $data->alamat }}</td>
                    <td class="p-4 text-center">
                        <span class="px-3 py-1 rounded-full text-xs font-bold
                            @if($data->status == 'Dokumen Diterima') bg-gray-100 text-gray-700
                            @elseif($data->status == 'Verifikasi Data') bg-blue-100 text-blue-700
                            @elseif($data->status == 'Proses Cetak') bg-yellow-100 text-yellow-700
                            @elseif($data->status == 'Siap Pengambilan') bg-green-100 text-green-700
                            @elseif($data->status == 'Tolak') bg-red-100 text-red-700
                            @endif">
                            {{ $data->status }}
                        </span>
                    </td>
                    <td class="p-4 text-center">
                        <div class="flex flex-col gap-2 items-center">
                            <a href="{{ route('admin.detail', $data->uuid) }}"
                               class="w-28 bg-blue-600 text-white px-3 py-1 rounded text-xs">
                               Detail
                            </a>
                            @if($data->status == 'Dokumen Diterima')
                            <form action="{{ route('admin.status', $data->uuid) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="Verifikasi Data">
                                <button type="button" class="btn-status w-28 bg-green-500 text-white px-3 py-1 rounded text-xs">
                                    Verifikasi
                                </button>
                            </form>
                            <form action="{{ route('admin.status', $data->uuid) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="Tolak">
                                <input type="hidden" name="alasan" class="input-alasan">
                                <button type="button" class="btn-tolak w-28 bg-red-500 text-white px-3 py-1 rounded text-xs">
                                    Tolak
                                </button>
                            </form>
                            @endif
                            @if($data->status == 'Verifikasi Data')
                            <form action="{{ route('admin.status', $data->uuid) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="Proses Cetak">
                                <button type="button" class="btn-status w-28 bg-yellow-500 text-white px-3 py-1 rounded text-xs">
                                    Proses Cetak
                                </button>
                            </form>
                            @endif
                            @if($data->status == 'Proses Cetak')
                            <form action="{{ route('admin.status', $data->uuid) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="Siap Pengambilan">
                                <button type="button" class="btn-status w-28 bg-purple-500 text-white px-3 py-1 rounded text-xs">
                                    Siap Diambil
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@push('scripts')
<script>
document.querySelectorAll('.btn-status').forEach(btn => {
    btn.addEventListener('click', function () {
        let form = this.closest('form');
        let statusBaru = form.querySelector('input[name="status"]').value;
        SwalHelper.confirm(
            `Ubah status menjadi ${statusBaru}?`, 
            `Data ini akan diperbarui ke status: ${statusBaru}`,
            () => form.submit()
        );
    });
});
document.querySelectorAll('.btn-tolak').forEach(btn => {
    btn.addEventListener('click', function () {
        let form = this.closest('form');
        let alasan = form.querySelector('.input-alasan');
        Swal.fire({
            title: 'Konfirmasi Penolakan',
            text: 'Apakah Anda yakin ingin menolak permohonan ini?',
            input: 'textarea',
            inputPlaceholder: 'Masukkan alasan penolakan...',
            showCancelButton: true,
            confirmButtonText: 'Ya, Tolak',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#ef4444',
            inputValidator: (value) => {
                if (!value) return 'Alasan wajib diisi!';
            }
        }).then((result) => {
            if (result.isConfirmed) {
                alasan.value = result.value;
                form.submit();
            }
        });
    });
});
@if(session('success'))
    SwalHelper.success("{{ session('success') }}");
@endif
</script>
@endpush
@endsection