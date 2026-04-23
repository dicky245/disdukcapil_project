@extends('layouts.admin')

@section('content')
<div class="container-fluid p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800"><i class="fas fa-church mr-2"></i>Penerbitan Akta Pernikahan</h1>
        <p class="text-gray-600 mt-1">Penerbitan dokumen Akta Pernikahan</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-8">
        <div class="text-center py-12">
            <div class="text-6xl mb-4"><i class="fas fa-hard-hat"></i></div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Fitur Sedang Dikembangkan</h2>
            <p class="text-gray-600 mb-6">Halaman penerbitan pernikahan sedang dalam pengembangan.</p>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>
@push('scripts')
<script>
// 1. SCRIPT UNIVERSAL UNTUK TOMBOL VERIFIKASI / PROSES
document.querySelectorAll('.btn-status').forEach(btn => {
    btn.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        let form = this.closest('form');
        let statusBaru = form.querySelector('input[name="status"]').value;
        
        SwalHelper.confirmUpdate(
            'Ubah Status',
            `Apakah Anda yakin ingin mengubah status?`,
            `Status akan diperbarui ke: ${statusBaru}`,
            () => form.submit()
        );
    });
});

// 2. SCRIPT UNIVERSAL UNTUK TOMBOL TOLAK + ALASAN PENOLAKAN
document.querySelectorAll('.btn-tolak').forEach(btn => {
    btn.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        let form = this.closest('form');
        
        // Otomatis mencari input dengan class 'input-alasan' (apapun name attributenya)
        let alasan = form.querySelector('.input-alasan'); 
        
        // Memanggil fungsi confirmReject yang baru saja kita buat di admin.blade.php
        SwalHelper.confirmReject(
            'Tolak Permohonan',
            'Apakah Anda yakin ingin menolak permohonan ini?',
            'Permohonan yang ditolak tidak dapat dikembalikan.',
            () => {
                // Popup Kedua: Meminta input alasan penolakan
                Swal.fire({
                    title: 'Alasan Penolakan',
                    input: 'textarea',
                    inputPlaceholder: 'Tuliskan alasan penolakan agar warga tahu...',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Kirim Penolakan',
                    cancelButtonText: 'Batal',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    customClass: {
                        popup: 'swal2-modal-popup',
                        confirmButton: 'swal2-delete-button',
                        cancelButton: 'swal2-cancel-button'
                    },
                    inputValidator: (value) => {
                        if (!value) return 'Alasan penolakan wajib diisi!';
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        alasan.value = result.value; // Memasukkan teks ke input hidden
                        form.submit();               // Mengirim form ke Controller
                    }
                });
            }
        );
    });
});

// 3. SCRIPT UNTUK MENAMPILKAN PESAN SUKSES DARI CONTROLLER
@if(session('success'))
    SwalHelper.success("{{ session('success') }}");
@endif
</script>
@endpush
@endsection