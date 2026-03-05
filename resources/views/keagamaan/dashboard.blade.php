<x-layouts-app title="Dashboard Keagamaan" role="keagamaan" activeRoute="keagamaan.dashboard">
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl p-6 md:p-8 text-white mb-6 reveal">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold mb-2">Selamat Datang, Admin Keagamaan!</h2>
                <p class="text-blue-100 text-lg">Berikut adalah ringkasan aktivitas pernikahan hari ini</p>
            </div>
            <div class="flex flex-col gap-2 text-sm">
                <div class="flex items-center gap-2">
                    <i class="fas fa-calendar-alt"></i>
                    <span id="currentDate">{{ now()->isoFormat('dddd, D MMMM Y') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-clock"></i>
                    <span id="currentTime">{{ now()->format('H:i') }} WIB</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6 reveal">
        <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-inbox text-xl text-blue-600"></i>
                </div>
                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                    <i class="fas fa-clock mr-1"></i>Pending
                </span>
            </div>
            <h3 class="text-3xl font-extrabold text-gray-800 mb-1">24</h3>
            <p class="text-sm text-gray-600 font-medium">Request Masuk</p>
        </div>

        <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-xl text-emerald-600"></i>
                </div>
                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-semibold">
                    <i class="fas fa-arrow-up mr-1"></i>15%
                </span>
            </div>
            <h3 class="text-3xl font-extrabold text-gray-800 mb-1">156</h3>
            <p class="text-sm text-gray-600 font-medium">Request Disetujui</p>
        </div>

        <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-ring text-xl text-purple-600"></i>
                </div>
                <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-semibold">
                    <i class="fas fa-calendar mr-1"></i>Bulan Ini
                </span>
            </div>
            <h3 class="text-3xl font-extrabold text-gray-800 mb-1">38</h3>
            <p class="text-sm text-gray-600 font-medium">Total Pernikahan Bulan Ini</p>
        </div>

        <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-hourglass-half text-xl text-yellow-600"></i>
                </div>
                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">
                    <i class="fas fa-sync mr-1"></i>Proses
                </span>
            </div>
            <h3 class="text-3xl font-extrabold text-gray-800 mb-1">12</h3>
            <p class="text-sm text-gray-600 font-medium">Menunggu Verifikasi</p>
        </div>
    </div>
</x-layouts-app>
