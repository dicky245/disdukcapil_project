<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page_title ?? 'Dashboard Keagamaan - Disdukcapil Kabupaten Toba' }}</title>

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

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- SweetAlert Helper -->
    <script src="{{ asset('js/sweetalert-helper.js') }}"></script>

    <!-- SweetAlert2 Disdukcapil Notification System -->
    <script src="{{ asset('js/sweetalert-disdukcapil.js') }}"></script>

    <!-- Notifikasi Disdukcapil Helper -->
    <script src="{{ asset('js/notifikasi-disdukcapil.js') }}"></script>

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
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #0d9488;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #0f766e;
        }

        .sidebar {
            transition: all 0.3s ease;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar.collapsed .sidebar-text,
        .sidebar.collapsed .logo-text {
            display: none;
        }

        .sidebar-link {
            transition: all 0.2s ease;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background: #f0fdfa;
            color: #0d9488;
            border-left-color: #0d9488;
        }

        .sidebar-link.active {
            border-left: 3px solid #0d9488;
        }

        .main-content {
            transition: all 0.3s ease;
        }

        .main-content.expanded {
            margin-left: 80px;
        }

        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(13, 148, 136, 0.15);
        }

        .reveal {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease-out;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* SweetAlert Custom Styles - Konsisten & Profesional */
        .swal2-modal-popup {
            border-radius: 16px !important;
            padding: 24px !important;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3) !important;
        }

        /* Button Styles */
        .swal2-confirm-button {
            background: linear-gradient(135deg, #0052CC 0%, #003d99 100%) !important;
            border-radius: 12px !important;
            padding: 12px 24px !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 12px rgba(0, 82, 204, 0.3) !important;
        }

        .swal2-confirm-button:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 16px rgba(0, 82, 204, 0.4) !important;
        }

        .swal2-cancel-button {
            background: #64748b !important;
            border-radius: 12px !important;
            padding: 12px 24px !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            transition: all 0.3s ease !important;
        }

        .swal2-cancel-button:hover {
            background: #475569 !important;
            transform: translateY(-2px) !important;
        }

        .swal2-delete-button {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
            border-radius: 12px !important;
            padding: 12px 24px !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3) !important;
        }

        .swal2-delete-button:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 16px rgba(239, 68, 68, 0.4) !important;
        }

        .swal2-success-button {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%) !important;
            border-radius: 12px !important;
            padding: 12px 24px !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3) !important;
        }

        .swal2-success-button:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 16px rgba(34, 197, 94, 0.4) !important;
        }

        /* Toast Styles */
        .swal2-toast-success,
        .swal2-toast-error,
        .swal2-toast-info,
        .swal2-toast-warning {
            border-radius: 12px !important;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2) !important;
        }

        .swal2-toast-title {
            font-size: 14px !important;
            font-weight: 600 !important;
        }

        /* Loading Container - Perfect Center */
        .swal2-html-container {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
            padding: 20px !important;
        }

        /* Loading text styling */
        .swal2-html-container p {
            margin: 0 !important;
            padding: 0 !important;
            text-align: center !important;
        }

        /* Ensure popup is centered */
        .swal2-popup.swal2-show {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
        }

        .swal2-title {
            text-align: center !important;
        }

        /* Loading Icon Animation */
        .loading-icon {
            font-size: 48px !important;
            color: #0052CC !important;
            animation: pulse 1.5s ease-in-out infinite !important;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
                transform: scale(1);
            }
            50% {
                opacity: 0.5;
                transform: scale(1.1);
            }
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50">
    @include('components.keagamaan.sidebar')

    {{-- Main Content --}}
    <main class="main-content ml-64 min-h-screen flex flex-col">
        {{-- Header/Navbar --}}
        @include('components.keagamaan.navbar')

        {{-- Content --}}
        <div class="p-6 flex-1">
            {{-- Flash Messages --}}
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
                            <h3 class="text-sm font-semibold text-red-800 mb-2">
                                Oops! Terjadi Kesalahan
                            </h3>
                            <p class="text-sm text-red-700 mb-2">{{ session('error') }}</p>

                            @if(session('error_detail'))
                            <div class="bg-red-100 rounded-lg p-3 mb-2">
                                <p class="text-xs font-medium text-red-900 mb-1">
                                    <i class="fas fa-info-circle mr-1"></i>Detail Teknis:
                                </p>
                                <p class="text-xs text-red-800">{{ session('error_detail') }}</p>
                            </div>
                            @endif

                            @if(session('error_location'))
                            <p class="text-xs text-red-600 mb-2">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                <strong>Lokasi:</strong> {{ session('error_location') }}
                            </p>
                            @endif

                            @if(session('error_solution'))
                            <div class="bg-green-50 rounded-lg p-3 border border-green-200">
                                <p class="text-xs font-semibold text-green-900 mb-1">
                                    <i class="fas fa-lightbulb mr-1"></i>Cara Mengatasi:
                                </p>
                                <p class="text-xs text-green-800">{{ session('error_solution') }}</p>
                            </div>
                            @endif

                            @if(session('error_code'))
                            <p class="text-xs text-gray-500 mt-2">
                                Error Code: {{ session('error_code') }}
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            @yield('content')
        </div>

        {{-- Footer --}}
        @include('components.keagamaan.footer')
    </main>

    @stack('scripts')

    {{-- Auto-Logout System --}}
    @if(auth()->check())
        <script src="{{ asset('js/auto-logout.js') }}"></script>
    @endif

    <script>
        // SweetAlert Helper Functions - Konsisten & Profesional
        window.SwalHelper = {
            // Success Toast
            success: function(message) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    background: '#ffffff',
                    customClass: {
                        popup: 'swal2-toast-success',
                        title: 'swal2-toast-title'
                    },
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });
                Toast.fire({
                    icon: 'success',
                    iconColor: '#22c55e',
                    title: message
                });
            },

            // Error Toast
            error: function(message) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    background: '#ffffff',
                    customClass: {
                        popup: 'swal2-toast-error',
                        title: 'swal2-toast-title'
                    },
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });
                Toast.fire({
                    icon: 'error',
                    iconColor: '#ef4444',
                    title: message
                });
            },

            // Info Toast
            info: function(message) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    background: '#ffffff',
                    customClass: {
                        popup: 'swal2-toast-info',
                        title: 'swal2-toast-title'
                    },
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });
                Toast.fire({
                    icon: 'info',
                    iconColor: '#3b82f6',
                    title: message
                });
            },

            // Warning Toast
            warning: function(message) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3500,
                    timerProgressBar: true,
                    background: '#ffffff',
                    customClass: {
                        popup: 'swal2-toast-warning',
                        title: 'swal2-toast-title'
                    },
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });
                Toast.fire({
                    icon: 'warning',
                    iconColor: '#f59e0b',
                    title: message
                });
            },

            // Confirm Dialog - General Purpose
            confirm: function(title, text, callback) {
                Swal.fire({
                    title: title,
                    html: `
                        <div class="text-left">
                            <p class="text-gray-600 mb-3">${text}</p>
                        </div>
                    `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#0052CC',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: '<i class="fas fa-check mr-2"></i>Ya, Lanjutkan',
                    cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
                    reverseButtons: true,
                    customClass: {
                        popup: 'swal2-modal-popup',
                        confirmButton: 'swal2-confirm-button',
                        cancelButton: 'swal2-cancel-button'
                    }
                }).then((result) => {
                    if (result.isConfirmed && callback) {
                        callback();
                    }
                });
            },

            // Delete Confirm - Untuk hapus data
            deleteConfirm: function(title, text, callback) {
                Swal.fire({
                    title: title,
                    html: `
                        <div class="text-left">
                            <div class="flex items-center gap-3 mb-4 p-4 bg-red-50 rounded-lg border border-red-200">
                                <i class="fas fa-exclamation-triangle text-2xl text-red-500"></i>
                                <div>
                                    <p class="font-semibold text-red-800">Peringatan</p>
                                    <p class="text-sm text-red-600">Tindakan ini tidak dapat dibatalkan</p>
                                </div>
                            </div>
                            <p class="text-gray-600">${text}</p>
                        </div>
                    `,
                    icon: false,
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: '<i class="fas fa-trash mr-2"></i>Ya, Hapus',
                    cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
                    reverseButtons: true,
                    customClass: {
                        popup: 'swal2-modal-popup',
                        confirmButton: 'swal2-delete-button',
                        cancelButton: 'swal2-cancel-button'
                    }
                }).then((result) => {
                    if (result.isConfirmed && callback) {
                        callback();
                    }
                });
            },

            // Action Confirm - Untuk action lainnya (terima, tolak, verifikasi, dll)
            actionConfirm: function(options) {
                const defaults = {
                    title: 'Konfirmasi',
                    message: 'Apakah Anda yakin ingin melanjutkan?',
                    icon: 'question',
                    iconColor: '#0052CC',
                    confirmText: 'Ya, Lanjutkan',
                    confirmColor: '#0052CC',
                    onConfirm: null
                };

                const settings = Object.assign({}, defaults, options);

                Swal.fire({
                    title: settings.title,
                    html: `
                        <div class="text-center">
                            <div class="mb-4">
                                <i class="fas ${settings.icon} text-6xl" style="color: ${settings.iconColor}"></i>
                            </div>
                            <p class="text-gray-600 text-lg">${settings.message}</p>
                        </div>
                    `,
                    icon: false,
                    showCancelButton: true,
                    confirmButtonColor: settings.confirmColor,
                    cancelButtonColor: '#64748b',
                    confirmButtonText: `<i class="fas fa-check mr-2"></i>${settings.confirmText}`,
                    cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
                    reverseButtons: true,
                    customClass: {
                        popup: 'swal2-modal-popup',
                        confirmButton: 'swal2-confirm-button',
                        cancelButton: 'swal2-cancel-button'
                    }
                }).then((result) => {
                    if (result.isConfirmed && settings.onConfirm) {
                        settings.onConfirm();
                    }
                });
            },

            // Loading
            loading: function(message = 'Memuat...') {
                Swal.fire({
                    title: message,
                    html: `
                        <div class="loading-icon">
                            <i class="fas fa-circle-notch fa-spin"></i>
                        </div>
                        <p class="text-gray-600 mt-4">Mohon tunggu sebentar...</p>
                    `,
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'swal2-modal-popup',
                        htmlContainer: 'swal2-html-container'
                    }
                });
            },

            // Success Modal - Untuk feedback setelah action
            successModal: function(title, message, callback = null) {
                Swal.fire({
                    title: title,
                    html: `
                        <div class="text-center">
                            <div class="mb-4">
                                <div class="w-20 h-20 mx-auto bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-4xl text-green-500"></i>
                                </div>
                            </div>
                            <p class="text-gray-600 text-lg">${message}</p>
                        </div>
                    `,
                    icon: false,
                    confirmButtonColor: '#22c55e',
                    confirmButtonText: '<i class="fas fa-check mr-2"></i>OK',
                    customClass: {
                        popup: 'swal2-modal-popup',
                        confirmButton: 'swal2-success-button'
                    }
                }).then((result) => {
                    if (result.isConfirmed && callback) {
                        callback();
                    }
                });
            },

            // Custom Confirm - Dialog konfirmasi kustom dengan icon besar
            customConfirm: function(options = {}) {
                const defaults = {
                    title: 'Konfirmasi',
                    message: 'Apakah Anda yakin?',
                    subMessage: '',
                    iconClass: 'fas fa-question-circle',
                    iconColor: '#ef4444',
                    confirmText: 'Ya, Lanjutkan',
                    confirmColor: '#ef4444',
                    cancelText: 'Batal',
                    cancelColor: '#64748b',
                    onConfirm: null,
                    onCancel: null,
                    loadingTitle: 'Memproses',
                    loadingMessage: 'Mohon tunggu...',
                    showLoadingAfterConfirm: true,
                };

                const config = Object.assign({}, defaults, options);

                let htmlContent = `
                    <div class="text-center">
                        <div class="mb-4">
                            <i class="${config.iconClass} text-6xl" style="color: ${config.iconColor}"></i>
                        </div>
                        <p class="text-gray-600 text-lg mb-2">${config.message}</p>
                `;

                if (config.subMessage) {
                    htmlContent += `<p class="text-gray-500 text-sm">${config.subMessage}</p>`;
                }

                htmlContent += '</div>';

                Swal.fire({
                    title: config.title,
                    html: htmlContent,
                    icon: false,
                    showCancelButton: true,
                    confirmButtonColor: config.confirmColor,
                    cancelButtonColor: config.cancelColor,
                    confirmButtonText: `<i class="${config.iconClass} mr-2"></i>${config.confirmText}`,
                    cancelButtonText: '<i class="fas fa-times mr-2"></i>' + config.cancelText,
                    reverseButtons: true,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    keydownListenerCapture: true,
                    customClass: {
                        popup: 'swal2-modal-popup',
                        confirmButton: 'swal2-confirm-button',
                        cancelButton: 'swal2-cancel-button'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (config.showLoadingAfterConfirm) {
                            Swal.fire({
                                title: config.loadingTitle,
                                html: `
                                    <div class="loading-icon">
                                        <i class="fas fa-circle-notch fa-spin"></i>
                                    </div>
                                    <p class="text-gray-600 mt-4">${config.loadingMessage}</p>
                                `,
                                allowOutsideClick: false,
                                showConfirmButton: false,
                                customClass: {
                                    popup: 'swal2-modal-popup',
                                    htmlContainer: 'swal2-html-container'
                                }
                            });
                        }

                        if (config.onConfirm && typeof config.onConfirm === 'function') {
                            config.onConfirm();
                        }
                    } else {
                        if (config.onCancel && typeof config.onCancel === 'function') {
                            config.onCancel();
                        }
                    }
                });
            },

            // Helper: Konfirmasi Start/Mulai (Warna Hijau)
            confirmStart: function(title, message, subMessage, onConfirm, onCancel) {
                // Pause auto-logout monitoring
                if (window.pauseAutoLogoutReset) {
                    window.pauseAutoLogoutReset();
                }

                SwalHelper.customConfirm({
                    title: title,
                    message: message,
                    subMessage: subMessage,
                    iconClass: 'fas fa-play-circle',
                    iconColor: '#28A745',
                    confirmText: 'Ya, Mulai',
                    confirmColor: '#28A745',
                    cancelText: 'Batal',
                    cancelColor: '#64748b',
                    loadingTitle: 'Memproses',
                    loadingMessage: 'Sedang memproses permintaan...',
                    onConfirm: onConfirm,
                    onCancel: () => {
                        // Resume auto-logout monitoring
                        if (window.resumeAutoLogoutReset && onCancel) {
                            onCancel();
                        }
                        if (window.resumeAutoLogoutReset) {
                            window.resumeAutoLogoutReset();
                        }
                    }
                });
            },

            // Helper: Konfirmasi Delete/Hapus (Warna Merah)
            confirmDelete: function(title, message, subMessage, onConfirm, onCancel) {
                // Pause auto-logout monitoring
                if (window.pauseAutoLogoutReset) {
                    window.pauseAutoLogoutReset();
                }

                SwalHelper.customConfirm({
                    title: title,
                    message: message,
                    subMessage: subMessage,
                    iconClass: 'fas fa-trash',
                    iconColor: '#ef4444',
                    confirmText: 'Ya, Hapus',
                    confirmColor: '#ef4444',
                    cancelText: 'Batal',
                    cancelColor: '#64748b',
                    loadingTitle: 'Menghapus',
                    loadingMessage: 'Sedang menghapus data...',
                    onConfirm: onConfirm,
                    onCancel: () => {
                        // Resume auto-logout monitoring
                        if (window.resumeAutoLogoutReset && onCancel) {
                            onCancel();
                        }
                        if (window.resumeAutoLogoutReset) {
                            window.resumeAutoLogoutReset();
                        }
                    }
                });
            },

            // Helper: Konfirmasi Save/Simpan (Warna Hijau)
            confirmSave: function(title, message, subMessage, onConfirm, onCancel) {
                // Pause auto-logout monitoring
                if (window.pauseAutoLogoutReset) {
                    window.pauseAutoLogoutReset();
                }

                SwalHelper.customConfirm({
                    title: title,
                    message: message,
                    subMessage: subMessage,
                    iconClass: 'fas fa-save',
                    iconColor: '#22c55e',
                    confirmText: 'Ya, Simpan',
                    confirmColor: '#22c55e',
                    cancelText: 'Batal',
                    cancelColor: '#64748b',
                    loadingTitle: 'Menyimpan',
                    loadingMessage: 'Sedang menyimpan data...',
                    onConfirm: onConfirm,
                    onCancel: () => {
                        // Resume auto-logout monitoring
                        if (window.resumeAutoLogoutReset && onCancel) {
                            onCancel();
                        }
                        if (window.resumeAutoLogoutReset) {
                            window.resumeAutoLogoutReset();
                        }
                    }
                });
            },

            // Helper: Konfirmasi Update (Warna Biru)
            confirmUpdate: function(title, message, subMessage, onConfirm, onCancel) {
                // Pause auto-logout monitoring
                if (window.pauseAutoLogoutReset) {
                    window.pauseAutoLogoutReset();
                }

                SwalHelper.customConfirm({
                    title: title,
                    message: message,
                    subMessage: subMessage,
                    iconClass: 'fas fa-sync',
                    iconColor: '#0052CC',
                    confirmText: 'Ya, Update',
                    confirmColor: '#0052CC',
                    cancelText: 'Batal',
                    cancelColor: '#64748b',
                    loadingTitle: 'Memperbarui',
                    loadingMessage: 'Sedang memperbarui data...',
                    onConfirm: onConfirm,
                    onCancel: () => {
                        // Resume auto-logout monitoring
                        if (window.resumeAutoLogoutReset && onCancel) {
                            onCancel();
                        }
                        if (window.resumeAutoLogoutReset) {
                            window.resumeAutoLogoutReset();
                        }
                    }
                });
            },

            // Helper: Konfirmasi Logout (Warna Merah)
            confirmLogout: function(title, message, subMessage, onConfirm, onCancel) {
                // Pause auto-logout monitoring
                if (window.pauseAutoLogoutReset) {
                    window.pauseAutoLogoutReset();
                }

                SwalHelper.customConfirm({
                    title: title,
                    message: message,
                    subMessage: subMessage,
                    iconClass: 'fas fa-sign-out-alt',
                    iconColor: '#ef4444',
                    confirmText: 'Ya, Keluar',
                    confirmColor: '#ef4444',
                    cancelText: 'Batal',
                    cancelColor: '#64748b',
                    loadingTitle: 'Memproses Logout',
                    loadingMessage: 'Sedang mengakhiri session...',
                    onConfirm: onConfirm,
                    onCancel: () => {
                        // Resume auto-logout monitoring
                        if (window.resumeAutoLogoutReset && onCancel) {
                            onCancel();
                        }
                        if (window.resumeAutoLogoutReset) {
                            window.resumeAutoLogoutReset();
                        }
                    }
                });
            },

            // Helper: Notifikasi Sukses (Warna Hijau)
            notifySuccess: function(title, message, subMessage, callback) {
                SwalHelper.customConfirm({
                    title: title,
                    message: message,
                    subMessage: subMessage,
                    iconClass: 'fas fa-check-circle',
                    iconColor: '#22c55e',
                    confirmText: 'OK',
                    confirmColor: '#22c55e',
                    cancelText: 'Tutup',
                    cancelColor: '#64748b',
                    showLoadingAfterConfirm: false,
                    onConfirm: callback,
                    onCancel: callback
                });
            },

            // Helper: Notifikasi Error (Warna Merah)
            notifyError: function(title, message, subMessage, callback) {
                SwalHelper.customConfirm({
                    title: title,
                    message: message,
                    subMessage: subMessage,
                    iconClass: 'fas fa-times-circle',
                    iconColor: '#ef4444',
                    confirmText: 'OK',
                    confirmColor: '#ef4444',
                    cancelText: 'Tutup',
                    cancelColor: '#64748b',
                    showLoadingAfterConfirm: false,
                    onConfirm: callback,
                    onCancel: callback
                });
            },

            // Helper: Notifikasi Warning (Warna Kuning)
            notifyWarning: function(title, message, subMessage, callback) {
                SwalHelper.customConfirm({
                    title: title,
                    message: message,
                    subMessage: subMessage,
                    iconClass: 'fas fa-exclamation-triangle',
                    iconColor: '#eab308',
                    confirmText: 'OK',
                    confirmColor: '#eab308',
                    cancelText: 'Tutup',
                    cancelColor: '#64748b',
                    showLoadingAfterConfirm: false,
                    onConfirm: callback,
                    onCancel: callback
                });
            },

            // Modal Success
            modalSuccess: function(title, message, callback = null) {
                Swal.fire({
                    title: title,
                    html: `
                        <div class="text-center">
                            <div class="mb-4">
                                <div class="w-20 h-20 mx-auto bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-4xl text-green-500"></i>
                                </div>
                            </div>
                            <p class="text-gray-600 text-lg">${message}</p>
                        </div>
                    `,
                    icon: false,
                    confirmButtonColor: '#22c55e',
                    confirmButtonText: '<i class="fas fa-check mr-2"></i>OK',
                    customClass: {
                        popup: 'swal2-modal-popup',
                        confirmButton: 'swal2-confirm-button'
                    }
                }).then((result) => {
                    if (result.isConfirmed && callback) {
                        callback();
                    }
                });
            },

            // Modal Error
            modalError: function(title, message, callback = null) {
                Swal.fire({
                    title: title,
                    html: `
                        <div class="text-center">
                            <div class="mb-4">
                                <div class="w-20 h-20 mx-auto bg-red-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-times text-4xl text-red-500"></i>
                                </div>
                            </div>
                            <p class="text-gray-600 text-lg">${message}</p>
                        </div>
                    `,
                    icon: false,
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: '<i class="fas fa-times mr-2"></i>OK',
                    customClass: {
                        popup: 'swal2-modal-popup',
                        confirmButton: 'swal2-confirm-button'
                    }
                }).then((result) => {
                    if (result.isConfirmed && callback) {
                        callback();
                    }
                });
            },

            // Modal Warning
            modalWarning: function(title, message, callback = null) {
                Swal.fire({
                    title: title,
                    html: `
                        <div class="text-center">
                            <div class="mb-4">
                                <div class="w-20 h-20 mx-auto bg-yellow-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-exclamation-triangle text-4xl text-yellow-500"></i>
                                </div>
                            </div>
                            <p class="text-gray-600 text-lg">${message}</p>
                        </div>
                    `,
                    icon: false,
                    confirmButtonColor: '#eab308',
                    confirmButtonText: '<i class="fas fa-exclamation-triangle mr-2"></i>OK',
                    customClass: {
                        popup: 'swal2-modal-popup',
                        confirmButton: 'swal2-confirm-button'
                    }
                }).then((result) => {
                    if (result.isConfirmed && callback) {
                        callback();
                    }
                });
            },

            // Close Loading
            close: function() {
                Swal.close();
            }
        };

        // Show SweetAlert for session messages on page load
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                SwalHelper.success('{{ session('success') }}');
            @endif

            @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                html: `
                    <div class="text-left">
                        <p class="text-gray-700 mb-3">{{ session('error') }}</p>

                        @if(session('error_detail'))
                        <div class="bg-red-50 rounded-lg p-3 mb-3 border border-red-200">
                            <p class="text-xs font-semibold text-red-900 mb-1">
                                <i class="fas fa-info-circle mr-1"></i>Detail Teknis:
                            </p>
                            <p class="text-xs text-red-800">{{ session('error_detail') }}</p>
                        </div>
                        @endif

                        @if(session('error_location'))
                        <p class="text-xs text-red-600 mb-2">
                            <i class="fas fa-map-marker-alt mr-1"></i>
                            <strong>Lokasi:</strong> {{ session('error_location') }}
                        </p>
                        @endif

                        @if(session('error_solution'))
                        <div class="bg-green-50 rounded-lg p-3 border border-green-200">
                            <p class="text-xs font-semibold text-green-900 mb-1">
                                <i class="fas fa-lightbulb mr-1"></i>Cara Mengatasi:
                            </p>
                            <p class="text-xs text-green-800">{{ session('error_solution') }}</p>
                        </div>
                        @endif

                        @if(session('error_code'))
                        <p class="text-xs text-gray-500 mt-2">
                            Error Code: {{ session('error_code') }}
                        </p>
                        @endif
                    </div>
                `,
                confirmButtonText: 'OK',
                confirmButtonColor: '#dc2626',
                allowOutsideClick: false
            });
            @endif

            @if(session('info'))
                SwalHelper.info('{{ session('info') }}');
            @endif

            @if(session('warning'))
                SwalHelper.warning('{{ session('warning') }}');
            @endif
        });
    </script>
</body>
</html>
