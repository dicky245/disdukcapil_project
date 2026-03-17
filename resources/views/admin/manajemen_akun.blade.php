@extends('layouts.admin')

@section('content')
{{-- Welcome Banner --}}
<div class="bg-gradient-to-r from-blue-600 to-cyan-600 rounded-2xl p-6 md:p-8 text-white mb-6 reveal shadow-lg">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div>
            <h2 class="text-2xl md:text-3xl font-bold mb-2">Manajemen Akun</h2>
            <p class="text-blue-100 text-lg">Kelola akun keagamaan dan petugas di sistem Disdukcapil</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="bg-white/20 backdrop-blur-sm rounded-xl px-4 py-2">
                <p class="text-xs text-blue-100">Total Akun</p>
                <p class="text-2xl font-bold">{{ $users->count() }}</p>
            </div>
        </div>
    </div>
</div>

{{-- Statistics Cards --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 reveal">
    <div class="stat-card bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-users text-xl text-indigo-600"></i>
            </div>
            <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded-full">
                Total
            </span>
        </div>
        <h3 class="text-3xl font-extrabold text-gray-800 mb-1">{{ $users->count() }}</h3>
        <p class="text-sm text-gray-600 font-medium">Total Akun</p>
    </div>

    <div class="stat-card bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-check text-xl text-green-600"></i>
            </div>
            <span class="text-xs font-medium text-green-600 bg-green-50 px-2 py-1 rounded-full">
                <i class="fas fa-check mr-1"></i>Aktif
            </span>
        </div>
        <h3 class="text-3xl font-extrabold text-gray-800 mb-1 text-green-600">
            {{ $users->where('detail_keagamaan.status', 'aktif')->count() }}
        </h3>
        <p class="text-sm text-gray-600 font-medium">Akun Aktif</p>
    </div>

    <div class="stat-card bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-slash text-xl text-red-600"></i>
            </div>
            <span class="text-xs font-medium text-red-600 bg-red-50 px-2 py-1 rounded-full">
                <i class="fas fa-ban mr-1"></i>Non-Aktif
            </span>
        </div>
        <h3 class="text-3xl font-extrabold text-gray-800 mb-1 text-red-600">
            {{ $users->where('detail_keagamaan.status', 'non-aktif')->count() }}
        </h3>
        <p class="text-sm text-gray-600 font-medium">Non-Aktif</p>
    </div>
</div>

 {{-- Search and Add Button --}}
<div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden mb-8 reveal">
    <div class="p-6 flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="relative w-full md:w-1/2">
            <input type="text" id="searchBox" onkeyup="filterAccounts()"
                placeholder="Cari nama atau username..."
                class="w-full pl-11 pr-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
        </div>
        <button onclick="openAddModal()"
            class="w-full md:w-auto px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg flex items-center gap-2">
            <i class="fas fa-plus"></i> Tambah Akun
        </button>
    </div>

    {{-- User Table --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left" id="userTable">
            <thead class="bg-gray-50 text-[11px] uppercase font-bold text-gray-400 tracking-widest">
                <tr>
                    <th class="px-8 py-5">Nama Lengkap</th>
                    <th class="px-8 py-5">Username</th>
                    <th class="px-8 py-5">Agama</th>
                    <th class="px-8 py-5">Alamat</th>
                    <th class="px-8 py-5 text-center">Status</th>
                    <th class="px-8 py-5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="accountTableBody" class="divide-y divide-gray-50">
                @foreach($users as $user)
                    <tr class="hover:bg-gray-50/50">
                        <td class="px-8 py-5 font-bold text-gray-700">{{ $user->name }}</td>
                        <td class="px-8 py-5 text-gray-500 italic">@ {{ $user->username }}</td>
                        <td class="px-8 py-5">
                            <span
                                class="px-3 py-1 bg-brand-50 text-brand-600 rounded-lg text-[10px] font-bold uppercase tracking-widest">
                                {{ $user->detail_keagamaan->jenis_keagamaan->nama_jenis_keagamaan ?? 'Umum' }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-gray-600">{{ $user->detail_keagamaan->alamat ?? '-' }}</td>
                        <td class="px-8 py-5 text-center">
                            <span
                                class="px-3 py-1 rounded-full text-[10px] font-bold {{ ($user->detail_keagamaan->status ?? 'aktif') === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} uppercase">
                                {{ ($user->detail_keagamaan->status ?? 'aktif') === 'aktif' ? 'Aktif' : 'Non-Aktif' }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <button onclick="editAccount({{ json_encode($user->load('detail_keagamaan')) }})"
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

 {{-- Religion Statistics --}}
<div id="religionStats" class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-10 reveal">
    @php $religions = ['Islam', 'Kristen Protestan', 'Kristen Katolik', 'Hindu', 'Buddha']; @endphp
    @foreach($religions as $rel)
        <div class="p-4 bg-white rounded-2xl border border-gray-100 shadow-sm text-center">
            <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">{{ $rel }}</p>
            <p class="text-xl font-black text-brand-600">
                {{ $users->filter(function ($u) use ($rel) {
                    return ($u->detail_keagamaan->jenis_keagamaan->nama_jenis_keagamaan ?? '') === $rel;
                })->count() }}
            </p>
        </div>
    @endforeach
</div>

{{-- Modal Form --}}
<div id="accountModal" class="fixed inset-0 z-50 hidden">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg p-0 mx-4 overflow-hidden transform transition-all relative z-10">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-800" id="modalTitle">Tambah Akun Baru</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="accountForm" action="{{ route('admin.manajemen-akun.store') }}" method="POST"
                class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="accountId" id="accountId">

                {{-- Nama & Username --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="fullName" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-600 focus:border-brand-600 outline-none transition text-sm"
                            placeholder="Masukkan nama lengkap">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Username <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="username" id="username_field" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-600 focus:border-brand-600 outline-none transition text-sm"
                            placeholder="Masukkan username">
                    </div>
                </div>

                {{-- Agama --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Agama <span class="text-red-500">*</span>
                    </label>
                    <select name="agama" id="agama_select" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-600 focus:border-brand-600 outline-none transition text-sm bg-white">
                        <option value="" disabled selected>Pilih agama...</option>
                        @foreach($list_agama as $agama)
                            <option value="{{ $agama->jenis_keagamaan_id }}">{{ $agama->nama_jenis_keagamaan }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Alamat --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Alamat Lengkap <span class="text-red-500">*</span>
                    </label>
                    <textarea name="alamat" id="alamat_field" required rows="3"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-600 focus:border-brand-600 outline-none transition text-sm resize-none"
                        placeholder="Contoh: Jl. Sudirman No. 123, Kelurahan..."></textarea>
                </div>

                {{-- Password & Confirm Password --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Password <span id="passwordRequiredLabel" class="text-red-500">*</span>
                            <span id="passwordOptionalLabel" class="text-gray-400 text-xs hidden">(Opsional)</span>
                        </label>
                        <input type="password" name="password" id="password_field"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm"
                            placeholder="Masukkan password">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Konfirmasi Password <span id="passwordConfirmRequiredLabel" class="text-red-500">*</span>
                            <span id="passwordConfirmOptionalLabel" class="text-gray-400 text-xs hidden">(Opsional)</span>
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation_field"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm"
                            placeholder="Ulangi password">
                    </div>
                </div>

                {{-- Info: Status otomatis aktif --}}
                <div class="flex items-center gap-2 px-4 py-3 bg-green-50 border border-green-200 rounded-xl">
                    <i class="fas fa-info-circle text-green-600"></i>
                    <p class="text-sm text-green-700">Status akun akan otomatis diatur sebagai <strong>Aktif</strong></p>
                </div>

                {{-- Buttons --}}
                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                    <button type="submit"
                        class="flex-1 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg">
                        <i class="fas fa-save mr-2"></i> Simpan
                    </button>
                    <button type="button" onclick="closeModal()"
                        class="px-6 py-3 bg-gradient-to-r from-gray-100 to-gray-200 text-gray-800 rounded-xl font-bold hover:from-gray-200 hover:to-gray-300 transition-all shadow-md">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Reveal animation
    function reveal() {
        const reveals = document.querySelectorAll('.reveal');
        reveals.forEach(element => {
            const windowHeight = window.innerHeight;
            const elementTop = element.getBoundingClientRect().top;
            if (elementTop < windowHeight - 50) {
                element.classList.add('active');
            }
        });
    }
    window.addEventListener('scroll', reveal);
    window.addEventListener('load', reveal);

    // Modal functions
    function openAddModal() {
        document.getElementById('accountForm').reset();
        document.getElementById('accountId').value = '';
        document.getElementById('modalTitle').innerText = 'Tambah Akun Baru';

        // Set password as required for new account
        document.getElementById('password_field').required = true;
        document.getElementById('password_confirmation_field').required = true;

        // Show required labels, hide optional labels
        document.getElementById('passwordRequiredLabel').classList.remove('hidden');
        document.getElementById('passwordOptionalLabel').classList.add('hidden');
        document.getElementById('passwordConfirmRequiredLabel').classList.remove('hidden');
        document.getElementById('passwordConfirmOptionalLabel').classList.add('hidden');

        document.getElementById('accountModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function editAccount(user) {
        document.getElementById('accountId').value = user.id;
        document.getElementById('fullName').value = user.name;
        document.getElementById('username_field').value = user.username;

        if (user.detail_keagamaan) {
            document.getElementById('agama_select').value = user.detail_keagamaan.jenis_keagamaan_id;
            document.getElementById('alamat_field').value = user.detail_keagamaan.alamat || '';
        }

        document.getElementById('modalTitle').innerText = 'Edit Akun';

        // Set password as optional for existing account
        document.getElementById('password_field').required = false;
        document.getElementById('password_confirmation_field').required = false;

        // Hide required labels, show optional labels
        document.getElementById('passwordRequiredLabel').classList.add('hidden');
        document.getElementById('passwordOptionalLabel').classList.remove('hidden');
        document.getElementById('passwordConfirmRequiredLabel').classList.add('hidden');
        document.getElementById('passwordConfirmOptionalLabel').classList.remove('hidden');

        document.getElementById('accountModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('accountModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Filter accounts
    function filterAccounts() {
        const q = document.getElementById('searchBox').value.toLowerCase();
        const rows = document.querySelectorAll('#accountTableBody tr');
        rows.forEach(row => {
            const name = row.children[0].innerText.toLowerCase();
            const user = row.children[1].innerText.toLowerCase();
            row.style.display = (name.includes(q) || user.includes(q)) ? "" : "none";
        });
    }

    // Form validation for password confirmation
    document.addEventListener('DOMContentLoaded', function() {
        const accountForm = document.getElementById('accountForm');
        if (accountForm) {
            accountForm.addEventListener('submit', function(e) {
                const accountId = document.getElementById('accountId').value;
                const password = document.getElementById('password_field').value;
                const passwordConfirmation = document.getElementById('password_confirmation_field').value;

                // Untuk akun baru (accountId kosong), password wajib diisi
                if (!accountId) {
                    if (!password) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Password Wajib Diisi!',
                            text: 'Silakan masukkan password minimal 6 karakter untuk akun baru.',
                            confirmButtonColor: '#0052CC'
                        });
                        return false;
                    }
                    if (password.length < 6) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Password Terlalu Pendek!',
                            text: 'Password minimal 6 karakter.',
                            confirmButtonColor: '#0052CC'
                        });
                        return false;
                    }
                }

                // Validasi password confirmation
                const passwordValue = document.getElementById('password_field').value;
                const passwordConfirmValue = document.getElementById('password_confirmation_field').value;

                // Jika password diisi, konfirmasi harus sama
                if (passwordValue || passwordConfirmValue) {
                    if (passwordValue !== passwordConfirmValue) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Password Tidak Cocok!',
                            text: 'Password dan konfirmasi password harus sama.',
                            confirmButtonColor: '#0052CC'
                        });
                        return false;
                    }
                }
            });
        }
    });

    // SweetAlert2 Pop-up Handlers
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#0052CC',
            timer: 3000,
            timerProgressBar: true
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: "{{ session('error') }}",
            confirmButtonColor: '#0052CC'
        });
    @endif

    @if ($errors->any())
        Swal.fire({
            icon: 'warning',
            title: 'Perhatian!',
            text: "{{ $errors->first() }}",
            confirmButtonColor: '#0052CC'
        });
    @endif
</script>
@endpush
