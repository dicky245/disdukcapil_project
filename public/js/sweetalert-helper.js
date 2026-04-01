/**
 * SweetAlert Helper - Global Notification System
 * Disdukcapil Kabupaten Toba
 *
 * Menyediakan fungsi-fungsi helper untuk notifikasi yang konsisten
 * menggunakan SweetAlert2 di seluruh aplikasi
 */

// === Base Configuration ===
const SwalConfig = {
    confirmButtonColor: '#0052CC',
    cancelButtonColor: '#64748b',
    backdrop: 'rgba(0, 0, 0, 0.5)',
    customClass: {
        confirmButton: 'bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-200',
        cancelButton: 'bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-6 py-3 rounded-xl transition-all duration-200',
        popup: 'rounded-2xl shadow-2xl',
        title: 'text-xl font-bold text-gray-800',
        htmlContainer: 'text-gray-600',
        actions: 'flex gap-3',
    }
};

// === Toast Notifications ===

/**
 * Toast Success - Notifikasi sukses singkat
 * @param {string} message - Pesan notifikasi
 * @param {number} duration - Durasi tampil (ms), default 3000ms
 */
const toastSuccess = (message, duration = 3000) => {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: duration,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        },
        customClass: {
            popup: 'bg-white rounded-xl shadow-xl border-l-4 border-green-500',
            title: 'text-green-700 font-semibold',
            htmlContainer: 'text-gray-600 text-sm',
        }
    });

    Toast.fire({
        icon: 'success',
        title: message,
        iconColor: '#22c55e'
    });
};

/**
 * Toast Error - Notifikasi error singkat
 * @param {string} message - Pesan error
 * @param {number} duration - Durasi tampil (ms), default 4000ms
 */
const toastError = (message, duration = 4000) => {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: duration,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        },
        customClass: {
            popup: 'bg-white rounded-xl shadow-xl border-l-4 border-red-500',
            title: 'text-red-700 font-semibold',
            htmlContainer: 'text-gray-600 text-sm',
        }
    });

    Toast.fire({
        icon: 'error',
        title: message,
        iconColor: '#ef4444'
    });
};

/**
 * Toast Warning - Notifikasi peringatan singkat
 * @param {string} message - Pesan peringatan
 * @param {number} duration - Durasi tampil (ms), default 3500ms
 */
const toastWarning = (message, duration = 3500) => {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: duration,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        },
        customClass: {
            popup: 'bg-white rounded-xl shadow-xl border-l-4 border-yellow-500',
            title: 'text-yellow-700 font-semibold',
            htmlContainer: 'text-gray-600 text-sm',
        }
    });

    Toast.fire({
        icon: 'warning',
        title: message,
        iconColor: '#eab308'
    });
};

/**
 * Toast Info - Notifikasi informasi singkat
 * @param {string} message - Pesan informasi
 * @param {number} duration - Durasi tampil (ms), default 3000ms
 */
const toastInfo = (message, duration = 3000) => {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: duration,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        },
        customClass: {
            popup: 'bg-white rounded-xl shadow-xl border-l-4 border-blue-500',
            title: 'text-blue-700 font-semibold',
            htmlContainer: 'text-gray-600 text-sm',
        }
    });

    Toast.fire({
        icon: 'info',
        title: message,
        iconColor: '#0052CC'
    });
};

// === Modal Dialogs ===

/**
 * Modal Success - Modal sukses dengan tombol OK
 * @param {string} title - Judul modal
 * @param {string} message - Pesan sukses
 * @param {Function} callback - Fungsi yang dipanggil setelah klik OK
 */
const modalSuccess = (title, message, callback = null) => {
    Swal.fire({
        icon: 'success',
        title: title,
        text: message,
        confirmButtonText: '<i class="fas fa-check mr-2"></i>OK',
        confirmButtonColor: '#22c55e',
        zIndex: 9999,
        ...SwalConfig
    }).then((result) => {
        if (result.isConfirmed && callback) {
            callback();
        }
    });
};

/**
 * Modal Error - Modal error dengan tombol OK
 * @param {string} title - Judul modal
 * @param {string} message - Pesan error
 * @param {Function} callback - Fungsi yang dipanggil setelah klik OK
 */
const modalError = (title, message, callback = null) => {
    Swal.fire({
        icon: 'error',
        title: title,
        text: message,
        confirmButtonText: '<i class="fas fa-times mr-2"></i>Tutup',
        confirmButtonColor: '#ef4444',
        zIndex: 9999,
        ...SwalConfig
    }).then((result) => {
        if (result.isConfirmed && callback) {
            callback();
        }
    });
};

/**
 * Modal Warning - Modal peringatan dengan tombol OK
 * @param {string} title - Judul modal
 * @param {string} message - Pesan peringatan
 * @param {Function} callback - Fungsi yang dipanggil setelah klik OK
 */
const modalWarning = (title, message, callback = null) => {
    Swal.fire({
        icon: 'warning',
        title: title,
        text: message,
        confirmButtonText: '<i class="fas fa-exclamation-triangle mr-2"></i>OK',
        confirmButtonColor: '#eab308',
        zIndex: 9999,
        ...SwalConfig
    }).then((result) => {
        if (result.isConfirmed && callback) {
            callback();
        }
    });
};

/**
 * Modal Info - Modal informasi dengan tombol OK
 * @param {string} title - Judul modal
 * @param {string} message - Pesan informasi
 * @param {Function} callback - Fungsi yang dipanggil setelah klik OK
 */
const modalInfo = (title, message, callback = null) => {
    Swal.fire({
        icon: 'info',
        title: title,
        text: message,
        confirmButtonText: '<i class="fas fa-info-circle mr-2"></i>OK',
        confirmButtonColor: '#0052CC',
        zIndex: 9999,
        ...SwalConfig
    }).then((result) => {
        if (result.isConfirmed && callback) {
            callback();
        }
    });
};

// === Confirmation Dialogs ===

/**
 * Confirm Dialog - Dialog konfirmasi dengan tombol Ya/Batal
 * @param {string} title - Judul dialog
 * @param {string} message - Pesan konfirmasi
 * @param {Function} onConfirm - Fungsi yang dipanggil jika dikonfirmasi
 * @param {Function} onCancel - Fungsi yang dipanggil jika dibatalkan
 */
const confirmDialog = (title, message, onConfirm = null, onCancel = null) => {
    Swal.fire({
        title: title,
        text: message,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-check mr-2"></i>Ya',
        cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
        reverseButtons: true,
        zIndex: 9999,
        ...SwalConfig
    }).then((result) => {
        if (result.isConfirmed && onConfirm) {
            onConfirm();
        } else if (result.isDismissed && onCancel) {
            onCancel();
        }
    });
};

/**
 * Delete Confirm - Dialog konfirmasi hapus
 * @param {string} title - Judul dialog
 * @param {string} message - Pesan konfirmasi
 * @param {Function} onDelete - Fungsi yang dipanggil jika dikonfirmasi hapus
 */
const deleteConfirm = (title, message, onDelete) => {
    Swal.fire({
        title: title,
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-trash mr-2"></i>Ya, Hapus',
        cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        reverseButtons: true,
        zIndex: 9999,
        ...SwalConfig
    }).then((result) => {
        if (result.isConfirmed && onDelete) {
            onDelete();
        }
    });
};

/**
 * Save Confirm - Dialog konfirmasi simpan
 * @param {string} message - Pesan konfirmasi
 * @param {Function} onSave - Fungsi yang dipanggil jika dikonfirmasi simpan
 */
const saveConfirm = (message, onSave) => {
    Swal.fire({
        title: 'Konfirmasi Simpan',
        text: message,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-save mr-2"></i>Ya, Simpan',
        cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
        reverseButtons: true,
        zIndex: 9999,
        ...SwalConfig
    }).then((result) => {
        if (result.isConfirmed && onSave) {
            onSave();
        }
    });
};

// === Loading & Progress ===

/**
 * Loading - Tampilkan loading overlay
 * @param {string} title - Judul loading
 * @param {string} message - Pesan loading
 * @returns {Promise} Promise Swal fire
 */
const showLoading = (title = 'Memproses', message = 'Mohon tunggu sebentar...') => {
    return Swal.fire({
        title: title,
        html: `
            <div class="swal2-loading-container">
                <div class="swal2-loader"></div>
                <p class="swal2-text">${message}</p>
            </div>
        `,
        showConfirmButton: false,
        showCancelButton: false,
        allowOutsideClick: false,
        allowEscapeKey: false,
        backdrop: 'rgba(0, 0, 0, 0.7)',
        customClass: {
            popup: 'swal2-loading-popup',
        },
        zIndex: 9999,
        didOpen: () => {
            Swal.showLoading();
        }
    });
};

/**
 * Loading with Progress - Tampilkan loading dengan progress bar
 * @param {string} title - Judul loading
 * @param {number} percentage - Persentase progress (0-100)
 */
const showLoadingProgress = (title, percentage = 0) => {
    Swal.fire({
        title: title,
        html: `
            <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
                <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-300" style="width: ${percentage}%"></div>
            </div>
            <p class="text-sm text-gray-600">${percentage}% Selesai</p>
        `,
        showConfirmButton: false,
        allowOutsideClick: false,
        zIndex: 9999,
        ...SwalConfig
    });
};

/**
 * Close Loading - Tutup loading overlay
 */
const closeLoading = () => {
    Swal.close();
};

// === Form Specific ===

/**
 * Form Success - Notifikasi sukses submit form
 * @param {string} message - Pesan sukses
 * @param {string} redirectUrl - URL untuk redirect (opsional)
 */
const formSuccess = (message, redirectUrl = null) => {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: message,
        confirmButtonText: '<i class="fas fa-check mr-2"></i>Lanjutkan',
        confirmButtonColor: '#22c55e',
        zIndex: 9999,
        ...SwalConfig
    }).then((result) => {
        if (result.isConfirmed && redirectUrl) {
            window.location.href = redirectUrl;
        }
    });
};

/**
 * Form Error - Notifikasi error submit form
 * @param {string} message - Pesan error
 * @param {object} errors - Object errors validasi (opsional)
 */
const formError = (message, errors = null) => {
    let htmlContent = `<p>${message}</p>`;

    if (errors && Object.keys(errors).length > 0) {
        htmlContent += '<div class="mt-4 text-left">';
        htmlContent += '<ul class="list-disc list-inside text-sm space-y-1">';
        for (const [field, error] of Object.entries(errors)) {
            htmlContent += `<li class="text-red-600"><strong>${field}:</strong> ${Array.isArray(error) ? error[0] : error}</li>`;
        }
        htmlContent += '</ul></div>';
    }

    Swal.fire({
        icon: 'error',
        title: 'Terjadi Kesalahan',
        html: htmlContent,
        confirmButtonText: '<i class="fas fa-times mr-2"></i>Tutup',
        confirmButtonColor: '#ef4444',
        zIndex: 9999,
        ...SwalConfig
    });
};

/**
 * Form Confirm - Konfirmasi submit form
 * @param {string} title - Judul konfirmasi
 * @param {string} message - Pesan konfirmasi
 * @param {Function} onSubmit - Fungsi yang dipanggil jika dikonfirmasi
 */
const formConfirm = (title, message, onSubmit) => {
    Swal.fire({
        title: title,
        text: message,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-paper-plane mr-2"></i>Ya, Kirim',
        cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
        reverseButtons: true,
        zIndex: 9999,
        ...SwalConfig
    }).then((result) => {
        if (result.isConfirmed && onSubmit) {
            onSubmit();
        }
    });
};

// === Auto-Generate Alerts from Session ===

/**
 * Show Session Alerts - Tampilkan notifikasi dari session Laravel
 * Mendeteksi session('success'), session('error'), session('warning'), session('info')
 */
const showSessionAlerts = () => {
    // Periksa session dari Laravel (biasanya di data attribute atau meta tag)
    const sessionData = document.querySelector('meta[name="session-data"]');
    if (!sessionData) return;

    const session = JSON.parse(sessionData.getAttribute('content'));

    if (session.success) {
        toastSuccess(session.success);
    }
    if (session.error || session.errors) {
        const errorMsg = session.error || 'Terjadi kesalahan. Silakan coba lagi.';
        toastError(errorMsg);
    }
    if (session.warning) {
        toastWarning(session.warning);
    }
    if (session.info) {
        toastInfo(session.info);
    }
};

// === Export All Functions ===

// Global Object
window.SwalHelper = {
    // Toast
    toastSuccess,
    toastError,
    toastWarning,
    toastInfo,
    success: toastSuccess,
    error: toastError,
    warning: toastWarning,
    info: toastInfo,

    // Modal
    modalSuccess,
    modalError,
    modalWarning,
    modalInfo,

    // Confirm
    confirm: confirmDialog,
    delete: deleteConfirm,
    save: saveConfirm,

    // Loading
    loading: showLoading,
    loadingProgress: showLoadingProgress,
    close: closeLoading,

    // Form
    formSuccess,
    formError,
    formConfirm,
};

// Auto-execute untuk session alerts (jika ada)
document.addEventListener('DOMContentLoaded', () => {
    // Tambahkan style untuk custom loading
    const style = document.createElement('style');
    style.textContent = `
        /* SweetAlert Loading Styles */
        .swal2-loading-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem 1rem;
        }

        .swal2-loading-popup .swal2-html-container {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 2rem !important;
        }

        .swal2-loader {
            width: 60px !important;
            height: 60px !important;
            border: 4px solid #f3f4f6 !important;
            border-top-color: #0052CC !important;
            border-radius: 50% !important;
            animation: swal2-spin 1s linear infinite !important;
        }

        @keyframes swal2-spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .swal2-text {
            margin-top: 1.5rem !important;
            color: #6b7280 !important;
            font-size: 0.95rem !important;
            text-align: center !important;
        }

        /* Toast positioning fix */
        .swal2-toast {
            padding: 1rem 1.25rem !important;
        }

        .swal2-popup {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }

        .swal2-title {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }

        .swal2-html-container {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }
    `;
    document.head.appendChild(style);
});

console.log('✓ SweetAlert Helper loaded successfully');
