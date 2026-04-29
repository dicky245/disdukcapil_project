<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page_title ?? 'Admin Dashboard - Disdukcapil Kabupaten Toba' }}</title>

    <!-- User Authenticated Meta Tag -->
    <meta name="user-authenticated" content="{{ auth()->check() ? 'true' : 'false' }}">

    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo_toba.jpeg') }}">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- SweetAlert2 — hanya dimuat SEKALI di sini -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- SweetAlert2 Disdukcapil Notification System -->
    <script src="{{ asset('js/sweetalert-disdukcapil.js') }}"></script>

    <!-- Notifikasi Disdukcapil Helper -->
    <script src="{{ asset('js/notifikasi-disdukcapil.js') }}"></script>

    <!-- SweetAlert Global Fix untuk Admin -->
    <script src="{{ asset('js/admin-sweetalert-fix.js') }}"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #0052CC; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #003d99; }

        .sidebar { transition: all 0.3s ease; }
        .sidebar.collapsed { width: 80px; }
        .sidebar.collapsed .sidebar-text,
        .sidebar.collapsed .logo-text { display: none; }

        .sidebar-link { transition: all 0.2s ease; }
        .sidebar-link:hover,
        .sidebar-link.active { background: rgba(59, 130, 246, 0.1); color: #0052CC; }
        .sidebar-link.active { border-left: 3px solid #0052CC; }

        .dropdown-menu { display: none; padding-left: 2rem; }
        .dropdown-menu.active { display: block; }
        .dropdown-toggle { justify-content: space-between; }
        .dropdown-toggle .fa-chevron-down { transition: transform 0.3s ease; }
        .dropdown-toggle.active .fa-chevron-down { transform: rotate(180deg); }

        .main-content { transition: all 0.3s ease; }
        .main-content.expanded { margin-left: 80px; }

        .stat-card { transition: all 0.3s ease; }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 82, 204, 0.15);
        }

        .reveal { opacity: 0; transform: translateY(20px); transition: all 0.6s ease-out; }
        .reveal.active { opacity: 1; transform: translateY(0); }

        /* ── SweetAlert2 custom styles ── */
        .swal2-popup.swal2-modal {
            border-radius: 16px !important;
            padding: 24px !important;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3) !important;
        }

        .swal2-confirm.swal-btn-primary {
            background: linear-gradient(135deg, #0052CC 0%, #003d99 100%) !important;
            border-radius: 12px !important;
            padding: 12px 24px !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            box-shadow: 0 4px 12px rgba(0, 82, 204, 0.3) !important;
            transition: all 0.3s ease !important;
        }
        .swal2-confirm.swal-btn-primary:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 16px rgba(0, 82, 204, 0.4) !important;
        }

        .swal2-cancel.swal-btn-cancel {
            background: #64748b !important;
            border-radius: 12px !important;
            padding: 12px 24px !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            transition: all 0.3s ease !important;
        }
        .swal2-cancel.swal-btn-cancel:hover {
            background: #475569 !important;
            transform: translateY(-2px) !important;
        }

        .swal2-confirm.swal-btn-delete {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
            border-radius: 12px !important;
            padding: 12px 24px !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3) !important;
            transition: all 0.3s ease !important;
        }
        .swal2-confirm.swal-btn-delete:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 16px rgba(239, 68, 68, 0.4) !important;
        }

        .swal2-confirm.swal-btn-success {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%) !important;
            border-radius: 12px !important;
            padding: 12px 24px !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3) !important;
            transition: all 0.3s ease !important;
        }
        .swal2-confirm.swal-btn-success:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 16px rgba(34, 197, 94, 0.4) !important;
        }

        .swal2-toast { border-radius: 12px !important; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2) !important; }
        .swal2-toast .swal2-title { font-size: 14px !important; font-weight: 600 !important; }

        .swal2-html-container {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
            padding: 20px !important;
        }
        .swal2-html-container p { margin: 0 !important; padding: 0 !important; text-align: center !important; }
        .swal2-popup.swal2-show { display: flex !important; flex-direction: column !important; align-items: center !important; }
        .swal2-title { text-align: center !important; }

        .loading-icon { font-size: 48px !important; color: #0052CC !important; animation: pulse 1.5s ease-in-out infinite !important; }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.1); }
        }
    </style>

    @stack('styles')

    {{-- SweetAlert Global Styles untuk Admin --}}
    @include('admin.partials.sweetalert-styles')
</head>
<body class="bg-gray-50">
    @include('components.admin.sidebar')

    <main class="main-content ml-64 min-h-screen flex flex-col">
        @include('components.admin.navbar')

        <div class="p-6 flex-1">
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if (session('info'))
                <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-xl mb-6">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-info-circle"></i>
                        <span>{{ session('info') }}</span>
                    </div>
                </div>
            @endif

            @if (session('warning'))
                <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-xl mb-6">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>{{ session('warning') }}</span>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-xl mb-6 shadow-md">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-semibold text-red-800 mb-2">Oops! Terjadi Kesalahan</h3>
                            <p class="text-sm text-red-700 mb-2">{{ session('error') }}</p>
                            @if(session('error_detail'))
                            <div class="bg-red-100 rounded-lg p-3 mb-2">
                                <p class="text-xs font-medium text-red-900 mb-1"><i class="fas fa-info-circle mr-1"></i>Detail Teknis:</p>
                                <p class="text-xs text-red-800">{{ session('error_detail') }}</p>
                            </div>
                            @endif
                            @if(session('error_location'))
                            <p class="text-xs text-red-600 mb-2"><i class="fas fa-map-marker-alt mr-1"></i><strong>Lokasi:</strong> {{ session('error_location') }}</p>
                            @endif
                            @if(session('error_solution'))
                            <div class="bg-green-50 rounded-lg p-3 border border-green-200">
                                <p class="text-xs font-semibold text-green-900 mb-1"><i class="fas fa-lightbulb mr-1"></i>Cara Mengatasi:</p>
                                <p class="text-xs text-green-800">{{ session('error_solution') }}</p>
                            </div>
                            @endif
                            @if(session('error_code'))
                            <p class="text-xs text-gray-500 mt-2">Error Code: {{ session('error_code') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            @yield('content')
        </div>

        @include('components.admin.footer')
    </main>

    @if(auth()->check())
        <script src="{{ asset('js/auto-logout.js') }}"></script>
    @endif

    <script>
    if (typeof window.SwalHelper === 'undefined') {
        window.SwalHelper = {

            _toast: function(icon, iconColor, timerMs, message, customClass) {
                Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: timerMs,
                    timerProgressBar: true,
                    background: '#ffffff',
                    customClass: { popup: customClass, title: 'swal2-toast-title' },
                    didOpen: function(toast) {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                }).fire({ icon: icon, iconColor: iconColor, title: message });
            },

            success: function(message) {
                this._toast('success', '#22c55e', 3000, message, 'swal2-toast');
            },

            error: function(message) {
                this._toast('error', '#ef4444', 4000, message, 'swal2-toast');
            },

            info: function(message) {
                this._toast('info', '#3b82f6', 3000, message, 'swal2-toast');
            },

            warning: function(message) {
                this._toast('warning', '#f59e0b', 3500, message, 'swal2-toast');
            },

            confirm: function(title, text, callback) {
                Swal.fire({
                    title: title,
                    html: '<p class="text-gray-600">' + text + '</p>',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: '<i class="fas fa-check mr-2"></i>Ya, Lanjutkan',
                    cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
                    reverseButtons: true,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    customClass: {
                        popup: 'swal2-popup swal2-modal',
                        confirmButton: 'swal-btn-primary',
                        cancelButton: 'swal-btn-cancel'
                    }
                }).then(function(result) {
                    if (result.isConfirmed && callback) callback();
                });
            },

            deleteConfirm: function(title, text, callback) {
                Swal.fire({
                    title: title,
                    html: '<div class="flex items-center gap-3 mb-4 p-4 bg-red-50 rounded-lg border border-red-200">'
                        + '<i class="fas fa-exclamation-triangle text-2xl text-red-500"></i>'
                        + '<div><p class="font-semibold text-red-800">Peringatan</p>'
                        + '<p class="text-sm text-red-600">Tindakan ini tidak dapat dibatalkan</p></div></div>'
                        + '<p class="text-gray-600">' + text + '</p>',
                    icon: false,
                    showCancelButton: true,
                    confirmButtonText: '<i class="fas fa-trash mr-2"></i>Ya, Hapus',
                    cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
                    reverseButtons: true,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    customClass: {
                        popup: 'swal2-popup swal2-modal',
                        confirmButton: 'swal-btn-delete',
                        cancelButton: 'swal-btn-cancel'
                    }
                }).then(function(result) {
                    if (result.isConfirmed && callback) callback();
                });
            },

            customConfirm: function(options) {
                var defaults = {
                    title: 'Konfirmasi',
                    message: 'Apakah Anda yakin ingin melanjutkan?',
                    subMessage: '',
                    iconClass: 'fas fa-question-circle',
                    iconColor: '#0052CC',
                    confirmText: 'Ya, Lanjutkan',
                    confirmColor: '#0052CC',
                    cancelText: 'Batal',
                    cancelColor: '#64748b',
                    reverseButtons: true,
                    onConfirm: null,
                    onCancel: null,
                    loadingTitle: 'Memproses',
                    loadingMessage: 'Mohon tunggu...',
                    showLoadingAfterConfirm: true
                };
                var cfg = Object.assign({}, defaults, options);

                var html = '<div class="text-center">'
                    + '<div class="mb-4"><i class="' + cfg.iconClass + ' text-6xl" style="color:' + cfg.iconColor + '"></i></div>'
                    + '<p class="text-gray-600 text-lg mb-2">' + cfg.message + '</p>';
                if (cfg.subMessage) html += '<p class="text-gray-500 text-sm">' + cfg.subMessage + '</p>';
                html += '</div>';

                Swal.fire({
                    title: cfg.title,
                    html: html,
                    icon: false,
                    showCancelButton: true,
                    confirmButtonText: '<i class="' + cfg.iconClass + ' mr-2"></i>' + cfg.confirmText,
                    cancelButtonText: '<i class="fas fa-times mr-2"></i>' + cfg.cancelText,
                    reverseButtons: cfg.reverseButtons,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    customClass: {
                        popup: 'swal2-popup swal2-modal',
                        confirmButton: 'swal-btn-primary',
                        cancelButton: 'swal-btn-cancel'
                    }
                }).then(function(result) {
                    if (result.isConfirmed) {
                        if (cfg.showLoadingAfterConfirm) {
                            Swal.fire({
                                title: cfg.loadingTitle,
                                html: '<div class="loading-icon"><i class="fas fa-circle-notch fa-spin"></i></div>'
                                    + '<p class="text-gray-600 mt-4">' + cfg.loadingMessage + '</p>',
                                allowOutsideClick: false,
                                showConfirmButton: false,
                                customClass: { popup: 'swal2-popup swal2-modal', htmlContainer: 'swal2-html-container' }
                            });
                        }
                        if (typeof cfg.onConfirm === 'function') cfg.onConfirm();
                    } else {
                        if (typeof cfg.onCancel === 'function') cfg.onCancel();
                    }
                });
            },

            _pauseResume: function(pause) {
                if (pause && window.pauseAutoLogoutReset) window.pauseAutoLogoutReset();
                if (!pause && window.resumeAutoLogoutReset) window.resumeAutoLogoutReset();
            },

            confirmStart: function(title, message, subMessage, onConfirm, onCancel) {
                this._pauseResume(true);
                var self = this;
                this.customConfirm({
                    title: title, message: message, subMessage: subMessage,
                    iconClass: 'fas fa-play-circle', iconColor: '#28A745',
                    confirmText: 'Ya, Mulai', confirmColor: '#28A745',
                    loadingTitle: 'Memproses', loadingMessage: 'Sedang memproses permintaan...',
                    onConfirm: onConfirm,
                    onCancel: function() { self._pauseResume(false); if (onCancel) onCancel(); }
                });
            },

            confirmDelete: function(title, message, subMessage, onConfirm, onCancel) {
                this._pauseResume(true);
                var self = this;
                this.customConfirm({
                    title: title, message: message, subMessage: subMessage,
                    iconClass: 'fas fa-trash', iconColor: '#ef4444',
                    confirmText: 'Ya, Hapus', confirmColor: '#ef4444',
                    loadingTitle: 'Menghapus', loadingMessage: 'Sedang menghapus data...',
                    onConfirm: onConfirm,
                    onCancel: function() { self._pauseResume(false); if (onCancel) onCancel(); }
                });
            },

            confirmSave: function(title, message, subMessage, onConfirm, onCancel) {
                this._pauseResume(true);
                var self = this;
                this.customConfirm({
                    title: title, message: message, subMessage: subMessage,
                    iconClass: 'fas fa-save', iconColor: '#22c55e',
                    confirmText: 'Ya, Simpan', confirmColor: '#22c55e',
                    loadingTitle: 'Menyimpan', loadingMessage: 'Sedang menyimpan data...',
                    onConfirm: onConfirm,
                    onCancel: function() { self._pauseResume(false); if (onCancel) onCancel(); }
                });
            },

            confirmUpdate: function(title, message, subMessage, onConfirm, onCancel) {
                this._pauseResume(true);
                var self = this;
                this.customConfirm({
                    title: title, message: message, subMessage: subMessage,
                    iconClass: 'fas fa-sync', iconColor: '#0052CC',
                    confirmText: 'Ya, Update', confirmColor: '#0052CC',
                    loadingTitle: 'Memperbarui', loadingMessage: 'Sedang memperbarui data...',
                    onConfirm: onConfirm,
                    onCancel: function() { self._pauseResume(false); if (onCancel) onCancel(); }
                });
            },

            confirmLogout: function(title, message, subMessage, onConfirm, onCancel) {
                this._pauseResume(true);
                var self = this;
                this.customConfirm({
                    title: title, message: message, subMessage: subMessage,
                    iconClass: 'fas fa-sign-out-alt', iconColor: '#ef4444',
                    confirmText: 'Ya, Keluar', confirmColor: '#ef4444',
                    loadingTitle: 'Memproses Logout', loadingMessage: 'Sedang mengakhiri session...',
                    onConfirm: onConfirm,
                    onCancel: function() { self._pauseResume(false); if (onCancel) onCancel(); }
                });
            },

            notifySuccess: function(title, message, subMessage, callback) {
                this.customConfirm({
                    title: title, message: message, subMessage: subMessage,
                    iconClass: 'fas fa-check-circle', iconColor: '#22c55e',
                    confirmText: 'OK', confirmColor: '#22c55e',
                    cancelText: 'Tutup', showLoadingAfterConfirm: false,
                    onConfirm: callback, onCancel: callback
                });
            },

            notifyError: function(title, message, subMessage, callback) {
                this.customConfirm({
                    title: title, message: message, subMessage: subMessage,
                    iconClass: 'fas fa-times-circle', iconColor: '#ef4444',
                    confirmText: 'OK', confirmColor: '#ef4444',
                    cancelText: 'Tutup', showLoadingAfterConfirm: false,
                    onConfirm: callback, onCancel: callback
                });
            },

            notifyWarning: function(title, message, subMessage, callback) {
                this.customConfirm({
                    title: title, message: message, subMessage: subMessage,
                    iconClass: 'fas fa-exclamation-triangle', iconColor: '#eab308',
                    confirmText: 'OK', confirmColor: '#eab308',
                    cancelText: 'Tutup', showLoadingAfterConfirm: false,
                    onConfirm: callback, onCancel: callback
                });
            },

            _modal: function(bgColor, iconClass, iconColor, btnClass, title, message, callback) {
                Swal.fire({
                    title: title,
                    html: '<div class="text-center">'
                        + '<div class="mb-4"><div class="w-20 h-20 mx-auto ' + bgColor + ' rounded-full flex items-center justify-center">'
                        + '<i class="' + iconClass + ' text-4xl ' + iconColor + '"></i></div></div>'
                        + '<p class="text-gray-600 text-lg">' + message + '</p></div>',
                    icon: false,
                    confirmButtonText: '<i class="fas fa-check mr-2"></i>OK',
                    customClass: {
                        popup: 'swal2-popup swal2-modal',
                        confirmButton: btnClass
                    }
                }).then(function(result) {
                    if (result.isConfirmed && callback) callback();
                });
            },

            modalSuccess: function(title, message, callback) {
                this._modal('bg-green-100', 'fas fa-check', 'text-green-500', 'swal-btn-success', title, message, callback);
            },

            modalError: function(title, message, callback) {
                this._modal('bg-red-100', 'fas fa-times', 'text-red-500', 'swal-btn-delete', title, message, callback);
            },

            modalWarning: function(title, message, callback) {
                this._modal('bg-yellow-100', 'fas fa-exclamation-triangle', 'text-yellow-500', 'swal-btn-primary', title, message, callback);
            },
            loading: function(message) {
                Swal.fire({
                    title: message || 'Memuat...',
                    html: '<div class="loading-icon"><i class="fas fa-circle-notch fa-spin"></i></div>'
                        + '<p class="text-gray-600 mt-4">Mohon tunggu sebentar...</p>',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    customClass: { popup: 'swal2-popup swal2-modal', htmlContainer: 'swal2-html-container' }
                });
            },

            close: function() { Swal.close(); },

            successModal: function(title, message, callback) { this.modalSuccess(title, message, callback); },
            actionConfirm: function(options) { this.customConfirm(options); }
        };
    }
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            SwalHelper.success(@json(session('success')));
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                html: '<div class="text-left"><p class="text-gray-700 mb-3">{{ e(session("error")) }}</p>'
                    + '@if(session("error_detail"))<div class="bg-red-50 rounded-lg p-3 mb-3 border border-red-200"><p class="text-xs font-semibold text-red-900 mb-1"><i class=\"fas fa-info-circle mr-1\"></i>Detail Teknis:</p><p class="text-xs text-red-800">{{ e(session("error_detail")) }}</p></div>@endif'
                    + '@if(session("error_solution"))<div class="bg-green-50 rounded-lg p-3 border border-green-200"><p class="text-xs font-semibold text-green-900 mb-1"><i class=\"fas fa-lightbulb mr-1\"></i>Cara Mengatasi:</p><p class="text-xs text-green-800">{{ e(session("error_solution")) }}</p></div>@endif'
                    + '</div>',
                confirmButtonText: 'OK',
                confirmButtonColor: '#dc2626',
                allowOutsideClick: false
            });
        @endif

        @if(session('info'))
            SwalHelper.info(@json(session('info')));
        @endif

        @if(session('warning'))
            SwalHelper.warning(@json(session('warning')));
        @endif
    });
    </script>

    {{-- @stack dipanggil SETELAH SwalHelper didefinisikan --}}
    @stack('scripts')

</body>
</html>