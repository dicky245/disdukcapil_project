@extends('layouts.admin')

@section('content')
@php
    $page_title = 'Manajemen Antrian Digital';
@endphp

<div class="container mx-auto px-4 py-8">

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @php
            $stats = [
                ['id' => 'waitingCount', 'label' => 'Menunggu', 'color' => 'amber', 'icon' => 'fa-clock'],
                ['id' => 'processingCount', 'label' => 'Diproses', 'color' => 'blue', 'icon' => 'fa-spinner'],
                ['id' => 'completedCount', 'label' => 'Selesai', 'color' => 'emerald', 'icon' => 'fa-check-double'],
                ['id' => 'totalCount', 'label' => 'Total Hari Ini', 'color' => 'indigo', 'icon' => 'fa-users'],
            ];
        @endphp

        @foreach($stats as $stat)
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm transition-transform hover:scale-[1.02]">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-{{ $stat['color'] }}-50 text-{{ $stat['color'] }}-600 rounded-xl flex items-center justify-center text-xl">
                    <i class="fas {{ $stat['icon'] }}"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">{{ $stat['label'] }}</p>
                    <h3 class="text-2xl font-black text-slate-800" id="{{ $stat['id'] }}">0</h3>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 mb-8">
        <div class="flex flex-col lg:flex-row gap-4">
            <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="relative">
                    <label class="text-xs font-bold text-slate-500 mb-1.5 block px-1">STATUS LAYANAN</label>
                    <select id="filterStatus" class="w-full pl-4 pr-10 py-2.5 bg-slate-50 border-transparent rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 transition-all appearance-none font-medium text-slate-700">
                        <option value="">Semua Status</option>
                        <option value="Menunggu">Menunggu</option>
                        <option value="Dokumen Diterima">Dokumen Diterima</option>
                        <option value="Verifikasi Data">Verifikasi Data</option>
                        <option value="Proses Cetak">Proses Cetak</option>
                        <option value="Siap Pengambilan">Siap Pengambilan</option>
                        <option value="Ditolak">Ditolak</option>
                        <option value="Dibatalkan">Dibatalkan</option>
                    </select>
                </div>
                <div class="relative">
                    <label class="text-xs font-bold text-slate-500 mb-1.5 block px-1">JENIS LAYANAN</label>
                    <select id="filterLayanan" class="w-full pl-4 pr-10 py-2.5 bg-slate-50 border-transparent rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500 transition-all appearance-none font-medium text-slate-700">
                        <option value="">Semua Layanan</option>
                    </select>
                </div>
            </div>
            <div class="flex items-end gap-2">
                <button onclick="applyFilter()" class="px-5 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition flex items-center justify-center gap-2 text-sm mx-auto">
                    Terapkan
                </button>
                <button onclick="resetFilter()" class="h-11 px-4 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition-colors">
                    Reset
                </button>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-xl overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-50 flex items-center justify-between bg-slate-50/50">
            <h2 class="font-bold text-slate-800 flex items-center gap-2">
                <span class="w-2 h-6 bg-blue-500 rounded-full"></span>
                Antrian Berjalan
            </h2>
            <span id="totalRecords" class="text-xs font-bold py-1 px-3 bg-white border border-slate-200 text-slate-500 rounded-full shadow-sm uppercase">Total: 0</span>
        </div>

        <div id="queueList" class="divide-y divide-slate-50">
            <div class="p-20 text-center">
                <div class="animate-spin inline-block w-8 h-8 border-4 border-blue-500 border-t-transparent rounded-full mb-4"></div>
                <p class="text-slate-400 font-medium italic">Menghubungkan ke server...</p>
            </div>
        </div>
    </div>
</div>

<div id="detailModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm transition-opacity duration-300">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full overflow-hidden transform transition-all scale-95" id="modalContainer">
            <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight">Informasi Detail</h3>
                <button onclick="closeDetailModal()" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-white transition-colors text-slate-400 hover:text-red-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="detailModalContent" class="p-6"></div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let allQueueData = [];

    document.addEventListener('DOMContentLoaded', () => {
        refreshData();
        loadLayanan();
        setupEventListeners();
    });

    function setupEventListeners() {
        document.getElementById('filterStatus').addEventListener('change', applyFilter);
        document.getElementById('filterLayanan').addEventListener('change', applyFilter);

        // Modal Backdrop click
        document.getElementById('detailModal').addEventListener('click', (e) => {
            if (e.target.id === 'detailModal') closeDetailModal();
        });
    }

    async function refreshData() {
        await Promise.all([loadStatistics(), loadAntrian()]);
    }

    async function loadStatistics() {
        try {
            const res = await fetch('{{ route('antrian.statistik') }}');
            const { data } = await res.json();
            document.getElementById('waitingCount').innerText = data.antrian_menunggu;
            document.getElementById('processingCount').innerText = data.antrian_diproses;
            document.getElementById('completedCount').innerText = data.antrian_selesai;
            document.getElementById('totalCount').innerText = data.total_antrian;
        } catch (e) {
            console.error("Stats Error:", e);
        }
    }

    async function loadLayanan() {
        try {
            const res = await fetch('{{ route('api.layanan') }}');
            const { data } = await res.json();
            const select = document.getElementById('filterLayanan');
            data.forEach(l => {
                const opt = new Option(l.nama_layanan, l.layanan_id);
                select.add(opt);
            });
        } catch (e) { console.error(e); }
    }

    async function loadAntrian() {
        try {
            const res = await fetch('{{ route('admin.antrian-online.data') }}');
            const { data } = await res.json();
            allQueueData = data;
            renderQueueList(data);
        } catch (e) { renderQueueList([]); }
    }

    function applyFilter() {
        const status = document.getElementById('filterStatus').value;
        const layanan = document.getElementById('filterLayanan').value;

        const filtered = allQueueData.filter(q => {
            return (!status || q.status_antrian === status) &&
                   (!layanan || q.layanan_id == layanan);
        });
        renderQueueList(filtered);
    }

    function resetFilter() {
        document.getElementById('filterStatus').value = '';
        document.getElementById('filterLayanan').value = '';
        renderQueueList(allQueueData);
    }

    function getStatusConfig(status) {
        const configs = {
            'Menunggu': { class: 'bg-amber-50 text-amber-600 border-amber-100', icon: 'fa-hourglass' },
            'Dokumen Diterima': { class: 'bg-blue-50 text-blue-600 border-blue-100', icon: 'fa-file-check' },
            'Verifikasi Data': { class: 'bg-indigo-50 text-indigo-600 border-indigo-100', icon: 'fa-search' },
            'Proses Cetak': { class: 'bg-purple-50 text-purple-600 border-purple-100', icon: 'fa-print' },
            'Siap Pengambilan': { class: 'bg-emerald-50 text-emerald-600 border-emerald-100', icon: 'fa-box-open' },
            'Ditolak': { class: 'bg-red-50 text-red-600 border-red-100', icon: 'fa-ban' },
            'Dibatalkan': { class: 'bg-rose-50 text-rose-600 border-rose-100', icon: 'fa-times' }
        };
        return configs[status] || { class: 'bg-slate-100 text-slate-500', icon: 'fa-info-circle' };
    }

    function renderQueueList(data) {
        const container = document.getElementById('queueList');
        document.getElementById('totalRecords').innerText = `Total: ${data.length}`;

        if (data.length === 0) {
            container.innerHTML = `
                <div class="py-20 text-center">
                    <div class="w-20 h-20 mx-auto mb-4 bg-slate-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-inbox text-3xl text-slate-300"></i>
                    </div>
                    <p class="text-slate-400 font-bold">Tidak ada data ditemukan</p>
                </div>`;
            return;
        }

        container.innerHTML = data.map(q => {
            const cfg = getStatusConfig(q.status_antrian);
            const initial = q.nama_lengkap.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);

            return `
            <div class="group p-5 sm:p-6 hover:bg-slate-50 transition-all">
                <div class="flex flex-col sm:flex-row sm:items-center gap-6">
                    <div class="relative flex-shrink-0">
                        <div class="w-16 h-16 bg-gradient-to-tr from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white shadow-md group-hover:scale-105 transition-transform border-4 border-white">
                            <span class="text-xl font-black tracking-tighter">${initial}</span>
                        </div>
                    </div>

                    <div class="flex-1 space-y-1">
                        <div class="flex flex-wrap items-center gap-3">
                            <h4 class="text-lg font-bold text-slate-800">${q.nama_lengkap}</h4>
                            <span class="px-3 py-1 border rounded-full text-[10px] font-black uppercase ${cfg.class}">
                                <i class="fas ${cfg.icon} mr-1"></i> ${q.status_antrian}
                            </span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-1 gap-x-6 text-sm text-slate-500 font-medium">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-id-card text-blue-400 w-4 text-xs"></i>
                                <span class="text-slate-600">${q.layanan ? q.layanan.nama_layanan : 'Layanan Umum'}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-calendar-alt text-blue-400 w-4 text-xs"></i>
                                <span>${new Date(q.created_at).toLocaleString('id-ID', {day:'2-digit', month:'short', hour:'2-digit', minute:'2-digit'})}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        ${renderActions(q)}
                        <button onclick="showDetail('${q.antrian_online_id}')" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 hover:text-blue-600 hover:border-blue-200 transition-all shadow-sm font-semibold text-sm flex items-center gap-2">
                            <i class="fas fa-expand-alt text-xs"></i>
                            <span>Detail</span>
                        </button>
                    </div>
                </div>
            </div>`;
        }).join('');
    }

    function renderActions(q) {
        if (q.status_antrian === 'Menunggu') {
            return `
                <button onclick="updateStatus('${q.antrian_online_id}', 'terima')" class="px-5 py-2 bg-blue-500 text-white rounded-xl text-sm font-bold hover:bg-blue-600 shadow-md shadow-blue-100 transition-all">
                    <i class="fas fa-file-import mr-1"></i> Terima Dokumen
                </button>
                <button onclick="showTolakModal('${q.antrian_online_id}')" class="px-5 py-2 bg-red-500 text-white rounded-xl text-sm font-bold hover:bg-red-600 shadow-md shadow-red-100 transition-all">
                    <i class="fas fa-ban mr-1"></i> Tolak
                </button>
            `;
        }
        if (q.status_antrian === 'Dokumen Diterima') {
            return `
                <button onclick="updateStatus('${q.antrian_online_id}', 'verifikasi')" class="px-5 py-2 bg-indigo-500 text-white rounded-xl text-sm font-bold hover:bg-indigo-600 shadow-md shadow-indigo-100 transition-all">
                    <i class="fas fa-search mr-1"></i> Verifikasi Data
                </button>
                <button onclick="showTolakModal('${q.antrian_online_id}')" class="px-5 py-2 bg-red-500 text-white rounded-xl text-sm font-bold hover:bg-red-600 shadow-md shadow-red-100 transition-all">
                    <i class="fas fa-ban mr-1"></i> Tolak
                </button>
            `;
        }
        if (q.status_antrian === 'Verifikasi Data') {
            return `
                <button onclick="updateStatus('${q.antrian_online_id}', 'cetak')" class="px-5 py-2 bg-purple-500 text-white rounded-xl text-sm font-bold hover:bg-purple-600 shadow-md shadow-purple-100 transition-all">
                    <i class="fas fa-print mr-1"></i> Proses Cetak
                </button>
                <button onclick="showTolakModal('${q.antrian_online_id}')" class="px-5 py-2 bg-red-500 text-white rounded-xl text-sm font-bold hover:bg-red-600 shadow-md shadow-red-100 transition-all">
                    <i class="fas fa-ban mr-1"></i> Tolak
                </button>
            `;
        }
        if (q.status_antrian === 'Proses Cetak') {
            return `
                <button onclick="updateStatus('${q.antrian_online_id}', 'selesai')" class="px-5 py-2 bg-emerald-500 text-white rounded-xl text-sm font-bold hover:bg-emerald-600 shadow-md shadow-emerald-100 transition-all">
                    <i class="fas fa-box-open mr-1"></i> Siap Diambil
                </button>
                <button onclick="showTolakModal('${q.antrian_online_id}')" class="px-5 py-2 bg-red-500 text-white rounded-xl text-sm font-bold hover:bg-red-600 shadow-md shadow-red-100 transition-all">
                    <i class="fas fa-ban mr-1"></i> Tolak
                </button>
            `;
        }
        return `<span class="px-4 py-2 bg-slate-100 text-slate-400 rounded-xl text-xs font-bold uppercase tracking-widest">Selesai</span>`;
    }

    async function updateStatus(id, type) {
        const actionMap = {
            'terima': {
                route: '{{ route("admin.antrian-online.terima", ":id") }}',
                color: '#3b82f6',
                label: 'Terima Dokumen',
                title: 'Terima Dokumen',
                text: 'Konfirmasi penerimaan dokumen antrian ini?'
            },
            'verifikasi': {
                route: '{{ route("admin.antrian-online.verifikasi", ":id") }}',
                color: '#6366f1',
                label: 'Verifikasi Data',
                title: 'Verifikasi Data',
                text: 'Mulai verifikasi data untuk antrian ini?'
            },
            'cetak': {
                route: '{{ route("admin.antrian-online.cetak", ":id") }}',
                color: '#a855f7',
                label: 'Proses Cetak',
                title: 'Proses Cetak',
                text: 'Mulai proses cetak dokumen untuk antrian ini?'
            },
            'selesai': {
                route: '{{ route("admin.antrian-online.selesai", ":id") }}',
                color: '#10b981',
                label: 'Siap Diambil',
                title: 'Siap Diambil',
                text: 'Tandai dokumen sebagai siap diambil?'
            }
        };

        const config = actionMap[type];
        const result = await Swal.fire({
            title: config.title,
            text: config.text,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: config.color,
            confirmButtonText: 'Ya, Lanjutkan'
        });

        if (result.isConfirmed) {
            try {
                const res = await fetch(config.route.replace(':id', id), {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                const data = await res.json();
                if (data.success) {
                    Swal.fire('Berhasil', data.message, 'success');
                    refreshData();
                } else {
                    Swal.fire('Gagal', data.message || 'Terjadi kesalahan', 'error');
                }
            } catch (e) {
                Swal.fire('Gagal', 'Terjadi kesalahan sistem', 'error');
            }
        }
    }

    // OPTIMIZED: Tampilkan detail langsung dari memory, fetch riwayat asynchronously
    function showDetail(id) {
        const modal = document.getElementById('detailModal');
        const content = document.getElementById('detailModalContent');
        const container = document.getElementById('modalContainer');

        // Cari data antrian dari memory (sangat cepat)
        const queueData = allQueueData.find(q => q.antrian_online_id == id);
        if (!queueData) {
            Swal.fire('Error', 'Data antrian tidak ditemukan', 'error');
            return;
        }

        // Tampilkan modal dengan loading singkat
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            container.classList.remove('scale-95');
            container.classList.add('scale-100');
        }, 10);

        // Render data dasar langsung dari memory (INSTANT)
        const cfg = getStatusConfig(queueData.status_antrian);
        const initial = queueData.nama_lengkap.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);

        content.innerHTML = `
            <div class="space-y-6">
                <!-- Header dengan loading kecil untuk riwayat -->
                <div class="bg-slate-900 rounded-2xl p-5 text-white flex justify-between items-center">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase">Token Antrian</p>
                        <p class="text-3xl font-black font-mono">${queueData.nomor_antrian}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-black text-slate-400 uppercase">Status</p>
                        <span class="inline-flex items-center gap-2 px-3 py-1 ${cfg.class.replace('text-', 'text-white bg-').replace('border-', 'bg-opacity-20')} rounded-full text-xs font-bold">
                            <i class="fas ${cfg.icon}"></i>
                            ${queueData.status_antrian}
                        </span>
                    </div>
                </div>

                <!-- Info Dasar -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 bg-slate-50 rounded-xl">
                        <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Nama Lengkap</p>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-gradient-to-tr from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white text-xs font-bold">${initial}</div>
                            <p class="font-bold text-slate-800 text-sm">${queueData.nama_lengkap}</p>
                        </div>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-xl">
                        <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Layanan</p>
                        <p class="font-bold text-slate-800 text-sm">${queueData.layanan?.nama_layanan || '-'}</p>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-xl">
                        <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">ID Antrian</p>
                        <p class="font-mono font-bold text-slate-800 text-sm">#${queueData.antrian_online_id}</p>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-xl">
                        <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Dibuat</p>
                        <p class="font-bold text-slate-800 text-sm">${new Date(queueData.created_at).toLocaleString('id-ID')}</p>
                    </div>
                </div>

                <!-- Riwayat dengan loading indicator -->
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-xs font-black text-slate-400 uppercase px-1">Log Aktivitas</h4>
                        <div id="riwayatLoading" class="flex items-center gap-2 text-xs text-blue-500">
                            <i class="fas fa-spinner fa-spin"></i>
                            <span>Memuat riwayat...</span>
                        </div>
                    </div>
                    <div id="riwayatContainer" class="space-y-3">
                        <div class="p-4 bg-slate-50 rounded-xl text-center text-slate-400 text-sm">
                            <i class="fas fa-spinner fa-spin mr-2"></i>
                            Memuat log aktivitas...
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Fetch riwayat secara asynchronous (di background)
        fetch(`{{ route('admin.antrian-online.riwayat', ':id') }}`.replace(':id', id))
            .then(r => r.json())
            .then(resp => {
                // Hide loading
                const loadingEl = document.getElementById('riwayatLoading');
                if (loadingEl) loadingEl.style.display = 'none';

                if (resp.success && resp.data.riwayat) {
                    const riwayatContainer = document.getElementById('riwayatContainer');
                    riwayatContainer.innerHTML = resp.data.riwayat.map((r, index) => {
                        // Tentukan warna berdasarkan status
                        let dotColor = 'bg-blue-500';
                        if (r.status === 'Ditolak') dotColor = 'bg-red-500';
                        else if (r.status === 'Siap Pengambilan') dotColor = 'bg-emerald-500';
                        else if (r.status === 'Dokumen Diterima') dotColor = 'bg-blue-500';
                        else if (r.status === 'Verifikasi Data') dotColor = 'bg-indigo-500';
                        else if (r.status === 'Proses Cetak') dotColor = 'bg-purple-500';
                        else if (r.status === 'Menunggu') dotColor = 'bg-amber-500';

                        return `
                        <div class="flex items-start gap-3 p-3 border border-slate-100 rounded-xl hover:bg-slate-50 transition">
                            <div class="mt-1 w-2 h-2 rounded-full ${dotColor} shadow-[0_0_8px_rgba(59,130,246,0.5)]"></div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-slate-800">${r.status}</p>
                                <p class="text-[11px] text-slate-400">${new Date(r.tanggal).toLocaleDateString('id-ID', {day: 'numeric', month: 'short', year: 'numeric'})}</p>
                                ${r.keterangan ? `<p class="text-xs text-slate-500 mt-1">${r.keterangan}</p>` : ''}
                                ${r.alasan_penolakan ? `<p class="text-xs text-red-600 mt-1 font-semibold"><i class="fas fa-exclamation-circle mr-1"></i>Alasan: ${r.alasan_penolakan}</p>` : ''}
                            </div>
                        </div>
                    `}).join('');
                } else {
                    document.getElementById('riwayatContainer').innerHTML = `
                        <div class="p-4 bg-slate-50 rounded-xl text-center">
                            <p class="text-slate-400 text-sm">Tidak ada riwayat aktivitas</p>
                        </div>
                    `;
                }
            })
            .catch(e => {
                console.error('Error loading riwayat:', e);
                const loadingEl = document.getElementById('riwayatLoading');
                if (loadingEl) loadingEl.style.display = 'none';

                document.getElementById('riwayatContainer').innerHTML = `
                    <div class="p-4 bg-rose-50 rounded-xl text-center">
                        <p class="text-rose-500 text-sm">Gagal memuat riwayat</p>
                    </div>
                `;
            });
    }

    function closeDetailModal() {
        const modal = document.getElementById('detailModal');
        const container = document.getElementById('modalContainer');

        modal.classList.add('opacity-0');
        container.classList.remove('scale-100');
        container.classList.add('scale-95');

        setTimeout(() => modal.classList.add('hidden'), 300);
    }

    // Modal Tolak
    function showTolakModal(id) {
        Swal.fire({
            title: 'Tolak Antrian',
            text: 'Masukkan alasan penolakan untuk antrian ini',
            input: 'textarea',
            inputLabel: 'Alasan Penolakan',
            inputPlaceholder: 'Contoh: Dokumen tidak lengkap, Data tidak valid, dll.',
            inputAttributes: {
                'aria-label': 'Alasan Penolakan',
                'rows': 4,
                'maxlength': 500
            },
            showCancelButton: true,
            confirmButtonText: 'Ya, Tolak',
            confirmButtonColor: '#ef4444',
            cancelButtonText: 'Batal',
            inputValidator: (value) => {
                if (!value) {
                    return 'Alasan penolakan wajib diisi!';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                tolakAntrian(id, result.value);
            }
        });
    }

    async function tolakAntrian(id, alasan) {
        try {
            const res = await fetch(`{{ route('admin.antrian-online.update-berkas', ':id') }}`.replace(':id', id), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    status: 'Ditolak',
                    keterangan: 'Antrian ditolak oleh admin',
                    alasan_penolakan: alasan
                })
            });

            const data = await res.json();
            if (data.success) {
                Swal.fire('Berhasil', 'Antrian berhasil ditolak', 'success');
                refreshData();
            } else {
                Swal.fire('Gagal', data.message || 'Terjadi kesalahan', 'error');
            }
        } catch (e) {
            console.error('Error:', e);
            Swal.fire('Gagal', 'Terjadi kesalahan sistem', 'error');
        }
    }

    // Close modal on ESC key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeDetailModal();
    });
</script>
@endpush

<style>
    /* Custom Scrollbar for better UX */
    #detailModalContent::-webkit-scrollbar { width: 6px; }
    #detailModalContent::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }

    /* Animation for revealing cards */
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    #queueList > div {
        animation: slideUp 0.4s ease forwards;
    }

    /* Modal transition */
    #modalContainer {
        transition: transform 0.3s ease, opacity 0.3s ease;
    }
</style>

@endsection
