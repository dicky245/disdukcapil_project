@props([
    'role' => 'admin',
    'activeRoute' => null
])

@php
    $menu_items = match($role) {
        'admin' => [
            ['icon' => 'fa-home', 'label' => 'Dashboard', 'route' => 'admin.dashboard'],
            ['divider' => true, 'label' => 'Manajemen'],
            ['icon' => 'fa-newspaper', 'label' => 'Kelola Berita', 'route' => 'admin.kelola_berita'],
            ['icon' => 'fa-sitemap', 'label' => 'Organisasi', 'route' => 'admin.organisasi'],
            ['icon' => 'fa-trophy', 'label' => 'Penghargaan', 'route' => 'admin.penghargaan'],
            ['icon' => 'fa-balance-scale', 'label' => 'Dasar Hukum', 'route' => 'admin.dasar_hukum'],
            ['icon' => 'fa-chart-bar', 'label' => 'Statistik', 'route' => 'admin.statistik'],
            ['divider' => true, 'label' => 'Layanan'],
            ['icon' => 'fa-ticket-alt', 'label' => 'Antrian Online', 'route' => 'admin.antrian_online'],
            ['icon' => 'fa-clipboard-list', 'label' => 'Konfirmasi Status', 'route' => 'admin.konfirmasi_status'],
            ['icon' => 'fa-list', 'label' => 'Kelola Layanan', 'route' => 'admin.kelola_layanan'],
            ['divider' => true, 'label' => 'Akun'],
            ['icon' => 'fa-users-cog', 'label' => 'Manajemen Akun', 'route' => 'admin.manajemen_akun'],
            ['icon' => 'fa-pray', 'label' => 'Akun Keagamaan', 'route' => 'admin.akun_keagamaan'],
        ],
        'keagamaan' => [
            ['icon' => 'fa-home', 'label' => 'Dashboard', 'route' => 'keagamaan.dashboard'],
            ['divider' => true, 'label' => 'Menu Keagamaan'],
            ['icon' => 'fa-calendar-alt', 'label' => 'Antrian & Kalender', 'route' => 'keagamaan.antrian_kalender'],
            ['icon' => 'fa-sync', 'label' => 'Sinkronisasi Dukcapil', 'route' => 'keagamaan.sinkronisasi_dukcapil'],
            ['icon' => 'fa-file-alt', 'label' => 'Manajemen Dokumen', 'route' => 'keagamaan.manajemen_dokumen'],
            ['icon' => 'fa-search', 'label' => 'Lacak Berkas', 'route' => 'keagamaan.lacak_berkas'],
        ],
        default => []
    };
@endphp

<aside class="sidebar h-full w-64 bg-white border-r border-gray-200 shadow-lg flex-shrink-0" id="sidebar">
    <div class="h-16 flex items-center px-6 border-b border-gray-100">
        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center flex-shrink-0">
            <span class="text-lg">🏛️</span>
        </div>
        <span class="sidebar-text logo-text ml-3 font-bold text-lg text-gray-800">Disdukcapil</span>
    </div>

    <nav class="p-4 space-y-1 overflow-y-auto h-[calc(100vh-4rem)]">
        @foreach($menu_items as $item)
            @if(isset($item['divider']))
                <div class="pt-4 pb-2">
                    <p class="sidebar-text px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ $item['label'] }}</p>
                </div>
            @else
                @php
                    $isActive = $activeRoute && $item['route'] === $activeRoute;
                @endphp
                <a href="{{ route($item['route']) }}" class="sidebar-link {{ $isActive ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700">
                    <i class="fas {{ $item['icon'] }} w-5"></i>
                    <span class="sidebar-text font-medium">{{ $item['label'] }}</span>
                </a>
            @endif
        @endforeach

        <div class="pt-4 pb-2">
            <p class="sidebar-text px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Akun</p>
        </div>

        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="sidebar-link w-full flex items-center gap-3 px-4 py-3 rounded-lg text-red-600 hover:bg-red-50">
                <i class="fas fa-sign-out-alt w-5"></i>
                <span class="sidebar-text font-medium">Logout</span>
            </button>
        </form>
    </nav>

    {{-- Mobile Sidebar Overlay --}}
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden" onclick="toggleSidebar()"></div>
</aside>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        if (sidebar && overlay) {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('hidden');
        }
    }
</script>
