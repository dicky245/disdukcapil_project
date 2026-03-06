<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page_title ?? 'Disdukcapil Kabupaten Toba' }}</title>
    <meta name="description" content="{{ $page_description ?? 'Layanan Kependudukan dan Pencatatan Sipil Kabupaten Toba' }}">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

        .page-loading {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: #f9fafb;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .page-loading.hidden {
            display: none;
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
    </script>
</body>
</html>
