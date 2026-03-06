{{-- Footer --}}
<footer class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid md:grid-cols-4 gap-8">
            <div class="md:col-span-2">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center">
                        <span class="text-2xl">🏛️</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold">Disdukcapil Toba</h3>
                        <p class="text-gray-400 text-sm">Kabupaten Toba</p>
                    </div>
                </div>
                <p class="text-gray-400 mb-4">
                    Melayani dengan sepenuh hati untuk administrasi kependudukan yang tertib dan modern
                </p>
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-blue-600 rounded-lg flex items-center justify-center transition">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-blue-600 rounded-lg flex items-center justify-center transition">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-blue-600 rounded-lg flex items-center justify-center transition">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-blue-600 rounded-lg flex items-center justify-center transition">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
            <div>
                <h4 class="font-bold mb-4">Layanan</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="{{ url('layanan-mandiri') }}" class="hover:text-blue-400 transition">Layanan Mandiri</a></li>
                    <li><a href="{{ url('antrian-online') }}" class="hover:text-blue-400 transition">Antrian Online</a></li>
                    <li><a href="{{ url('statistik') }}" class="hover:text-blue-400 transition">Statistik</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-4">Kontak</h4>
                <ul class="space-y-2 text-gray-400">
                    <li class="flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-blue-500"></i>
                        Balige, Kabupaten Toba
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fas fa-phone text-blue-500"></i>
                        (0632) 123456
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fas fa-envelope text-blue-500"></i>
                        info@disdukcapil-toba.go.id
                    </li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-500">
            <p>&copy; {{ date('Y') }} Disdukcapil Kabupaten Toba. Seluruh hak cipta dilindungi.</p>
        </div>
    </div>
</footer>
