/**
 * Auto-Logout System
 * Automatically logs out users after 10 minutes of inactivity
 */

(function() {
    'use strict';

    // Configuration
    const INACTIVITY_LIMIT = 10; // minutes
    const WARNING_TIME = 2; // minutes before logout (show warning)
    const CHECK_INTERVAL = 1000; // check every second

    // State variables
    let inactivityTime = 0;
    let warningShown = false;
    let logoutTimer = null;
    let countdownTimer = null;
    let timeRemaining = 0;
    let autoLogoutPaused = false; // NEW: Pause flag for logout confirmation

    /**
     * Reset inactivity timer on user activity
     */
    function resetInactivityTimer() {
        // NEW: Check if auto-logout is paused (during logout confirmation)
        if (autoLogoutPaused) {
            return; // Don't reset if paused
        }

        inactivityTime = 0;
        warningShown = false;

        // Clear any existing timers
        if (logoutTimer) {
            clearTimeout(logoutTimer);
            logoutTimer = null;
        }
        if (countdownTimer) {
            clearInterval(countdownTimer);
            countdownTimer = null;
        }

        // JANGAN tutup SweetAlert popup - biarkan user berinteraksi dengan popup
        // Hanya update last activity time
        // SweetAlert akan menutup sendiri jika user berinteraksi

        // Update last activity in localStorage
        localStorage.setItem('lastActivity', Date.now().toString());

        // Start new timer
        startInactivityCheck();
    }

    /**
     * Pause auto-logout monitoring (for logout confirmation dialogs)
     */
    function pauseAutoLogout() {
        autoLogoutPaused = true;
        console.log('[Auto-Logout] Monitoring paused');
    }

    /**
     * Resume auto-logout monitoring
     */
    function resumeAutoLogout() {
        autoLogoutPaused = false;
        resetInactivityTimer();
        console.log('[Auto-Logout] Monitoring resumed');
    }

    // Export functions to global scope
    window.pauseAutoLogoutReset = pauseAutoLogout;
    window.resumeAutoLogoutReset = resumeAutoLogout;

    /**
     * Start inactivity check
     */
    function startInactivityCheck() {
        // Set logout timer
        logoutTimer = setTimeout(() => {
            performAutoLogout();
        }, INACTIVITY_LIMIT * 60 * 1000);

        // Set warning timer
        setTimeout(() => {
            if (!warningShown) {
                showWarningDialog();
            }
        }, (INACTIVITY_LIMIT - WARNING_TIME) * 60 * 1000);
    }

    /**
     * Show warning dialog before auto-logout
     */
    function showWarningDialog() {
        warningShown = true;
        timeRemaining = WARNING_TIME * 60; // seconds

        // Calculate time until logout
        const timeUntilLogout = (Date.now() - parseInt(localStorage.getItem('lastActivity') || Date.now())) / 1000 / 60;
        const remainingMinutes = Math.max(0, Math.ceil(INACTIVITY_LIMIT - timeUntilLogout));

        // Show countdown modal
        Swal.fire({
            title: 'Peringatan Inaktivitas',
            html: `
                <div class="text-center">
                    <p class="text-gray-600 mb-4">
                        Anda tidak memiliki aktivitas selama beberapa waktu.
                    </p>
                    <p class="text-gray-700 mb-2">
                        Anda akan otomatis logout dalam:
                    </p>
                    <div class="text-4xl font-bold text-red-600 mb-4" id="countdown">
                        ${formatTime(timeRemaining)}
                    </div>
                    <p class="text-sm text-gray-500">
                        Klik tombol di bawah untuk melanjutkan sesi
                    </p>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Lanjutkan Sesi',
            cancelButtonText: 'Logout Sekarang',
            confirmButtonColor: '#0052CC',
            cancelButtonColor: '#ef4444',
            allowOutsideClick: false,
            allowEscapeKey: false,
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
            if (result.isConfirmed) {
                // User clicked "Lanjutkan Sesi"
                resetInactivityTimer();
                Swal.fire({
                    icon: 'success',
                    title: 'Sesi Dilanjutkan',
                    text: 'Sesi Anda telah diperpanjang. Silakan lanjutkan aktivitas Anda.',
                    timer: 2000,
                    showConfirmButton: false,
                    timerProgressBar: true
                });
            } else if (result.isDismissed || result.isDenied) {
                // User clicked "Logout Sekarang" or dismissed
                performLogout();
            }
        });

        // Start countdown
        countdownTimer = setInterval(() => {
            timeRemaining--;
            const countdownElement = document.getElementById('countdown');
            if (countdownElement) {
                countdownElement.textContent = formatTime(timeRemaining);
            }

            if (timeRemaining <= 0) {
                clearInterval(countdownTimer);
                if (Swal.isVisible()) {
                    Swal.close();
                }
                performAutoLogout();
            }
        }, 1000);
    }

    /**
     * Format time as MM:SS
     */
    function formatTime(seconds) {
        const mins = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
    }

    /**
     * Perform auto-logout
     */
    function performAutoLogout() {
        // Clear all timers
        if (logoutTimer) {
            clearTimeout(logoutTimer);
        }
        if (countdownTimer) {
            clearInterval(countdownTimer);
        }

        // Show logout notification
        Swal.fire({
            title: 'Sesi Berakhir',
            text: 'Anda telah logout secara otomatis karena tidak ada aktivitas selama 10 menit.',
            icon: 'info',
            confirmButtonText: 'OK',
            confirmButtonColor: '#0052CC',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then(() => {
            performLogout();
        });
    }

    /**
     * Perform logout
     */
    function performLogout() {
        // Clear all session data
        localStorage.clear();
        sessionStorage.clear();

        // Clear all cookies
        document.cookie.split(";").forEach((c) => {
            document.cookie = c
                .replace(/^ +/, "")
                .replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/");
        });

        // Clear cache
        if ('caches' in window) {
            caches.keys().then((names) => {
                names.forEach((name) => caches.delete(name));
            });
        }

        // Redirect to logout
        window.location.href = '/logout';
    }

    /**
     * Initialize auto-logout system
     */
    function initAutoLogout() {
        // Check if user is logged in
        const isLoggedIn = document.body.querySelector('[data-user-authenticated="true"]') ||
                          document.querySelector('meta[name="user-authenticated"]')?.content === 'true';

        if (!isLoggedIn) {
            return; // Don't initialize if not logged in
        }

        // Initialize last activity - ALWAYS reset on page load for fresh start
        // This prevents immediate logout after login due to stale localStorage data
        localStorage.setItem('lastActivity', Date.now().toString());
        localStorage.setItem('sessionStartTime', Date.now().toString());

        // Get last activity (now freshly set above)
        const lastActivity = localStorage.getItem('lastActivity');

        // Get session start time to avoid logging out immediately after login
        const sessionStartTime = localStorage.getItem('sessionStartTime');
        const minutesSinceLogin = (Date.now() - parseInt(sessionStartTime)) / 1000 / 60;

        // Don't check for past inactivity on page load - this is a fresh login or page refresh
        // Only start monitoring from now

        // Monitor user activity - HAPUS mousemove karena terlalu sering trigger dan mengganggu SweetAlert
        const activityEvents = [
            'mousedown',  // Mouse click
            'keypress',   // Keyboard press
            'scroll',     // Scroll
            'touchstart', // Touch screen
            'click'       // Click
            // 'mousemove' DIHAPUS - menyebabkan popup hilang saat cursor bergerak!
        ];

        activityEvents.forEach(event => {
            document.addEventListener(event, resetInactivityTimer, { passive: true });
        });

        // Also monitor visibility change
        document.addEventListener('visibilitychange', () => {
            if (!document.hidden) {
                // Page became visible again, check inactivity
                const lastActivity = localStorage.getItem('lastActivity');
                if (lastActivity) {
                    const inactiveMinutes = (Date.now() - parseInt(lastActivity)) / 1000 / 60;
                    if (inactiveMinutes >= INACTIVITY_LIMIT) {
                        performAutoLogout();
                    } else {
                        resetInactivityTimer();
                    }
                }
            }
        });

        // Start initial timer
        startInactivityCheck();

        // Console log for debugging (remove in production)
        console.log('Auto-logout system initialized: ' + INACTIVITY_LIMIT + ' minutes');
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAutoLogout);
    } else {
        initAutoLogout();
    }

    // Also initialize on window load (backup)
    window.addEventListener('load', initAutoLogout);

})();
