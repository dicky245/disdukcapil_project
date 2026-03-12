{{-- Keagamaan Footer --}}
<footer class="bg-white border-t border-gray-200 py-6 ml-64 mt-auto">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-600">
            <div class="flex items-center gap-3 mb-4 md:mb-0">
                <div class="w-8 h-8 bg-gradient-to-br from-teal-600 to-teal-700 rounded-lg flex items-center justify-center overflow-hidden p-1">
                    <img src="{{ asset('images/logo_toba.jpeg') }}" alt="Logo Toba" class="w-full h-full object-contain">
                </div>
                <p>&copy; {{ date('Y') }} Disdukcapil Kabupaten Toba - Layanan Keagamaan</p>
            </div>
            <div class="flex gap-6">
                <a href="{{ route('home') }}" class="hover:text-teal-600 transition">Ke Halaman Utama</a>
                <a href="#" class="hover:text-teal-600 transition">Bantuan</a>
            </div>
        </div>
    </div>
</footer>
