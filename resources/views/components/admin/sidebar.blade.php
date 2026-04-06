{{-- Admin Sidebar --}}
<aside class="sidebar fixed left-0 top-0 h-full w-64 bg-white border-r border-gray-200 z-50 shadow-lg">
    {{-- Logo --}}
    <div class="h-16 flex items-center px-6 border-b border-gray-100">
        <div class="w-10 h-10 rounded-xl overflow-hidden flex-shrink-0">
            <img src="{{ asset('images/logo_toba.jpeg') }}" alt="Logo Kabupaten Toba" class="w-full h-full object-contain">
        </div>
        <span class="sidebar-text logo-text ml-3 font-bold text-lg text-gray-800">Disdukcapil</span>
    </div>

    {{-- Navigation --}}
    <nav class="p-4 space-y-1 overflow-y-auto h-[calc(100vh-4rem)]">
        <a href="{{ route('admin.dashboard') }}"
            class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700">
            <i class="fas fa-home w-5"></i>
            <span class="sidebar-text font-medium">Dashboard</span>
        </a>

        <div class="pt-4 pb-2">
            <p class="sidebar-text px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Manajemen</p>
        </div>

        <a href="{{ route('admin.berita') }}"
            class="sidebar-link {{ request()->routeIs('admin.berita') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700">
            <i class="fas fa-newspaper w-5"></i>
            <span class="sidebar-text font-medium">Kelola Berita</span>
        </a>
        <a href="{{ route('admin.organisasi') }}"
            class="sidebar-link {{ request()->routeIs('admin.organisasi') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700">
            <i class="fas fa-sitemap w-5"></i>
            <span class="sidebar-text font-medium">Organisasi</span>
        </a>
        <a href="{{ route('admin.penghargaan') }}"
            class="sidebar-link {{ request()->routeIs('admin.penghargaan') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700">
            <i class="fas fa-trophy w-5"></i>
            <span class="sidebar-text font-medium">Penghargaan</span>
        </a>
        <a href="{{ route('admin.dasar-hukum') }}"
            class="sidebar-link {{ request()->routeIs('admin.dasar-hukum') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700">
            <i class="fas fa-balance-scale w-5"></i>
            <span class="sidebar-text font-medium">Dasar Hukum</span>
        </a>
        <a href="{{ route('admin.visualisasi-data') }}"
            class="sidebar-link {{ request()->routeIs('admin.visualisasi-data') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700">
            <i class="fas fa-chart-bar w-5"></i>
            <span class="sidebar-text font-medium">Statistik</span>
        </a>

        <div class="pt-4 pb-2">
            <p class="sidebar-text px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Layanan</p>
        </div>

        <a href="{{ route('admin.antrian-online') }}"
            class="sidebar-link {{ request()->routeIs('admin.antrian-online') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700">
            <i class="fas fa-ticket-alt w-5"></i>
            <span class="sidebar-text font-medium">Antrian Online</span>
        </a>

        {{-- Kelola Layanan Dropdown --}}
        <div class="layanan-dropdown">
            <a href="#"
                class="sidebar-link dropdown-toggle flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700"
                onclick="toggleDropdown(event)">
                <div class="flex items-center gap-3">
                    <i class="fas fa-file-alt w-5"></i>
                    <span class="sidebar-text font-medium">Kelola Layanan</span>
                </div>
                <i class="fas fa-chevron-down text-xs"></i>
            </a>
            <div class="dropdown-menu">
                <a href="{{ route('admin.penerbitan-kk') }}"
                    class="sidebar-link flex items-center gap-3 px-4 py-2 rounded-lg text-gray-700 text-sm">
                    <i class="fas fa-address-card w-4"></i>
                    <span class="sidebar-text">Kartu Keluarga</span>
                </a>
                <a href="{{ route('admin.penerbitan-akte-lahir') }}"
                    class="sidebar-link flex items-center gap-3 px-4 py-2 rounded-lg text-gray-700 text-sm">
                    <i class="fas fa-baby w-4"></i>
                    <span class="sidebar-text">Akta Kelahiran</span>
                </a>
                <a href="{{ route('admin.penerbitan-akte-kematian') }}"
                    class="sidebar-link flex items-center gap-3 px-4 py-2 rounded-lg text-gray-700 text-sm">
                    <i class="fas fa-user-times w-4"></i>
                    <span class="sidebar-text">Akta Kematian</span>
                </a>
                <a href="{{ route('admin.penerbitan-lahir-mati') }}"
                    class="sidebar-link flex items-center gap-3 px-4 py-2 rounded-lg text-gray-700 text-sm">
                    <i class="fas fa-exchange-alt w-4"></i>
                    <span class="sidebar-text">Lahir Mati</span>
                </a>
                <a href="{{ route('admin.penerbitan-pernikahan') }}"
                    class="sidebar-link flex items-center gap-3 px-4 py-2 rounded-lg text-gray-700 text-sm">
                    <i class="fas fa-ring w-4"></i>
                    <span class="sidebar-text">Akta Pernikahan</span>
                </a>
            </div>
        </div>

        <div class="pt-4 pb-2">
            <p class="sidebar-text px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Akun</p>
        </div>

        <a href="{{ route('admin.manajemen-akun') }}"
            class="sidebar-link {{ request()->routeIs('admin.manajemen-akun') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700">
            <i class="fas fa-users-cog w-5"></i>
            <span class="sidebar-text font-medium">Manajemen Akun</span>
        </a>
        <form method="POST" action="{{ route('logout') }}" id="logoutForm" class="inline">
            @csrf
            <button type="button" onclick="handleSidebarLogout(event)"
                class="sidebar-link w-full flex items-center gap-3 px-4 py-3 rounded-lg text-red-600 hover:bg-red-50 transition-all">
                <i class="fas fa-sign-out-alt w-5"></i>
                <span class="sidebar-text font-medium">Logout</span>
            </button>
        </form>
    </nav>
</aside>

<script>
    // Sidebar Toggle
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');
    const sidebarToggle = document.getElementById('sidebarToggle');

    if (sidebarToggle && sidebar && mainContent) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });
    }

    // Dropdown Toggle
    function toggleDropdown(event) {
        event.preventDefault();
        const dropdown = event.currentTarget.closest('.layanan-dropdown');
        const menu = dropdown.querySelector('.dropdown-menu');
        const toggle = dropdown.querySelector('.dropdown-toggle');

        menu.classList.toggle('active');
        toggle.classList.toggle('active');
    }

    // Logout Handler - SweetAlert Confirmation
    function handleSidebarLogout(event) {
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
