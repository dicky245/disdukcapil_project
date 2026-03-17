<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page_title ?? 'Disdukcapil Kabupaten Toba' }}</title>
    <meta name="description" content="{{ $page_description ?? 'Layanan Kependudukan dan Pencatatan Sipil Kabupaten Toba' }}">

    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo_toba.jpeg') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        blue: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#0052CC',
                            700: '#003d99',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        },
                        teal: {
                            500: '#00B8D9',
                            600: '#0097b8',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
            scroll-behavior: smooth;
        }

        /* Custom Scrollbar */
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

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease-out;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Skeleton Loading */
        .skeleton {
            background: linear-gradient(90deg, #e5e7eb 25%, #f3f4f6 50%, #e5e7eb 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
            border-radius: 8px;
        }

        @keyframes shimmer {
            0% {
                background-position: 200% 0;
            }
            100% {
                background-position: -200% 0;
            }
        }

        /* Page Loading with Animation */
        .page-loading {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, #0052CC 0%, #0066FF 50%, #0052CC 100%);
            background-size: 400% 400%;
            animation: gradientBG 8s ease infinite;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .page-loading.hidden {
            display: none;
        }

        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        /* Logo Animation */
        .loading-logo {
            width: 120px;
            height: 120px;
            position: relative;
            animation: logoFloat 3s ease-in-out infinite;
        }

        .loading-logo::before {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: pulseRing 2s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
        }

        .loading-logo::after {
            content: '';
            position: absolute;
            top: -20px;
            left: -20px;
            right: -20px;
            bottom: -20px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            animation: pulseRing 2s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
            animation-delay: 0.5s;
        }

        @keyframes logoFloat {
            0%, 100% {
                transform: translateY(0px) scale(1);
            }
            50% {
                transform: translateY(-20px) scale(1.05);
            }
        }

        @keyframes pulseRing {
            0% {
                transform: scale(0.8);
                opacity: 1;
            }
            100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }

        /* Loading Spinner */
        .loading-spinner {
            width: 60px;
            height: 60px;
            border: 4px solid rgba(255, 255, 255, 0.2);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-top: 20px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Loading Text */
        .loading-text {
            color: white;
            font-size: 1.25rem;
            font-weight: 600;
            margin-top: 24px;
            animation: fadeInUp 0.8s ease-out;
        }

        .loading-subtext {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.875rem;
            margin-top: 8px;
            animation: fadeInUp 0.8s ease-out 0.2s backwards;
        }

        /* Loading Dots */
        .loading-dots {
            display: flex;
            gap: 8px;
            margin-top: 16px;
        }

        .loading-dots span {
            width: 10px;
            height: 10px;
            background: white;
            border-radius: 50%;
            animation: bounceDots 1.4s infinite ease-in-out both;
        }

        .loading-dots span:nth-child(1) {
            animation-delay: -0.32s;
        }

        .loading-dots span:nth-child(2) {
            animation-delay: -0.16s;
        }

        @keyframes bounceDots {
            0%, 80%, 100% {
                transform: scale(0);
                opacity: 0.5;
            }
            40% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Tabs */
        .tabs::-webkit-scrollbar {
            display: none;
        }
        .tabs {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .tab-btn.active {
            background-color: #0052CC;
            color: white;
        }

        .tab-panel {
            display: none;
        }

        .tab-panel.active {
            display: block;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50">

    {{-- Navbar --}}
    @include('components.user.navbar')

    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="fixed top-20 right-4 z-50 max-w-md animate-fade-in-up">
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-lg">
                <div class="flex items-center gap-2">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        </div>
    @endif

    @if (session('info'))
        <div class="fixed top-20 right-4 z-50 max-w-md animate-fade-in-up">
            <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-xl shadow-lg">
                <div class="flex items-center gap-2">
                    <i class="fas fa-info-circle"></i>
                    <span>{{ session('info') }}</span>
                </div>
            </div>
        </div>
    @endif

    @if (session('warning'))
        <div class="fixed top-20 right-4 z-50 max-w-md animate-fade-in-up">
            <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-xl shadow-lg">
                <div class="flex items-center gap-2">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>{{ session('warning') }}</span>
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="fixed top-20 right-4 z-50 max-w-md animate-fade-in-up">
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl shadow-lg">
                <div class="flex items-center gap-2">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        </div>
    @endif

    {{-- Content --}}
    @yield('content')

    {{-- Footer --}}
    @include('components.user.footer')

    {{-- Scripts --}}
    @stack('scripts')

    <script>
        // Scroll Reveal Animation
        function reveal() {
            const reveals = document.querySelectorAll('.reveal');
            reveals.forEach(element => {
                const windowHeight = window.innerHeight;
                const elementTop = element.getBoundingClientRect().top;
                const elementVisible = 150;

                if (elementTop < windowHeight - elementVisible) {
                    element.classList.add('active');
                }
            });
        }

        window.addEventListener('scroll', reveal);
        reveal(); // Initial call

        // Header Scroll Effect
        let lastScroll = 0;
        const header = document.getElementById('mainHeader');

        if (header) {
            window.addEventListener('scroll', () => {
                const currentScroll = window.pageYOffset;

                if (currentScroll > 50) {
                    header.classList.add('shadow-lg');
                } else {
                    header.classList.remove('shadow-lg');
                }

                lastScroll = currentScroll;
            });
        }

        // Page Loading Animation
        const pageLoading = document.getElementById('pageLoading');
        if (pageLoading) {
            window.addEventListener('load', function() {
                setTimeout(function() {
                    pageLoading.style.opacity = '0';
                    pageLoading.style.transition = 'opacity 0.5s ease';
                    setTimeout(function() {
                        pageLoading.classList.add('hidden');
                    }, 500);
                }, 800);
            });
        }

        // Show loading on page navigation
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('a:not([target="_blank"])');
            links.forEach(function(link) {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    if (href && !href.startsWith('#') && !href.startsWith('javascript:') && !href.startsWith('mailto:') && !href.startsWith('tel:')) {
                        if (pageLoading) {
                            e.preventDefault();
                            pageLoading.classList.remove('hidden');
                            pageLoading.style.opacity = '1';
                            setTimeout(function() {
                                window.location.href = href;
                            }, 300);
                        }
                    }
                });
            });
        });

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
                    cancelButtonText: 'Batal',
                    showClass: {
                        popup: 'swal2-show',
                        backdrop: 'swal2-backdrop-show',
                        icon: 'swal2-icon-show'
                    },
                    hideClass: {
                        popup: 'swal2-hide',
                        backdrop: 'swal2-backdrop-hide',
                        icon: 'swal2-icon-hide'
                    }
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
                    cancelButtonText: 'Batal',
                    showClass: {
                        popup: 'swal2-show',
                        backdrop: 'swal2-backdrop-show',
                        icon: 'swal2-icon-show'
                    },
                    hideClass: {
                        popup: 'swal2-hide',
                        backdrop: 'swal2-backdrop-hide',
                        icon: 'swal2-icon-hide'
                    }
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
                    html: '<div class="swal2-loader"></div>',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
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
    </script>
</body>
</html>
