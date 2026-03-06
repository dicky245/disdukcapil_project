@extends('layouts.user')

@section('content')
@php
    use App\Models\Layanan_Model;
    $data_layanan = Layanan_Model::all();
@endphp

<main class="pt-0">
    {{-- Hero Section --}}
    <section class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-cyan-800 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm text-sm font-medium mb-6">
                    <i class="fas fa-ticket-alt"></i>
                    Antrian Online
                </div>
                <h1 class="text-4xl md:text-5xl font-extrabold mb-6">
                    Ambil Nomor Antrian dari Rumah
                </h1>
                <p class="text-lg text-blue-100 mb-8">
                    Tidak perlu datang lebih awal untuk antri. Ambil nomor antrian secara online dan datang sesuai jadwal.
                </p>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#f9fafb"/>
            </svg>
        </div>
    </section>

    {{-- Queue Stats --}}
    <section class="py-12 bg-gray-50 -mt-8 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-6">
                <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-3xl text-blue-600"></i>
                    </div>
                    <p class="text-4xl font-bold text-gray-800 mb-1" id="totalToday">-</p>
                    <p class="text-gray-600">Total Hari Ini</p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                    <div class="w-16 h-16 bg-yellow-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-clock text-3xl text-yellow-600"></i>
                    </div>
                    <p class="text-4xl font-bold text-gray-800 mb-1" id="waitingToday">-</p>
                    <p class="text-gray-600">Menunggu</p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-spinner text-3xl text-blue-600"></i>
                    </div>
                    <p class="text-4xl font-bold text-gray-800 mb-1" id="processingToday">-</p>
                    <p class="text-gray-600">Sedang Diproses</p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-check-circle text-3xl text-green-600"></i>
                    </div>
                    <p class="text-4xl font-bold text-gray-800 mb-1" id="completedToday">-</p>
                    <p class="text-gray-600">Selesai</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Booking Form Section --}}
    <section class="py-16 bg-gray-50" id="formSection">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2">Ambil Nomor Antrian</h2>
                <p class="text-gray-600 mt-3 max-w-2xl mx-auto">
                    Lengkapi data diri dan pilih layanan untuk mendapatkan nomor antrian
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-8">
                <form id="antrianForm" class="space-y-6">
                    @csrf
                    
                    {{-- Nama --}}
                    <div>
                        <label class="block text-lg font-semibold text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" required
                               placeholder="Masukkan nama lengkap sesuai KTP"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-base">
                        <p id="namaError" class="text-red-500 text-sm mt-2 hidden">Masukkan nama lengkap</p>
                    </div>
                    
                    {{-- Jenis Layanan (Sekarang Dropdown) --}}
                    <div>
                        <label class="block text-lg font-semibold text-gray-700 mb-2">
                            Jenis Layanan <span class="text-red-500">*</span>
                        </label>
                        <select name="layanan_id" id="layanan_id" required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-base bg-white">
                            <option value="" disabled selected>Pilih jenis layanan...</option>
                            @foreach($data_layanan as $layanan)
                                <option value="{{ $layanan->layanan_id }}">{{ $layanan->nama_layanan }}</option>
                            @endforeach
                        </select>
                        <p id="layananError" class="text-red-500 text-sm mt-2 hidden">Pilih jenis layanan</p>
                    </div>

<button type="submit" id="submitBtn" class="px-5 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition flex items-center justify-center gap-2 text-sm mx-auto">
    <i class="fas fa-ticket-alt text-xs"></i>
    <span>Ambil Nomor Antrian</span>
</button>
                </form>
            </div>
        </div>
    </section>

    {{-- Ticket Result Section --}}
    <section id="ticketResult" class="py-16 bg-gray-50 hidden">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden ticket-animate">
                <div class="bg-gradient-to-r from-blue-600 to-cyan-600 text-white p-6 text-center">
                    <i class="fas fa-ticket-alt text-5xl mb-3"></i>
                    <h3 class="text-2xl font-bold">Nomor Antrian Anda</h3>
                </div>

                <div class="p-8 text-center">
                    <div class="text-6xl font-extrabold text-blue-600 mb-4" id="ticketNumber">ABC-123</div>
                    <div class="grid grid-cols-2 gap-4 text-left mb-6">
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-sm text-gray-500">Nama</p>
                            <p class="font-semibold text-gray-800" id="ticketName">-</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-sm text-gray-500">Layanan</p>
                            <p class="font-semibold text-gray-800" id="ticketService">-</p>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button onclick="window.print()" class="flex-1 px-4 py-3 bg-gray-100 text-gray-800 rounded-lg font-semibold hover:bg-gray-200 transition flex items-center justify-center gap-2">
                            <i class="fas fa-print"></i> Cetak
                        </button>
                        <button onclick="resetForm()" class="flex-1 px-4 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition flex items-center justify-center gap-2">
                            <i class="fas fa-plus"></i> Ambil Lagi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Cari Antrian Section --}}
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider">Cari Antrian</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2">Lupa Nomor Antrian?</h2>
            </div>

            <div class="bg-gray-50 rounded-2xl shadow-lg p-8">
                <div class="grid md:grid-cols-3 gap-4 mb-6">
                    <div class="md:col-span-2">
                        <input type="text" id="searchInput" placeholder="Masukkan nama atau nomor antrian"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition">
                    </div>
                    <div>
                        <select id="searchLayanan" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                            <option value="">Semua Layanan</option>
                            @foreach($data_layanan as $layanan)
                                <option value="{{ $layanan->layanan_id }}">{{ $layanan->nama_layanan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button onclick="searchAntrian()" class="px-5 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition flex items-center justify-center gap-2 text-sm mx-auto">
                    <i class="fas fa-search"></i> Cari Antrian
                </button>
            </div>
            <div id="searchResults" class="mt-8 space-y-4"></div>
        </div>
    </section>
</main>
@endsection 

@push('styles')
<style>
    .ticket-animate {
        animation: ticketSlide 0.5s ease-out;
    }

    @keyframes ticketSlide {
        from { transform: translateY(-50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        loadStatistics();
    });

    function loadStatistics() {
        fetch('{{ route('antrian.statistik') }}')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('totalToday').textContent = data.data.total_antrian;
                    document.getElementById('waitingToday').textContent = data.data.antrian_menunggu;
                    document.getElementById('processingToday').textContent = data.data.antrian_diproses;
                    document.getElementById('completedToday').textContent = data.data.antrian_selesai;
                }
            })
            .catch(err => console.error('Gagal memuat statistik:', err));
    }

    document.getElementById('antrianForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const data = Object.fromEntries(formData);
        const submitBtn = document.getElementById('submitBtn');

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Memproses...</span>';

        fetch('{{ route('antrian.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('ticketNumber').textContent = data.data.nomor_antrian;
                document.getElementById('ticketName').textContent = data.data.nama_lengkap;
                document.getElementById('ticketService').textContent = data.data.layanan;

                document.getElementById('formSection').classList.add('hidden');
                document.getElementById('ticketResult').classList.remove('hidden');
                document.getElementById('ticketResult').scrollIntoView({ behavior: 'smooth' });
                loadStatistics();
            } else {
                alert(data.message || 'Terjadi kesalahan');
            }
        })
        .catch(err => {
            console.error('Error:', err);
            alert('Gagal mengambil antrian. Pastikan koneksi server tersedia.');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-ticket-alt"></i> <span>Ambil Nomor Antrian</span>';
        });
    });

    function resetForm() {
        document.getElementById('antrianForm').reset();
        document.getElementById('formSection').classList.remove('hidden');
        document.getElementById('ticketResult').classList.add('hidden');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function searchAntrian() {
        const search = document.getElementById('searchInput').value;
        const layanan = document.getElementById('searchLayanan').value;
        const params = new URLSearchParams({ 
            nama_lengkap: search,
            layanan_id: layanan 
        });

        fetch(`{{ route('antrian.search') }}?${params}`)
            .then(response => response.json())
            .then(data => {
                const resultsContainer = document.getElementById('searchResults');
                if (data.success && data.data.length > 0) {
                    renderSearchResults(data.data);
                } else {
                    resultsContainer.innerHTML = '<p class="text-center py-4 text-gray-500 italic">Data antrian tidak ditemukan.</p>';
                }
            });
    }

    function renderSearchResults(results) {
        const html = results.map(antrian => `
            <div class="bg-white border rounded-xl p-4 flex justify-between items-center shadow-sm hover:shadow-md transition">
                <div>
                    <p class="font-bold text-blue-600 text-lg">${antrian.nomor_antrian}</p>
                    <p class="text-gray-800 font-medium">${antrian.nama_lengkap}</p>
                    <p class="text-xs text-gray-500 uppercase tracking-wide">
                        ${antrian.layanan ? antrian.layanan.nama_layanan : 'Layanan Umum'}
                    </p>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase ${getStatusClass(antrian.status_antrian)}">
                    ${antrian.status_antrian}
                </span>
            </div>
        `).join('');
        document.getElementById('searchResults').innerHTML = html;
    }

    function getStatusClass(status) {
        switch(status.toLowerCase()) {
            case 'selesai': return 'bg-green-100 text-green-700';
            case 'diproses': return 'bg-blue-100 text-blue-700';
            default: return 'bg-yellow-100 text-yellow-700';
        }
    }
</script>
@endpush