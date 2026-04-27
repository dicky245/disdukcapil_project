/**
 * =====================================================
 * NOTIFIKASI DISDUKCAPIL - SISTEM NOTIFIKASI TERPUSAT
 * =====================================================
 * 
 * File ini menyediakan wrapper/notifikasi terpusat yang
 * delegation ke SwalHelper yang sudah terintegrasi di layouts.
 * 
 * @author Disdukcapil Toba
 * @version 1.0.0
 * @requires SweetAlert2 v11.x
 * @requires SwalHelper (dari layouts)
 */

(function(window) {
    'use strict';

    // =====================================================
    // 1. WRAPPER UNTUK SWALHELPER
    // =====================================================

    /**
     * Success Toast
     */
    function showSuccess(message) {
        if (window.SwalHelper && typeof SwalHelper.success === 'function') {
            SwalHelper.success(message);
        } else {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: message,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        }
    }

    /**
     * Error Toast
     */
    function showError(message) {
        if (window.SwalHelper && typeof SwalHelper.error === 'function') {
            SwalHelper.error(message);
        } else {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: message,
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true
            });
        }
    }

    /**
     * Info Toast
     */
    function showInfo(message) {
        if (window.SwalHelper && typeof SwalHelper.info === 'function') {
            SwalHelper.info(message);
        } else {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'info',
                title: message,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        }
    }

    /**
     * Warning Toast
     */
    function showWarning(message) {
        if (window.SwalHelper && typeof SwalHelper.warning === 'function') {
            SwalHelper.warning(message);
        } else {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'warning',
                title: message,
                showConfirmButton: false,
                timer: 3500,
                timerProgressBar: true
            });
        }
    }

    /**
     * Konfirmasi Hapus
     */
    function showDeleteConfirm(title, text, onConfirm) {
        if (window.SwalHelper && typeof SwalHelper.deleteConfirm === 'function') {
            SwalHelper.deleteConfirm(title, text, onConfirm);
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Konfirmasi Hapus',
                html: `<p>${text}</p><p class="text-red-500 mt-2 font-semibold">Tindakan ini tidak dapat dibatalkan!</p>`,
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-trash mr-2"></i>Ya, Hapus',
                cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed && onConfirm) onConfirm();
            });
        }
    }

    /**
     * Konfirmasi Umum
     */
    function showConfirm(title, text, onConfirm) {
        if (window.SwalHelper && typeof SwalHelper.confirm === 'function') {
            SwalHelper.confirm(title, text, onConfirm);
        } else {
            Swal.fire({
                icon: 'question',
                title: title,
                html: `<p>${text}</p>`,
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-check mr-2"></i>Ya, Lanjutkan',
                cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
                confirmButtonColor: '#22c55e',
                cancelButtonColor: '#64748b',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed && onConfirm) onConfirm();
            });
        }
    }

    /**
     * Loading Modal
     */
    function showLoading(message) {
        if (window.SwalHelper && typeof SwalHelper.loading === 'function') {
            SwalHelper.loading(message);
        } else {
            Swal.fire({
                title: message || 'Memproses...',
                html: '<i class="fas fa-circle-notch fa-spin text-3xl text-green-500"></i>',
                showConfirmButton: false,
                allowOutsideClick: false
            });
        }
    }

    // =====================================================
    // 2. FUNGSI NOTIFIKASI KHUSUS
    // =====================================================

    /**
     * Notifikasi sukses dengan nomor registrasi
     */
    function notifSuksesRegistrasi(nomorRegistrasi, callback) {
        if (window.SwalHelper && typeof SwalHelper.successModal === 'function') {
            SwalHelper.successModal(
                'Berhasil Disimpan!',
                `Data berhasil disimpan<br><span class="text-green-600 font-bold font-mono">${nomorRegistrasi}</span>`,
                callback
            );
        } else {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                html: `Data berhasil disimpan<br><strong>${nomorRegistrasi}</strong>`,
                confirmButtonText: 'OK',
                confirmButtonColor: '#22c55e'
            }).then(() => {
                if (callback) callback();
            });
        }
    }

    /**
     * Notifikasi error
     */
    function notifError(pesanError, callback) {
        if (window.SwalHelper && typeof SwalHelper.modalError === 'function') {
            SwalHelper.modalError('Terjadi Kesalahan', pesanError, callback);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: pesanError,
                confirmButtonText: 'OK',
                confirmButtonColor: '#ef4444'
            }).then(() => {
                if (callback) callback();
            });
        }
    }

    /**
     * Notifikasi validasi error
     */
    function notifValidasiError(arrayErrors, callback) {
        if (typeof arrayErrors === 'string') {
            arrayErrors = [arrayErrors];
        }
        
        const errorsHtml = arrayErrors.map(err => 
            `<li class="text-left mb-2"><i class="fas fa-times-circle text-red-500 mr-2"></i>${err}</li>`
        ).join('');
        
        Swal.fire({
            icon: 'error',
            title: 'Validasi Gagal!',
            html: `
                <p class="mb-3">${arrayErrors.length} kesalahan ditemukan:</p>
                <ul class="text-left text-sm list-disc pl-5">${errorsHtml}</ul>
            `,
            confirmButtonText: 'OK',
            confirmButtonColor: '#ef4444'
        }).then(() => {
            if (callback) callback();
        });
    }

    /**
     * Notifikasi cari ditemukan
     */
    function notifCariDitemukan(jumlah, keyword, callback) {
        showSuccess(`${jumlah} data ditemukan untuk "${keyword}"`);
        if (callback) callback();
    }

    /**
     * Notifikasi cari tidak ditemukan
     */
    function notifCariTidakDitemukan(keyword, callback) {
        showWarning(`Tidak ada data untuk "${keyword}"`);
        if (callback) callback();
    }

    /**
     * Notifikasi hapus berhasil
     */
    function notifHapusBerhasil(namaData, callback) {
        showSuccess(`Data "${namaData}" berhasil dihapus`);
        if (callback) setTimeout(callback, 100);
    }

    /**
     * Notifikasi disetujui
     */
    function notifDisetujui(namaPemohon, callback) {
        if (window.SwalHelper && typeof SwalHelper.successModal === 'function') {
            SwalHelper.successModal(
                'Disetujui!',
                `Pengajuan <strong>${namaPemohon}</strong><br>telah disetujui`,
                callback
            );
        } else {
            showSuccess(`Pengajuan ${namaPemohon} telah disetujui`);
        }
    }

    // =====================================================
    // 3. EXPORT KE GLOBAL WINDOW
    // =====================================================

    window.Notifikasi = {
        // Wrapper
        success: showSuccess,
        error: showError,
        info: showInfo,
        warning: showWarning,
        confirm: showConfirm,
        deleteConfirm: showDeleteConfirm,
        loading: showLoading,
        
        // Fungsi notifikasi
        sukses: notifSuksesRegistrasi,
        error: notifError,
        validasi: notifValidasiError,
        cariDitemukan: notifCariDitemukan,
        cariTidakDitemukan: notifCariTidakDitemukan,
        hapusBerhasil: notifHapusBerhasil,
        disetujui: notifDisetujui
    };

    // Alias global (untuk backward compatibility)
    window.showSuccess = showSuccess;
    window.showError = showError;
    window.showInfo = showInfo;
    window.showWarning = showWarning;
    window.showConfirm = showConfirm;
    window.showDeleteConfirm = showDeleteConfirm;
    window.showLoading = showLoading;
    window.notifSuksesRegistrasi = notifSuksesRegistrasi;
    window.notifError = notifError;
    window.notifValidasiError = notifValidasiError;
    window.notifCariDitemukan = notifCariDitemukan;
    window.notifCariTidakDitemukan = notifCariTidakDitemukan;
    window.notifHapusBerhasil = notifHapusBerhasil;
    window.notifDisetujui = notifDisetujui;

})(window);
