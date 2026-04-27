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
            class="sidebar-link {{ request()->routeIs('admin.berita*') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700">
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
        {{-- Statistik Dropdown --}}
        <div class="statistik-dropdown">
            <a href="#" 
                class="sidebar-link dropdown-toggle flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 {{ request()->routeIs('admin.statistik*') ? 'active' : '' }}"
                onclick="toggleStatistikDropdown(event)">
                <div class="flex items-center gap-3">
                    <i class="fas fa-chart-bar w-5"></i>
                    <span class="sidebar-text font-medium">Statistik</span>
                </div>
                <i class="fas fa-chevron-down text-xs"></i>
            </a>
            <div class="dropdown-menu {{ request()->routeIs('admin.statistik*') ? 'active' : '' }}">
                <a href="{{ route('admin.statistik-penduduk.index') }}"
                    class="sidebar-link flex items-center gap-3 px-4 py-2 rounded-lg text-gray-700 text-sm">
                    <i class="fas fa-users w-4"></i>
                    <span class="sidebar-text">Statistik Penduduk</span>
                </a>
                <a href="{{ route('admin.statistik-dokumen.index') }}"
                    class="sidebar-link flex items-center gap-3 px-4 py-2 rounded-lg text-gray-700 text-sm">
                    <i class="fas fa-file-alt w-4"></i>
                    <span class="sidebar-text">Statistik Dokumen</span>
                </a>
                <a href="{{ route('admin.statistik-layanan.index') }}"
                    class="sidebar-link flex items-center gap-3 px-4 py-2 rounded-lg text-gray-700 text-sm">
                    <i class="fas fa-clipboard-list w-4"></i>
                    <span class="sidebar-text">Statistik Layanan</span>
                </a>
            </div>
        </div>

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
            <button type="button" id="sidebarLogoutBtn"
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

    // Statistik Dropdown Toggle
    function toggleStatistikDropdown(event) {
        event.preventDefault();
        const dropdown = event.currentTarget.closest('.statistik-dropdown');
        const menu = dropdown.querySelector('.dropdown-menu');
        const toggle = dropdown.querySelector('.dropdown-toggle');

        menu.classList.toggle('active');
        toggle.classList.toggle('active');
    }

    // Setup logout button event listener
    document.addEventListener('DOMContentLoaded', function() {
        const logoutBtn = document.getElementById('sidebarLogoutBtn');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();

                console.log('Logout button clicked'); // Debug

                // Cek apakah SwalHelper tersedia
                if (typeof SwalHelper !== 'undefined' && SwalHelper.customConfirm) {
                    console.log('Using SwalHelper.customConfirm'); // Debug
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
                            console.log('Logout confirmed'); // Debug
                            document.getElementById('logoutForm').submit();
                        },
                        onCancel: () => {
                            console.log('Logout cancelled'); // Debug
                            if (window.resumeAutoLogoutReset) {
                                window.resumeAutoLogoutReset();
                            }
                        }
                    });
                } else if (typeof Swal !== 'undefined') {
                    console.log('Using Swal.fire fallback'); // Debug
                    Swal.fire({
                        title: 'Konfirmasi Logout',
                        text: 'Apakah Anda yakin ingin keluar dari sistem?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Ya, Keluar',
                        cancelButtonText: 'Batal',
                        reverseButtons: true, // Batal di kiri, Ya, Keluar di kanan
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            console.log('Logout confirmed via Swal.fire'); // Debug
                            document.getElementById('logoutForm').submit();
                        }
                    });
                } else {
                    console.warn('SwalHelper dan Swal tidak tersedia, menggunakan konfirmasi default browser');
                    if (confirm('Apakah Anda yakin ingin keluar dari sistem?')) {
                        document.getElementById('logoutForm').submit();
                    }
                }
            }, { passive: false });
        }
    });
</script>