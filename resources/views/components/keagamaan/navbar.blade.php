{{-- Keagamaan Header --}}
<header class="bg-white border-b border-gray-200 sticky top-0 z-40">
    <div class="flex items-center justify-between px-6 py-4">
        {{-- Left --}}
        <div class="flex items-center gap-4">
            <button id="sidebarToggle" class="p-2 hover:bg-gray-100 rounded-lg transition">
                <i class="fas fa-bars text-gray-600"></i>
            </button>
            <div>
                <h1 class="text-xl font-bold text-gray-800">{{ $page_title ?? 'Dashboard Keagamaan' }}</h1>
                <p class="text-sm text-gray-500">Selamat datang kembali, {{ auth()->user()->name }}</p>
            </div>
        </div>

        {{-- Right --}}
        <div class="flex items-center gap-4">
            {{-- Notifications --}}
            <button class="relative p-2 hover:bg-gray-100 rounded-lg transition">
                <i class="fas fa-bell text-gray-600"></i>
                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>

            {{-- Profile --}}
            <div class="flex items-center gap-3 pl-4 border-l border-gray-200">
                <div class="w-10 h-10 bg-teal-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-teal-600"></i>
                </div>
                <div class="hidden md:block">
                    <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500">Petugas Keagamaan</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" id="logoutFormNavbar" class="inline">
                    @csrf
                    <button type="button" onclick="handleKeagamaanNavbarLogout(event)"
                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

<script>
    // Logout Handler - SweetAlert Confirmation untuk Navbar
    function handleKeagamaanNavbarLogout(event) {
        // Mencegah event bubbling
        event.preventDefault();
        event.stopPropagation();

        // Pause auto-logout monitoring during confirmation
        if (window.pauseAutoLogoutReset) {
            window.pauseAutoLogoutReset();
        }

        Swal.fire({
            title: 'Konfirmasi Logout',
            html: `
                <div class="text-center">
                    <div class="mb-4">
                        <i class="fas fa-sign-out-alt text-6xl text-red-500"></i>
                    </div>
                    <p class="text-gray-600 text-lg mb-2">Apakah Anda yakin ingin keluar dari sistem?</p>
                    <p class="text-gray-500 text-sm">Session Anda akan diakhiri dan Anda akan kembali ke halaman login.</p>
                </div>
            `,
            icon: false,
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: '<i class="fas fa-sign-out-alt mr-2"></i>Ya, Keluar',
            cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
            reverseButtons: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            keydownListenerCapture: true,
            customClass: {
                popup: 'swal2-custom-popup logout-confirmation-active',
                confirmButton: 'swal2-custom-confirm-button',
                cancelButton: 'swal2-custom-cancel-button'
            },
            didOpen: () => {
                // Add marker class to popup
                const popup = document.querySelector('.swal2-popup');
                if (popup) {
                    popup.classList.add('logout-confirmation-active');
                }
            },
            didClose: () => {
                // Remove marker class
                const popup = document.querySelector('.swal2-popup');
                if (popup) {
                    popup.classList.remove('logout-confirmation-active');
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Memproses Logout',
                    html: `
                        <div class="loading-icon">
                            <i class="fas fa-circle-notch fa-spin"></i>
                        </div>
                        <p class="text-gray-600 mt-4">Sedang mengakhiri session...</p>
                    `,
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'swal2-modal-popup',
                        htmlContainer: 'swal2-html-container'
                    }
                });

                // Submit form tanpa delay
                document.getElementById('logoutFormNavbar').submit();
            } else {
                // Resume auto-logout monitoring if cancelled
                if (window.resumeAutoLogoutReset) {
                    window.resumeAutoLogoutReset();
                }
            }
        });
    }
</script>

<style>
    /* Custom SweetAlert Styles untuk Logout */
    .swal2-custom-popup {
        border-radius: 16px !important;
        padding: 24px !important;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3) !important;
        z-index: 99999 !important;
        pointer-events: auto !important; /* Memastikan popup menerima pointer events */
        will-change: transform, opacity; /* Optimize untuk animasi */
        transform: translateZ(0); /* Force GPU acceleration */
        backface-visibility: hidden; /* Mencegah rendering glitches */
    }

    /* SweetAlert Container - Pastikan z-index cukup tinggi */
    .swal2-container {
        z-index: 99999 !important;
        pointer-events: auto !important; /* Memastikan container menerima pointer events */
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
    }

    /* Protect backdrop */
    .swal2-backdrop-show {
        background: rgba(0, 0, 0, 0.5) !important;
        z-index: 99998 !important;
        pointer-events: auto !important;
    }

    .swal2-custom-confirm-button {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        border-radius: 12px !important;
        padding: 12px 24px !important;
        font-weight: 600 !important;
        font-size: 14px !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3) !important;
        pointer-events: auto !important;
    }

    .swal2-custom-confirm-button:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 16px rgba(239, 68, 68, 0.4) !important;
    }

    .swal2-custom-cancel-button {
        background: #64748b !important;
        border-radius: 12px !important;
        padding: 12px 24px !important;
        font-weight: 600 !important;
        font-size: 14px !important;
        transition: all 0.3s ease !important;
        pointer-events: auto !important;
    }

    .swal2-custom-cancel-button:hover {
        background: #475569 !important;
        transform: translateY(-2px) !important;
    }

    /* Marker class untuk logout confirmation */
    .logout-confirmation-active {
        pointer-events: auto !important;
    }
</style>
