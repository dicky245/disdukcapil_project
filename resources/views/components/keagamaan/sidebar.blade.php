{{-- Tambahkan Style di bagian paling atas file --}}
<style>
    /* Indikator visual saat menu aktif */
    .sidebar-link.active {
        background-color: #f0fdfa !important;
        /* Hijau teal sangat muda */
        color: #0d9488 !important;
        /* Warna teal utama */
        border-right: 4px solid #0d9488;
        /* Garis penanda di samping */
    }

    .sidebar-link.active i {
        color: #0d9488 !important;
    }

    /* Transisi halus saat hover */
    .sidebar-link {
        transition: all 0.3s ease;
    }
</style>

{{-- Keagamaan Sidebar --}}
<aside class="sidebar fixed left-0 top-0 h-full w-64 bg-white border-r border-gray-200 z-50 shadow-lg">
    {{-- Logo --}}
    <div class="h-16 flex items-center px-6 border-b border-gray-100">
        <div
            class="w-10 h-10 bg-gradient-to-br from-teal-600 to-teal-700 rounded-xl flex items-center justify-center flex-shrink-0">
            <span class="text-lg">🕌</span>
        <div class="w-10 h-10 bg-gradient-to-br from-teal-600 to-teal-700 rounded-xl flex items-center justify-center flex-shrink-0">
            <i class="fas fa-mosque text-white text-lg"></i>
        </div>
        <span class="sidebar-text logo-text ml-3 font-bold text-lg text-gray-800">Keagamaan</span>
    </div>

    {{-- Navigation --}}
    <nav class="p-4 space-y-1 overflow-y-auto h-[calc(100vh-4rem)]">
        <a href="{{ route('keagamaan.dashboard') }}"
            class="sidebar-link {{ request()->routeIs('keagamaan.dashboard') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700">
            <i class="fas fa-home w-5"></i>
            <span class="sidebar-text font-medium">Dashboard</span>
        </a>

        <div class="pt-4 pb-2">
            <p class="sidebar-text px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Menu Keagamaan</p>
        </div>

        <a href="{{ route('keagamaan.antrian_kalender') }}"
            class="sidebar-link {{ request()->routeIs('keagamaan.antrian_kalender') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700">
            <i class="fas fa-calendar-alt w-5"></i>
            <span class="sidebar-text font-medium">Antrian & Kalender</span>
        </a>

        <a href="{{ route('keagamaan.sinkronisasi-dukcapil') }}"
            class="sidebar-link {{ request()->routeIs('keagamaan.sinkronisasi-dukcapil') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 transition-all hover:bg-teal-50">
            <i class="fas fa-sync w-5"></i>
            <span class="sidebar-text font-medium">Sinkronisasi Dukcapil</span>
        </a>

        <a href="{{ route('keagamaan.manajemen_dokumen') }}"
            class="sidebar-link {{ request()->routeIs('keagamaan.manajemen_dokumen') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700">
            <i class="fas fa-file-alt w-5"></i>
            <span class="sidebar-text font-medium">Manajemen Dokumen</span>
        </a>

        <a href="{{ route('keagamaan.lacak_berkas') }}"
            class="sidebar-link {{ request()->routeIs('keagamaan.lacak_berkas') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 transition-all hover:bg-teal-50">
            <i class="fas fa-search w-5"></i>
            <span class="sidebar-text font-medium">Lacak Berkas</span>
        </a>

        <div class="pt-4 pb-2">
            <p class="sidebar-text px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Akun</p>
        </div>

        <form method="POST" action="{{ route('logout') }}" id="logoutForm" class="inline">
            @csrf
            <button type="submit"
                class="sidebar-link w-full flex items-center gap-3 px-4 py-3 rounded-lg text-red-600 hover:bg-red-50">
            <button type="button" onclick="handleKeagamaanSidebarLogout(event)"
                class="sidebar-link w-full flex items-center gap-3 px-4 py-3 rounded-lg text-red-600 hover:bg-red-50 transition-all">
                <i class="fas fa-sign-out-alt w-5"></i>
                <span class="sidebar-text font-medium">Logout</span>
            </button>
        </form>
    </nav>
</aside>

<script>
    // Sidebar Toggle Logic
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');
    const sidebarToggle = document.getElementById('sidebarToggle');

    if (sidebarToggle && sidebar && mainContent) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });
    }
</script>

    // Logout Handler - SweetAlert Confirmation
    function handleKeagamaanSidebarLogout(event) {
        // Mencegah event bubbling
        event.preventDefault();
        event.stopPropagation();

        // Pause auto-logout monitoring during confirmation
        if (window.pauseAutoLogoutReset) {
            window.pauseAutoLogoutReset();
        }

        SwalHelper.customConfirm({
            title: 'Konfirmasi Logout',
            message: 'Apakah Anda yakin ingin keluar dari sistem?',
            subMessage: 'Session Anda akan diakhiri dan Anda akan kembali ke halaman login.',
            iconClass: 'fas fa-sign-out-alt',
            iconColor: '#ef4444',
            confirmText: 'Ya, Keluar',
            confirmColor: '#ef4444',
            loadingTitle: 'Memproses Logout',
            loadingMessage: 'Sedang mengakhiri session...',
            onConfirm: () => {
                // Submit form tanpa delay
                document.getElementById('logoutForm').submit();
            },
            onCancel: () => {
                // Resume auto-logout monitoring if cancelled
                if (window.resumeAutoLogoutReset) {
                    window.resumeAutoLogoutReset();
                }
            }
        });
    }
</script>

<style>
    /* Custom SweetAlert Styles untuk Logout */
    .swal2-custom-popup {
        border-radius: 16px !important;
        padding: 24px !important;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3) !important;
        z-index: 99999 !important;
        pointer-events: auto !important; /* Memastikan popup menerima pointer events */
        will-change: transform, opacity; /* Optimize untuk animasi */
        transform: translateZ(0); /* Force GPU acceleration */
        backface-visibility: hidden; /* Mencegah rendering glitches */
    }

    /* SweetAlert Container - Pastikan z-index cukup tinggi */
    .swal2-container {
        z-index: 99999 !important;
        pointer-events: auto !important; /* Memastikan container menerima pointer events */
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
    }

    /* Protect backdrop */
    .swal2-backdrop-show {
        background: rgba(0, 0, 0, 0.5) !important;
        z-index: 99998 !important;
        pointer-events: auto !important;
    }

    .swal2-custom-confirm-button {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        border-radius: 12px !important;
        padding: 12px 24px !important;
        font-weight: 600 !important;
        font-size: 14px !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3) !important;
        pointer-events: auto !important;
    }

    .swal2-custom-confirm-button:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 16px rgba(239, 68, 68, 0.4) !important;
    }

    .swal2-custom-cancel-button {
        background: #64748b !important;
        border-radius: 12px !important;
        padding: 12px 24px !important;
        font-weight: 600 !important;
        font-size: 14px !important;
        transition: all 0.3s ease !important;
        pointer-events: auto !important;
    }

    .swal2-custom-cancel-button:hover {
        background: #475569 !important;
        transform: translateY(-2px) !important;
    }

    /* Marker class untuk logout confirmation */
    .logout-confirmation-active {
        pointer-events: auto !important;
    }
</style>
