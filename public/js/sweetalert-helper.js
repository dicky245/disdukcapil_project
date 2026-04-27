/**
 * =====================================================
 * SWEETALERT HELPER - SISTEM NOTIFIKASI UTAMA
 * =====================================================
 * Disdukcapil Kabupaten Toba
 * 
 * File ini adalah definisi utama SwalHelper.
 * Semua sistem notifikasi delegation ke file ini.
 * 
 * @author Disdukcapil Toba
 * @version 2.0.0
 * @requires SweetAlert2 v11.x
 */

// === SELALU CEK APAKAH SwalHelper SUDAH ADA ===
// Jika sudah ada, extend saja (jangan replace)

(function(window) {
    'use strict';

    // =====================================================
    // KONFIGURASI DEFAULT
    // =====================================================

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

    // =====================================================
    // TOAST NOTIFICATIONS
    // =====================================================

    function toastSuccess(message, duration = 3000) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: duration,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
        Toast.fire({
            icon: 'success',
            title: message,
            iconColor: '#22c55e'
        });
    }

    function toastError(message, duration = 4000) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: duration,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
        Toast.fire({
            icon: 'error',
            title: message,
            iconColor: '#ef4444'
        });
    }

    function toastWarning(message, duration = 3500) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: duration,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
        Toast.fire({
            icon: 'warning',
            title: message,
            iconColor: '#eab308'
        });
    }

    function toastInfo(message, duration = 3000) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: duration,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
        Toast.fire({
            icon: 'info',
            title: message,
            iconColor: '#0052CC'
        });
    }

    // =====================================================
    // MODAL DIALOGS
    // =====================================================

    function modalSuccess(title, message, callback = null) {
        Swal.fire({
            icon: 'success',
            title: title,
            html: message,
            confirmButtonText: '<i class="fas fa-check mr-2"></i>OK',
            confirmButtonColor: '#22c55e',
            zIndex: 9999
        }).then((result) => {
            if (result.isConfirmed && callback) callback();
        });
    }

    function modalError(title, message, callback = null) {
        Swal.fire({
            icon: 'error',
            title: title,
            html: message,
            confirmButtonText: '<i class="fas fa-times mr-2"></i>Tutup',
            confirmButtonColor: '#ef4444',
            zIndex: 9999
        }).then((result) => {
            if (result.isConfirmed && callback) callback();
        });
    }

    function modalWarning(title, message, callback = null) {
        Swal.fire({
            icon: 'warning',
            title: title,
            html: message,
            confirmButtonText: '<i class="fas fa-exclamation-triangle mr-2"></i>OK',
            confirmButtonColor: '#eab308',
            zIndex: 9999
        }).then((result) => {
            if (result.isConfirmed && callback) callback();
        });
    }

    function modalInfo(title, message, callback = null) {
        Swal.fire({
            icon: 'info',
            title: title,
            html: message,
            confirmButtonText: '<i class="fas fa-info-circle mr-2"></i>OK',
            confirmButtonColor: '#0052CC',
            zIndex: 9999
        }).then((result) => {
            if (result.isConfirmed && callback) callback();
        });
    }

    // =====================================================
    // CONFIRM DIALOGS
    // =====================================================

    function confirmDialog(title, text, callback) {
        Swal.fire({
            title: title,
            html: `<p>${text}</p>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-check mr-2"></i>Ya, Lanjutkan',
            cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
            reverseButtons: true,
            confirmButtonColor: '#0052CC',
            cancelButtonColor: '#64748b'
        }).then((result) => {
            if (result.isConfirmed && callback) callback();
        });
    }

    function deleteConfirm(title, text, callback) {
        Swal.fire({
            title: title,
            html: `
                <div class="text-center">
                    <i class="fas fa-exclamation-triangle text-5xl text-red-500 mb-4"></i>
                    <p class="mb-4">${text}</p>
                    <p class="text-red-500 font-semibold">Tindakan ini tidak dapat dibatalkan!</p>
                </div>
            `,
            icon: false,
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-trash mr-2"></i>Ya, Hapus',
            cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
            reverseButtons: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b'
        }).then((result) => {
            if (result.isConfirmed && callback) callback();
        });
    }

    function saveConfirm(title, text, callback) {
        Swal.fire({
            title: title,
            html: `<p>${text}</p>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-save mr-2"></i>Ya, Simpan',
            cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
            reverseButtons: true,
            confirmButtonColor: '#22c55e',
            cancelButtonColor: '#64748b'
        }).then((result) => {
            if (result.isConfirmed && callback) callback();
        });
    }

    // =====================================================
    // CUSTOM CONFIRM DENGAN ICON
    // =====================================================

    function customConfirm(options = {}) {
        const defaults = {
            title: 'Konfirmasi',
            message: 'Apakah Anda yakin?',
            subMessage: '',
            iconClass: 'fas fa-question-circle',
            iconColor: '#0052CC',
            confirmText: 'Ya, Lanjutkan',
            confirmColor: '#0052CC',
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
            customClass: {
                popup: 'rounded-2xl shadow-2xl',
                confirmButton: 'rounded-lg px-6 py-3',
                cancelButton: 'rounded-lg px-6 py-3'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                if (config.showLoadingAfterConfirm) {
                    Swal.fire({
                        title: config.loadingTitle,
                        html: `
                            <div class="text-center">
                                <i class="fas fa-circle-notch fa-spin text-4xl text-green-500"></i>
                                <p class="mt-4 text-gray-600">${config.loadingMessage}</p>
                            </div>
                        `,
                        showConfirmButton: false,
                        allowOutsideClick: false
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
    }

    // Helper khusus dengan auto-logout integration
    function confirmStart(title, message, subMessage, onConfirm, onCancel) {
        if (window.pauseAutoLogoutReset) window.pauseAutoLogoutReset();

        customConfirm({
            title: title,
            message: message,
            subMessage: subMessage,
            iconClass: 'fas fa-play-circle',
            iconColor: '#28A745',
            confirmText: 'Ya, Mulai',
            confirmColor: '#28A745',
            cancelText: 'Batal',
            cancelColor: '#64748b',
            onConfirm: onConfirm,
            onCancel: () => {
                if (window.resumeAutoLogoutReset && onCancel) onCancel();
                if (window.resumeAutoLogoutReset) window.resumeAutoLogoutReset();
            }
        });
    }

    function confirmDelete(title, message, subMessage, onConfirm, onCancel) {
        if (window.pauseAutoLogoutReset) window.pauseAutoLogoutReset();

        customConfirm({
            title: title,
            message: message,
            subMessage: subMessage,
            iconClass: 'fas fa-trash',
            iconColor: '#ef4444',
            confirmText: 'Ya, Hapus',
            confirmColor: '#ef4444',
            cancelText: 'Batal',
            cancelColor: '#64748b',
            onConfirm: onConfirm,
            onCancel: () => {
                if (window.resumeAutoLogoutReset && onCancel) onCancel();
                if (window.resumeAutoLogoutReset) window.resumeAutoLogoutReset();
            }
        });
    }

    function confirmSave(title, message, subMessage, onConfirm, onCancel) {
        if (window.pauseAutoLogoutReset) window.pauseAutoLogoutReset();

        customConfirm({
            title: title,
            message: message,
            subMessage: subMessage,
            iconClass: 'fas fa-save',
            iconColor: '#22c55e',
            confirmText: 'Ya, Simpan',
            confirmColor: '#22c55e',
            cancelText: 'Batal',
            cancelColor: '#64748b',
            onConfirm: onConfirm,
            onCancel: () => {
                if (window.resumeAutoLogoutReset && onCancel) onCancel();
                if (window.resumeAutoLogoutReset) window.resumeAutoLogoutReset();
            }
        });
    }

    function confirmUpdate(title, message, subMessage, onConfirm, onCancel) {
        if (window.pauseAutoLogoutReset) window.pauseAutoLogoutReset();

        customConfirm({
            title: title,
            message: message,
            subMessage: subMessage,
            iconClass: 'fas fa-sync',
            iconColor: '#0052CC',
            confirmText: 'Ya, Update',
            confirmColor: '#0052CC',
            cancelText: 'Batal',
            cancelColor: '#64748b',
            onConfirm: onConfirm,
            onCancel: () => {
                if (window.resumeAutoLogoutReset && onCancel) onCancel();
                if (window.resumeAutoLogoutReset) window.resumeAutoLogoutReset();
            }
        });
    }

    function confirmLogout(title, message, subMessage, onConfirm, onCancel) {
        if (window.pauseAutoLogoutReset) window.pauseAutoLogoutReset();

        customConfirm({
            title: title,
            message: message,
            subMessage: subMessage,
            iconClass: 'fas fa-sign-out-alt',
            iconColor: '#ef4444',
            confirmText: 'Ya, Keluar',
            confirmColor: '#ef4444',
            cancelText: 'Batal',
            cancelColor: '#64748b',
            onConfirm: onConfirm,
            onCancel: () => {
                if (window.resumeAutoLogoutReset && onCancel) onCancel();
                if (window.resumeAutoLogoutReset) window.resumeAutoLogoutReset();
            }
        });
    }

    // =====================================================
    // NOTIFIKASI SPESIAL
    // =====================================================

    function notifySuccess(title, message, subMessage, callback) {
        customConfirm({
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
    }

    function notifyError(title, message, subMessage, callback) {
        customConfirm({
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
    }

    function notifyWarning(title, message, subMessage, callback) {
        customConfirm({
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
    }

    // =====================================================
    // LOADING
    // =====================================================

    function showLoading(message = 'Memproses...') {
        return Swal.fire({
            title: message,
            html: `
                <div class="text-center">
                    <i class="fas fa-circle-notch fa-spin text-4xl text-green-500"></i>
                    <p class="mt-4 text-gray-600">Mohon tunggu sebentar...</p>
                </div>
            `,
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false
        });
    }

    function closeLoading() {
        Swal.close();
    }

    // =====================================================
    // CLOSE
    // =====================================================

    function closeSwal() {
        Swal.close();
    }

    // =====================================================
    // EXPORT KE SwalHelper
    // =====================================================

    // Inisialisasi atau extend SwalHelper
    if (typeof window.SwalHelper === 'undefined') {
        window.SwalHelper = {};
    }

    // Assign semua fungsi
    Object.assign(window.SwalHelper, {
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
        successModal: modalSuccess,

        // Confirm
        confirm: confirmDialog,
        deleteConfirm,
        saveConfirm,
        customConfirm,
        confirmStart,
        confirmDelete,
        confirmSave,
        confirmUpdate,
        confirmLogout,

        // Notifikasi
        notifySuccess,
        notifyError,
        notifyWarning,

        // Loading
        loading: showLoading,
        close: closeSwal
    });

    console.log('✓ SweetAlert Helper loaded');

})(window);
