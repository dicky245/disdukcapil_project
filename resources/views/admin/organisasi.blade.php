@extends('layouts.admin')

@section('content')
@php $page_title = 'Organisasi - Admin'; @endphp

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Struktur Organisasi</h1>
    <p class="text-gray-600 mt-1">Kelola data pejabat Disdukcapil</p>
</div>

<div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm mb-8">
    <h2 class="text-lg font-bold text-gray-800 mb-4"><i class="fas fa-list mr-2 text-blue-600"></i>Daftar Pejabat</h2>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-sm border-b">
                    <th class="p-4 font-semibold">Kode Posisi</th>
                    <th class="p-4 font-semibold">Nama Jabatan</th>
                    <th class="p-4 font-semibold">Nama Pejabat</th>
                    <th class="p-4 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($struktur as $item)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-4 font-medium text-gray-500">{{ $item->kode_posisi }}</td>
                    <td class="p-4 font-bold text-gray-800">{{ $item->nama_jabatan }}</td>
                    <td class="p-4 text-blue-600 font-semibold">{{ $item->nama_pejabat ?? 'Belum Diisi' }}</td>
                    <td class="p-4 text-center">
                        {{-- Tombol Edit dengan proteksi event --}}
                        <button type="button" 
                                onclick="openEditModal(event, '{{ $item->id }}', '{{ $item->nama_jabatan }}', '{{ addslashes($item->nama_pejabat ?? '') }}')" 
                                class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 transition-colors font-medium">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-8 text-center text-gray-500">
                        Data organisasi masih kosong. Silakan jalankan seeder di terminal.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    /**
     * Fungsi untuk membuka modal edit
     * id: ID database
     * jabatan: Nama Jabatan saat ini
     * pejabat: Nama Pejabat saat ini
     */
    function openEditModal(event, id, jabatan, pejabat) {
        // 1. Cegah perilaku default tombol dan perambatan klik ke latar belakang
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }

        // 2. Pause Auto-Logout jika fungsinya tersedia (Mencegah pop-up tertutup saat kursor bergerak)
        if (typeof window.pauseAutoLogoutReset === 'function') {
            window.pauseAutoLogoutReset();
        }

        // 3. Tampilkan SweetAlert2
        Swal.fire({
            title: 'Edit Pejabat',
            html: `
                <div class="text-left mt-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Jabatan</label>
                    <input id="swal-jabatan" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50" value="${jabatan}" readonly>
                    <p class="text-xs text-gray-500 mb-4 mt-1">*Jabatan struktural bersifat tetap</p>
                    
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Pejabat Baru</label>
                    <input id="swal-pejabat" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="${pejabat}" placeholder="Masukkan nama pejabat...">
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-save mr-1"></i> Simpan Perubahan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#0052CC',
            cancelButtonColor: '#64748b',
            allowOutsideClick: false, // Penting: Agar tidak tertutup saat klik/geser di luar modal
            allowEscapeKey: false,
            customClass: {
                popup: 'swal2-modal-popup',
                confirmButton: 'swal2-confirm-button',
                cancelButton: 'swal2-cancel-button'
            },
            preConfirm: () => {
                const nama_pejabat = document.getElementById('swal-pejabat').value;
                if (!nama_pejabat) {
                    Swal.showValidationMessage('Nama pejabat harus diisi!');
                }
                return {
                    nama_jabatan: document.getElementById('swal-jabatan').value,
                    nama_pejabat: nama_pejabat
                }
            }
        }).then((result) => {
            // 4. Aktifkan kembali Auto-Logout setelah modal ditutup
            if (typeof window.resumeAutoLogoutReset === 'function') {
                window.resumeAutoLogoutReset();
            }

            if (result.isConfirmed) {
                // Tampilkan loading saat proses simpan
                if (window.SwalHelper) {
                    window.SwalHelper.loading('Sedang menyimpan data...');
                }

                // Buat form submit secara dinamis (Method PUT)
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/organisasi/update/${id}`;
                form.innerHTML = `
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="nama_jabatan" value="${result.value.nama_jabatan}">
                    <input type="hidden" name="nama_pejabat" value="${result.value.nama_pejabat}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>
@endsection