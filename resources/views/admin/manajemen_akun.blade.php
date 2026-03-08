<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Akun - Disdukcapil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: { brand: { 600: '#0052CC', 700: '#003d99' } }
                }
            }
        }
    </script>
    <style>
        .sidebar {
            transition: all 0.3s ease;
            width: 260px;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar.collapsed .sidebar-text,
        .sidebar.collapsed .logo-text,
        .sidebar.collapsed .fa-chevron-down {
            display: none;
        }

        .sidebar-link {
            transition: all 0.2s;
            border-left: 4px solid transparent;
            color: #4b5563;
            font-weight: 500;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            color: #0052CC;
            background: #f8fafc;
        }

        .sidebar-link.active {
            border-left-color: #0052CC;
            background: #f0f7ff;
            font-weight: 700;
        }

        .dropdown-menu {
            display: none;
        }

        .dropdown-menu.active {
            display: block;
        }

        .main-content {
            transition: all 0.3s ease;
            margin-left: 260px;
        }

        .main-content.expanded {
            margin-left: 80px;
        }

        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 100;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans antialiased">

    <aside id="sidebar" class="sidebar fixed left-0 top-0 h-full bg-white border-r border-gray-100 z-50 shadow-sm">
        <div class="h-20 flex items-center px-6 mb-4">
            <div
                class="w-10 h-10 bg-[#0052CC] rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-blue-100">
                <i class="fas fa-university text-white text-lg"></i>
            </div>
            <span class="logo-text ml-4 font-bold text-xl text-gray-800 tracking-tight">Disdukcapil</span>
        </div>

        <nav class="px-3 space-y-1 overflow-y-auto h-[calc(100vh-6rem)]">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl">
                <i class="fas fa-home w-6 text-center text-lg"></i>
                <span class="sidebar-text">Dashboard</span>
            </a>

            <div class="pt-6 pb-2 px-4">
                <p class="sidebar-text text-[11px] font-bold text-gray-400 uppercase tracking-[2px]">Manajemen</p>
            </div>
            <a href="#" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl"><i
                    class="fas fa-newspaper w-6 text-center text-lg"></i><span class="sidebar-text">Kelola
                    Berita</span></a>
            <a href="#" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl"><i
                    class="fas fa-sitemap w-6 text-center text-lg"></i><span class="sidebar-text">Organisasi</span></a>
            <a href="#" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl"><i
                    class="fas fa-trophy w-6 text-center text-lg"></i><span class="sidebar-text">Penghargaan</span></a>
            <a href="#" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl"><i
                    class="fas fa-balance-scale w-6 text-center text-lg"></i><span class="sidebar-text">Dasar
                    Hukum</span></a>
            <a href="#" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl"><i
                    class="fas fa-chart-line w-6 text-center text-lg"></i><span
                    class="sidebar-text">Statistik</span></a>

            <div class="pt-6 pb-2 px-4">
                <p class="sidebar-text text-[11px] font-bold text-gray-400 uppercase tracking-[2px]">Layanan</p>
            </div>
            <a href="#" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl"><i
                    class="fas fa-clock w-6 text-center text-lg"></i><span class="sidebar-text">Antrian
                    Online</span></a>
            <a href="#" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl"><i
                    class="fas fa-clipboard-check w-6 text-center text-lg"></i><span class="sidebar-text">Konfirmasi
                    Status</span></a>

            <div class="layanan-dropdown">
                <button onclick="toggleDropdown(event)"
                    class="w-full sidebar-link flex items-center justify-between px-4 py-3 rounded-xl outline-none">
                    <div class="flex items-center gap-3"><i class="fas fa-list-ul w-6 text-center text-lg"></i><span
                            class="sidebar-text">Kelola Layanan</span></div>
                    <i class="fas fa-chevron-down text-[10px] sidebar-text transition-transform"></i>
                </button>
                <div class="dropdown-menu px-2 py-2 space-y-1 bg-gray-50/50 rounded-xl mx-2">
                    <a href="#" class="block px-8 py-2 text-sm text-gray-500 hover:text-brand-600">Kartu Keluarga</a>
                    <a href="#" class="block px-8 py-2 text-sm text-gray-500 hover:text-brand-600">Akta Kelahiran</a>
                    <a href="#" class="block px-8 py-2 text-sm text-gray-500 hover:text-brand-600">Akta Kematian</a>
                    <a href="#" class="block px-8 py-2 text-sm text-gray-500 hover:text-brand-600">Lahir Mati</a>
                    <a href="#" class="block px-8 py-2 text-sm text-gray-500 hover:text-brand-600">Akta Pernikahan</a>
                </div>
            </div>

            <div class="pt-6 pb-2 px-4">
                <p class="sidebar-text text-[11px] font-bold text-gray-400 uppercase tracking-[2px]">Akun</p>
            </div>
            <a href="#" class="sidebar-link active flex items-center gap-3 px-4 py-3 rounded-xl"><i
                    class="fas fa-users-cog w-6 text-center text-lg"></i><span class="sidebar-text">Manajemen
                    Akun</span></a>
            <a href="#" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl"><i
                    class="fas fa-pray w-6 text-center text-lg"></i><span class="sidebar-text">Akun Keagamaan</span></a>

        <div class="pt-10 pb-8">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <a href="#" onclick="handleLogout()"
                class="flex items-center gap-3 px-8 py-3 text-[#E53E3E] font-bold hover:bg-red-50 rounded-xl transition-all">
                <i class="fas fa-sign-out-alt text-lg"></i>
                <span class="sidebar-text">Logout</span>
            </a>
        </div>
        </nav>
    </aside>
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif
    
    @if($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: "{{ $errors->first() }}",
            });
        </script>
    @endif
    </div>
    </main>
    <main id="mainContent" class="main-content min-h-screen">
        <header
            class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-40 px-8 py-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar()" class="p-2 hover:bg-gray-100 rounded-lg text-gray-500"><i
                        class="fas fa-bars"></i></button>
                <h1 class="text-xl font-bold text-gray-800">Manajemen Akun</h1>
            </div>

            <div class="flex items-center gap-3 pl-4 border-l border-gray-200">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-gray-800">Administrator</p>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Super Admin</p>
                </div>
                <div
                    class="w-10 h-10 bg-brand-600 rounded-full flex items-center justify-center text-white shadow-lg shadow-blue-100">
                    <i class="fas fa-user-shield"></i>
                </div>
            </div>
        </header>

        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-xl">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <p class="text-gray-400 text-[11px] font-bold uppercase tracking-wider">Total Akun</p>
                        <h3 class="text-2xl font-black" id="statTotal">{{ $users->where('role', 'Petugas')->count() }}
                        </h3>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
                    <div
                        class="w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center text-xl">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div>
                        <p class="text-gray-400 text-[11px] font-bold uppercase tracking-wider">Akun Aktif</p>
                        <h3 class="text-2xl font-black text-green-600" id="statActive">
                            {{ $users->where('role', 'Petugas')->where('status', 'active')->count() }}
                        </h3>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 bg-red-50 text-red-600 rounded-xl flex items-center justify-center text-xl"><i
                            class="fas fa-user-slash"></i></div>
                    <div>
                        <p class="text-gray-400 text-[11px] font-bold uppercase tracking-wider">Non-Aktif</p>
                        <h3 class="text-2xl font-black text-red-600" id="statInactive">
                            {{ $users->where('role', 'Petugas')->where('status', 'inactive')->count() }}
                        </h3>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden mb-8">
                <div class="p-6 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="relative w-full md:w-1/2">
                        <input type="text" id="searchBox" onkeyup="filterAccounts()"
                            placeholder="Cari nama atau username..."
                            class="w-full pl-11 pr-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-brand-600 outline-none">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                    <button onclick="openAddModal()"
                        class="w-full md:w-auto px-8 py-3 bg-brand-600 text-white rounded-2xl font-bold flex items-center gap-2 hover:bg-brand-700 shadow-lg shadow-blue-100 transition-all">
                        <i class="fas fa-plus"></i> Tambah Akun
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left" id="userTable">
                        <thead class="bg-gray-50 text-[11px] uppercase font-bold text-gray-400 tracking-widest">
                            <tr>
                                <th class="px-8 py-5">Nama Lengkap</th>
                                <th class="px-8 py-5 text-center">Username</th>
                                <th class="px-8 py-5 text-center">Jenis Keagamaan</th>
                                <th class="px-8 py-5 text-center">No. Telepon</th>
                                <th class="px-8 py-5 text-center">Status</th>
                                <th class="px-8 py-5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="accountTableBody" class="divide-y divide-gray-50">
                            @foreach($users->where('role', 'Petugas') as $user)
                                <tr class="hover:bg-gray-50/50">
                                    <td class="px-8 py-5 font-bold text-gray-700">{{ $user->name }}</td>
                                    <td class="px-8 py-5 text-center text-gray-500 italic">@ {{ $user->username }}</td>
                                    <td class="px-8 py-5 text-center">
                                        <span
                                            class="px-3 py-1 bg-brand-50 text-brand-600 rounded-lg text-[10px] font-bold uppercase tracking-widest">{{ $user->agama }}</span>
                                    </td>
                                    <td class="px-8 py-5 text-center text-gray-600">{{ $user->phone ?? '-' }}</td>
                                    <td class="px-8 py-5 text-center">
                                        <span
                                            class="px-3 py-1 rounded-full text-[10px] font-bold {{ $user->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} uppercase">
                                            {{ $user->status === 'active' ? 'Aktif' : 'Non-Aktif' }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-5 text-center">
                                        <button onclick="editAccount({{ json_encode($user) }})"
                                            class="px-4 py-2 bg-gray-100 text-brand-600 rounded-xl text-xs font-bold hover:bg-brand-600 hover:text-white transition-all">
                                            <i class="fas fa-edit mr-1"></i> Edit Akun
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="religionStats" class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-10">
                @php $religions = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha']; @endphp
                @foreach($religions as $rel)
                    <div class="p-4 bg-white rounded-2xl border border-gray-100 shadow-sm text-center">
                        <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">{{ $rel }}</p>
                        <p class="text-xl font-black text-brand-600">
                            {{ $users->where('role', 'Petugas')->where('agama', $rel)->count() }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </main>

    <div id="accountModal" class="modal">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg p-0 mx-4 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-800" id="modalTitle">Tambah Akun Baru</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition"><i
                        class="fas fa-times"></i></button>
            </div>

            <form id="accountForm" action="{{ route('admin.manajemen-akun.store') }}" method="POST"
                class="p-6 space-y-5">
                @csrf
                <input type="hidden" name="accountId" id="accountId">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap *</label>
                        <input type="text" name="name" id="fullName" required
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 outline-none focus:ring-2 focus:ring-brand-600">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Username *</label>
                        <input type="text" name="username" id="username" required
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 outline-none focus:ring-2 focus:ring-brand-600">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Agama *</label>
                    <select name="agama" id="agama" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 outline-none focus:ring-2 focus:ring-brand-600">
                        <option value="">Pilih Agama</option>
                        @foreach($list_agama as $agama)
                            <option value="{{ $agama->nama_jenis_keagamaan }}">{{ $agama->nama_jenis_keagamaan }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" id="password" placeholder="Isi jika ingin ganti password"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 outline-none focus:ring-2 focus:ring-brand-600">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">No. Telepon</label>
                        <input type="text" name="phone" id="phone"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 outline-none focus:ring-2 focus:ring-brand-600">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Status *</label>
                        <select name="status" id="status"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 outline-none focus:ring-2 focus:ring-brand-600">
                            <option value="active">Aktif</option>
                            <option value="inactive">Non-Aktif</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t">
                    <button type="submit"
                        class="flex-1 py-3 bg-brand-600 text-white rounded-xl font-bold hover:bg-brand-700 transition shadow-lg shadow-blue-100">
                        <i class="fas fa-save mr-2"></i> Simpan Akun
                    </button>
                    <button type="button" onclick="closeModal()"
                        class="px-6 py-3 border border-gray-200 text-gray-600 rounded-xl font-bold hover:bg-gray-50">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('collapsed');
            document.getElementById('mainContent').classList.toggle('expanded');
        }

        function toggleDropdown(e) {
            e.currentTarget.nextElementSibling.classList.toggle('active');
            e.currentTarget.querySelector('.fa-chevron-down').classList.toggle('rotate-180');
        }

       function handleLogout() {
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: "Apakah Anda yakin ingin keluar?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0052CC',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mengirimkan form POST secara otomatis
                    document.getElementById('logout-form').submit();
                }
            });
        }

        function openAddModal() {
            document.getElementById('accountForm').reset();
            document.getElementById('accountId').value = '';
            document.getElementById('modalTitle').innerText = 'Tambah Akun Baru';
            document.getElementById('password').required = true;
            document.getElementById('accountModal').classList.add('active');
        }

        function editAccount(user) {
            document.getElementById('accountId').value = user.id;
            document.getElementById('fullName').value = user.name;
            document.getElementById('username').value = user.username;
            document.getElementById('agama').value = user.agama;
            document.getElementById('phone').value = user.phone;
            document.getElementById('status').value = user.status;

            document.getElementById('modalTitle').innerText = 'Edit Akun & Status';
            document.getElementById('password').required = false;
            document.getElementById('accountModal').classList.add('active');
        }

        function closeModal() { document.getElementById('accountModal').classList.remove('active'); }

        function filterAccounts() {
            const q = document.getElementById('searchBox').value.toLowerCase();
            const rows = document.querySelectorAll('#accountTableBody tr');

            rows.forEach(row => {
                const name = row.children[0].innerText.toLowerCase();
                const user = row.children[1].innerText.toLowerCase();
                if (name.includes(q) || user.includes(q)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }
    </script>
</body>

</html>