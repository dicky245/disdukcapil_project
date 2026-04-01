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

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

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
            background: #0052CC;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #003d99;
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
            background: rgba(59, 130, 246, 0.1);
            color: #0052CC;
        }

        .sidebar-link.active {
            border-left: 3px solid #0052CC;
        }

        /* Dropdown */
        .dropdown-menu {
            display: none;
            padding-left: 2rem;
        }

        .dropdown-menu.active {
            display: block;
        }

        .dropdown-toggle {
            justify-content: space-between;
        }

        .dropdown-toggle .fa-chevron-down {
            transition: transform 0.3s ease;
        }

        .dropdown-toggle.active .fa-chevron-down {
            transform: rotate(180deg);
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
            box-shadow: 0 12px 24px rgba(0, 82, 204, 0.15);
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
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50">
    @include('components.admin.sidebar')

    {{-- Main Content --}}
    <main class="main-content ml-64 min-h-screen flex flex-col">
        {{-- Header --}}
        @include('components.admin.navbar')

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
        @include('components.admin.footer')
    </main>

    @stack('scripts')

    {{-- Auto-Logout System --}}
    @if(auth()->check())
        <script src="{{ asset('js/auto-logout.js') }}"></script>
    @endif

    <script>
        // SweetAlert Helper Functions
        window.SwalHelper = {
            // Success Toast
            success: function(message) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });
                Toast.fire({
                    icon: 'success',
                    title: message
                });
            },

            // Error Toast
            error: function(message) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });
                Toast.fire({
                    icon: 'error',
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
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });
                Toast.fire({
                    icon: 'info',
                    title: message
                });
            },

            // Warning Toast
            warning: function(message) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });
                Toast.fire({
                    icon: 'warning',
                    title: message
                });
            },

            // Confirm Dialog
            confirm: function(title, text, callback) {
                Swal.fire({
                    title: title,
                    text: text,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#0052CC',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, lanjutkan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed && callback) {
                        callback();
                    }
                });
            },

            // Delete Confirm
            deleteConfirm: function(title, text, callback) {
                Swal.fire({
                    title: title,
                    text: text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed && callback) {
                        callback();
                    }
                });
            },

            // Loading
            loading: function(message = 'Memuat...') {
                Swal.fire({
                    title: message,
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
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
