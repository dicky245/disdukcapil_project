{{-- Header Navigation --}}
<header class="fixed top-0 left-0 right-0 bg-white/95 backdrop-blur-md shadow-sm z-50 transition-all duration-300" id="mainHeader">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 hover:scale-105 transition-transform">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center">
                    <span class="text-xl">🏛️</span>
                </div>
                <div>
                    <span class="text-lg font-bold text-gray-800">Disdukcapil Toba</span>
                    <p class="text-xs text-gray-500 -mt-1">Kabupaten Toba</p>
                </div>
            </a>

            {{-- Desktop Navigation --}}
            <nav class="hidden md:flex items-center gap-1">
                <a href="{{ route('home') }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('home') ? 'text-blue-600 bg-blue-50' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50' }} transition">
                    <i class="fas fa-home mr-2"></i>Beranda
                </a>
                <a href="{{ route('antrian-online') }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('antrian-online*') ? 'text-blue-600 bg-blue-50' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50' }} transition">
                    <i class="fas fa-ticket-alt mr-2"></i>Antrian Online
                </a>
                <a href="{{ route('layanan-mandiri') }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('layanan-mandiri*') ? 'text-blue-600 bg-blue-50' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50' }} transition">
                    <i class="fas fa-rocket mr-2"></i>Layanan Mandiri
                </a>
                <a href="{{ route('statistik') }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('statistik') ? 'text-blue-600 bg-blue-50' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50' }} transition">
                    <i class="fas fa-chart-line mr-2"></i>Statistik
                </a>
                <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login
                </a>
            </nav>

            {{-- Mobile Menu Button --}}
            <button id="mobileMenuBtn" class="md:hidden p-2 rounded-lg hover:bg-gray-100">
                <i class="fas fa-bars text-gray-600"></i>
            </button>
        </div>
    </div>

    {{-- Mobile Navigation --}}
    <div id="mobileMenu" class="md:hidden hidden bg-white border-t">
        <nav class="px-4 py-3 space-y-1">
            <a href="{{ route('home') }}" class="block px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('home') ? 'text-blue-600 bg-blue-50' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50' }}">
                <i class="fas fa-home mr-2"></i>Beranda
            </a>
            <a href="{{ route('antrian-online') }}" class="block px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50">
                <i class="fas fa-ticket-alt mr-2"></i>Antrian Online
            </a>
            <a href="{{ route('layanan-mandiri') }}" class="block px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50">
                <i class="fas fa-rocket mr-2"></i>Layanan Mandiri
            </a>
            <a href="{{ route('statistik') }}" class="block px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50">
                <i class="fas fa-chart-line mr-2"></i>Statistik
            </a>
            <a href="{{ route('login') }}" class="block px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50">
                <i class="fas fa-sign-in-alt mr-2"></i>Login
            </a>
        </nav>
    </div>
</header>

<div class="h-16"></div>

<script>
    // Mobile Menu Toggle
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');

        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        }
    });
</script>
