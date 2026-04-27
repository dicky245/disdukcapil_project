@extends('layouts.keagamaan')

@section('content')
@php
    $page_title = 'Lacak Berkas - Keagamaan';
@endphp

<!-- Page Header -->
<div class="mb-6 reveal">
    <h1 class="text-2xl font-bold text-gray-800">Lacak Berkas</h1>
    <p class="text-gray-600 mt-1">Pantau status dan lokasi berkas keagamaan</p>
</div>

<!-- Search Section -->
<div class="bg-gradient-to-r from-teal-600 to-teal-700 rounded-2xl p-6 text-white mb-6 reveal">
    <div class="flex flex-col md:flex-row gap-4 items-center">
        <div class="flex-1 w-full">
            <div class="relative">
                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" id="searchInput" placeholder="Masukkan nomor berkas atau nama pasangan..."
                       class="w-full pl-12 pr-4 py-3 rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>
        </div>
        <button onclick="searchBerkas()" class="w-full md:w-auto px-6 py-3 bg-white text-green-700 rounded-xl hover:bg-gray-100 transition font-semibold whitespace-nowrap">
            <i class="fas fa-search mr-2"></i>Lacak Berkas
        </button>
    </div>
</div>

<!-- Tracking Result (Hidden by default) -->
<div id="trackingResult" class="hidden mb-6">
    <!-- Main Info Card -->
    <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm mb-6 reveal">
        <div class="flex items-start justify-between mb-6">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <h2 class="text-2xl font-bold text-gray-800" id="resultId">-</h2>
                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-sm font-medium" id="resultStatus">-</span>
                </div>
                <p class="text-gray-600" id="resultName">-</p>
                <p class="text-sm text-gray-500 mt-1" id="resultType">-</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">Tanggal Pengajuan</p>
                <p class="font-semibold text-gray-800" id="resultDate">-</p>
            </div>
        </div>

        <!-- Progress Timeline -->
        <div class="relative" id="timelineContainer">
            <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>
            <!-- Timeline items will be populated by JavaScript -->
        </div>
    </div>

    <!-- Detail Information -->
    <div class="grid md:grid-cols-2 gap-6 mb-6">
        <!-- Document Info -->
        <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm reveal">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Dokumen</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Nomor Antrian</span>
                    <span class="font-semibold text-gray-800" id="infoNomorAntrian">-</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Jenis Layanan</span>
                    <span class="font-semibold text-gray-800" id="infoJenisLayanan">-</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Alamat</span>
                    <span class="font-semibold text-gray-800 text-right max-w-xs" id="infoAlamat">-</span>
                </div>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm reveal">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Pemohon</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Nama Lengkap</span>
                    <span class="font-semibold text-gray-800" id="infoNama">-</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">NIK</span>
                    <span class="font-semibold text-gray-800 font-mono" id="infoNik">-</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Status</span>
                    <span class="font-semibold text-gray-800" id="infoStatus">-</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex gap-3 reveal" id="actionButtons">
        <button onclick="window.print()" class="flex-1 px-6 py-3 bg-gray-100 text-gray-800 rounded-xl hover:bg-gray-200 transition flex items-center justify-center gap-2">
            <i class="fas fa-print"></i>
            <span>Cetak</span>
        </button>
    </div>
</div>

<!-- No Result Message -->
<div id="noResultMessage" class="hidden bg-white rounded-xl border border-gray-100 p-8 shadow-sm text-center mb-6 reveal">
    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <i class="fas fa-search text-3xl text-gray-400"></i>
    </div>
    <h3 class="text-lg font-bold text-gray-800 mb-2">Data Tidak Ditemukan</h3>
    <p class="text-gray-600 mb-4">Nomor antrian atau nama yang Anda masukkan tidak ditemukan dalam sistem.</p>
</div>

<script>
    function searchBerkas() {
        const input = document.getElementById('searchInput').value.trim();

        if (!input) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Masukkan nomor antrian atau nama lengkap',
                confirmButtonColor: '#28A745'
            });
            return;
        }

        // Hide previous results
        document.getElementById('trackingResult').classList.add('hidden');
        document.getElementById('noResultMessage').classList.add('hidden');

        // Show loading
        Swal.fire({
            title: 'Mencari...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Determine if input is a queue number or name
        const isNomorAntrian = /^[A-Z]{3}[-]?[\d]*[-]?[\d]*$/i.test(input);
        const params = new URLSearchParams();
        
        if (isNomorAntrian) {
            // Format queue number to standard format
            let formattedNomor = input.toUpperCase().replace(/[^A-Z0-9]/g, '');
            while (formattedNomor.length < 9) {
                formattedNomor += '0';
            }
            const part1 = formattedNomor.substring(0, 3);
            const part2 = formattedNomor.substring(3, 6);
            const part3 = formattedNomor.substring(6, 9);
            formattedNomor = part1 + '-' + part2 + '-' + part3;
            params.append('nomor_antrian', formattedNomor);
        } else {
            params.append('nama_lengkap', input);
        }

        // Make API request
        fetch(`{{ route('antrian.lacak') }}?${params.toString()}`)
            .then(response => response.json())
            .then(data => {
                Swal.close();
                
                if (data.success && data.data) {
                    displayTrackingResult(data.data);
                    document.getElementById('trackingResult').classList.remove('hidden');
                    document.getElementById('trackingResult').scrollIntoView({ behavior: 'smooth' });

                    SwalHelper.success('Ditemukan!', 'Data antrian berhasil ditemukan');
                } else {
                    document.getElementById('noResultMessage').classList.remove('hidden');
                    document.getElementById('noResultMessage').scrollIntoView({ behavior: 'smooth' });

                    SwalHelper.info('Tidak ditemukan', 'Data antrian tidak ditemukan dalam sistem');
                }
            })
            .catch(error => {
                Swal.close();
                SwalHelper.error('Gagal mencari data. Silakan coba lagi.');
            });
    }

    function displayTrackingResult(data) {
        // Update main info
        document.getElementById('resultId').textContent = data.nomor_antrian || '-';
        document.getElementById('resultStatus').textContent = data.status_antrian || '-';
        document.getElementById('resultName').textContent = data.nama_lengkap || '-';
        document.getElementById('resultType').textContent = data.layanan || '-';

        // Format date
        let formattedDate = '-';
        if (data.created_at) {
            try {
                const createdDate = new Date(data.created_at);
                formattedDate = createdDate.toLocaleDateString('id-ID', { 
                    day: 'numeric', 
                    month: 'long', 
                    year: 'numeric'
                });
            } catch (e) {}
        }
        document.getElementById('resultDate').textContent = formattedDate;

        // Update info panels
        document.getElementById('infoNomorAntrian').textContent = data.nomor_antrian || '-';
        document.getElementById('infoJenisLayanan').textContent = data.layanan || '-';
        document.getElementById('infoAlamat').textContent = data.alamat || '-';
        document.getElementById('infoNama').textContent = data.nama_lengkap || '-';
        document.getElementById('infoNik').textContent = data.nik || '-';
        document.getElementById('infoStatus').textContent = data.status_antrian || '-';

        // Update timeline
        const timelineContainer = document.getElementById('timelineContainer');
        if (data.riwayat && data.riwayat.length > 0) {
            let timelineHTML = '<div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>';

            data.riwayat.forEach((item, index) => {
                const dotColor = getStatusDotColor(item.status);
                const isLast = index === data.riwayat.length - 1;
                
                let itemDate = '-';
                if (item.tanggal) {
                    try {
                        const date = new Date(item.tanggal);
                        itemDate = date.toLocaleDateString('id-ID', { 
                            day: 'numeric', 
                            month: 'short', 
                            year: 'numeric'
                        });
                    } catch (e) {
                        itemDate = item.tanggal;
                    }
                }

                timelineHTML += `
                    <div class="relative pl-10 ${!isLast ? 'pb-6' : ''}">
                        <div class="absolute left-2.5 w-3 h-3 ${dotColor} rounded-full border-2 border-white"></div>
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="font-semibold text-gray-800">${item.status || '-'}</p>
                                <p class="text-sm text-gray-600">${item.keterangan || ''}</p>
                            </div>
                            <span class="text-sm text-gray-500">${itemDate}</span>
                        </div>
                    </div>
                `;
            });

            timelineContainer.innerHTML = timelineHTML;
        } else {
            timelineContainer.innerHTML = `
                <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>
                <div class="relative pl-10 pb-6">
                    <div class="absolute left-2.5 w-3 h-3 bg-amber-500 rounded-full border-2 border-white"></div>
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="font-semibold text-gray-800">Menunggu</p>
                            <p class="text-sm text-gray-600">Antrian berhasil dibuat, menunggu verifikasi dokumen</p>
                        </div>
                        <span class="text-sm text-gray-500">${formattedDate}</span>
                    </div>
                </div>
            `;
        }
    }

    function getStatusDotColor(status) {
        switch(status) {
            case 'Menunggu': return 'bg-amber-500';
            case 'Dokumen Diterima': return 'bg-blue-500';
            case 'Verifikasi Data': return 'bg-indigo-500';
            case 'Proses Cetak': return 'bg-purple-500';
            case 'Siap Pengambilan': return 'bg-emerald-500';
            case 'Selesai': return 'bg-green-500';
            case 'Ditolak': return 'bg-red-500';
            case 'Dibatalkan': return 'bg-gray-500';
            default: return 'bg-gray-500';
        }
    }

    // Allow enter key to search
    document.getElementById('searchInput')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            searchBerkas();
        }
    });

    // Reveal Animation
    function reveal() {
        const reveals = document.querySelectorAll('.reveal');
        reveals.forEach(element => {
            const windowHeight = window.innerHeight;
            const elementTop = element.getBoundingClientRect().top;
            const elementVisible = 150;

            if (elementTop < windowHeight - elementVisible) {
                element.classList.add('active');
            }
        });
    }

    window.addEventListener('scroll', reveal);
    reveal();
</script>
@endsection
