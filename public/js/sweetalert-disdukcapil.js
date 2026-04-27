igm/**
 * =====================================================
 * SWEETALERT2 ALIAS SYSTEM - DISDUKCAPIL TOBA
 * =====================================================
 * File ini menyediakan alias untuk SwalHelper yang sudah
 * terintegrasi di layouts. Semua fungsi delegation ke
 * SwalHelper untuk konsistensi dan menghindari konflik.
 * 
 * @requires SweetAlert2 v11.x
 * @requires SwalHelper (dari layouts)
 * =====================================================
 */

(function(window) {
    'use strict';

    // =====================================================
    // SWEETALERT DISDUKCAPIL - ALIAS KE SwalHelper
    // =====================================================
    
    /**
     * Namespace untuk backward compatibility
     * Semua fungsi delegation ke SwalHelper
     */
    window.SwalDisdukcapil = {
        
        // Fungsi Toast
        success: function(message) {
            if (window.SwalHelper) SwalHelper.success(message);
        },
        
        error: function(message) {
            if (window.SwalHelper) SwalHelper.error(message);
        },
        
        info: function(message) {
            if (window.SwalHelper) SwalHelper.info(message);
        },
        
        warning: function(message) {
            if (window.SwalHelper) SwalHelper.warning(message);
        },
        
        // Konfirmasi
        confirm: function(title, text, callback) {
            if (window.SwalHelper) SwalHelper.confirm(title, text, callback);
        },
        
        deleteConfirm: function(title, text, callback) {
            if (window.SwalHelper) SwalHelper.deleteConfirm(title, text, callback);
        },
        
        actionConfirm: function(options) {
            if (window.SwalHelper) SwalHelper.actionConfirm(options);
        },
        
        customConfirm: function(options) {
            if (window.SwalHelper) SwalHelper.customConfirm(options);
        },
        
        // Helper khusus
        confirmStart: function(title, message, subMessage, onConfirm, onCancel) {
            if (window.SwalHelper) SwalHelper.confirmStart(title, message, subMessage, onConfirm, onCancel);
        },
        
        confirmDelete: function(title, message, subMessage, onConfirm, onCancel) {
            if (window.SwalHelper) SwalHelper.confirmDelete(title, message, subMessage, onConfirm, onCancel);
        },
        
        confirmSave: function(title, message, subMessage, onConfirm, onCancel) {
            if (window.SwalHelper) SwalHelper.confirmSave(title, message, subMessage, onConfirm, onCancel);
        },
        
        confirmUpdate: function(title, message, subMessage, onConfirm, onCancel) {
            if (window.SwalHelper) SwalHelper.confirmUpdate(title, message, subMessage, onConfirm, onCancel);
        },
        
        confirmLogout: function(title, message, subMessage, onConfirm, onCancel) {
            if (window.SwalHelper) SwalHelper.confirmLogout(title, message, subMessage, onConfirm, onCancel);
        },
        
        // Notifikasi
        notifySuccess: function(title, message, subMessage, callback) {
            if (window.SwalHelper) SwalHelper.notifySuccess(title, message, subMessage, callback);
        },
        
        notifyError: function(title, message, subMessage, callback) {
            if (window.SwalHelper) SwalHelper.notifyError(title, message, subMessage, callback);
        },
        
        notifyWarning: function(title, message, subMessage, callback) {
            if (window.SwalHelper) SwalHelper.notifyWarning(title, message, subMessage, callback);
        },
        
        // Modal
        modalSuccess: function(title, message, callback) {
            if (window.SwalHelper) SwalHelper.modalSuccess(title, message, callback);
        },
        
        modalError: function(title, message, callback) {
            if (window.SwalHelper) SwalHelper.modalError(title, message, callback);
        },
        
        modalWarning: function(title, message, callback) {
            if (window.SwalHelper) SwalHelper.modalWarning(title, message, callback);
        },
        
        successModal: function(title, message, callback) {
            if (window.SwalHelper) SwalHelper.successModal(title, message, callback);
        },
        
        // Loading
        loading: function(message) {
            if (window.SwalHelper) SwalHelper.loading(message);
        },
        
        // Close
        close: function() {
            if (window.SwalHelper) SwalHelper.close();
            else Swal.close();
        }
    };

    // =====================================================
    // ALIAS GLOBAL UNTUK BACKWARD COMPATIBILITY
    // =====================================================
    
    /**
     * Fungsi-fungsi notifikasi yang dipanggil langsung
     * Delegation ke SwalHelper yang sesuai
     */
    window.notifSimpanBerhasil = function(nomorRegistrasi) {
        if (window.SwalHelper) {
            SwalHelper.successModal(
                'Berhasil Disimpan!',
                `Data berhasil disimpan dengan nomor registrasi:<br><strong class="text-green-600">${nomorRegistrasi}</strong>`
            );
        }
    };

    window.notifSimpanGagal = function(pesanError) {
        if (window.SwalHelper) {
            SwalHelper.modalError('Gagal Menyimpan!', pesanError);
        }
    };

    window.notifValidasiGagal = function(arrayKesalahan) {
        if (typeof arrayKesalahan === 'string') {
            arrayKesalahan = [arrayKesalahan];
        }
        if (window.SwalHelper) {
            const errorsHtml = arrayKesalahan.map(err => 
                `<li class="text-left"><i class="fas fa-times-circle text-red-500 mr-2"></i>${err}</li>`
            ).join('');
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal!',
                html: `
                    <div class="text-left">
                        <p class="mb-3">${arrayKesalahan.length} kesalahan ditemukan:</p>
                        <ul class="list-disc pl-5 text-sm">${errorsHtml}</ul>
                    </div>
                `,
                confirmButtonText: 'OK',
                confirmButtonColor: '#ef4444'
            });
        }
    };

    window.notifFormBelumLengkap = function() {
        if (window.SwalHelper) {
            SwalHelper.warning('Form Belum Lengkap!', 'Pastikan semua field wajib terisi.');
        }
    };

    window.notifUploadProses = async function(namaFile, onSuccess, onError) {
        if (window.SwalHelper) {
            SwalHelper.loading('Mengunggah ' + namaFile + '...');
            try {
                await onSuccess();
                SwalHelper.success('File berhasil diunggah!');
            } catch (error) {
                SwalHelper.error(error.message || 'Upload gagal');
                if (onError) onError();
            }
        }
    };

    window.notifPengajuanProses = function(jenisDokumen, onSelesai, onTambah) {
        if (window.SwalHelper) {
            SwalHelper.loading('Memproses pengajuan...');
            //模拟成功
            setTimeout(() => {
                const now = new Date();
                const year = now.getFullYear();
                const randomNum = Math.floor(Math.random() * 999999).toString().padStart(6, '0');
                const nomorRegistrasi = `#REG-${year}-${randomNum}`;
                
                Swal.fire({
                    icon: 'success',
                    title: 'Pengajuan Berhasil!',
                    html: `
                        <div class="text-center">
                            <p class="mb-3">Pengajuan ${jenisDokumen} berhasil diajukan</p>
                            <div class="bg-green-100 rounded-lg p-4 inline-block">
                                <p class="text-xs text-green-700 font-semibold">NOMOR REGISTRASI</p>
                                <p class="text-2xl font-bold text-green-600 font-mono">${nomorRegistrasi}</p>
                            </div>
                        </div>
                    `,
                    confirmButtonText: '<i class="fas fa-check mr-2"></i> Selesai',
                    cancelButtonText: '<i class="fas fa-plus mr-2"></i> Tambah Lagi',
                    showCancelButton: true,
                    confirmButtonColor: '#22c55e'
                }).then((result) => {
                    if (result.isConfirmed && onSelesai) onSelesai();
                    else if (result.isDismissed && onTambah) onTambah();
                });
            }, 1500);
        }
    };

    window.notifPengajuanDitolak = function(alasan) {
        if (window.SwalHelper) {
            Swal.fire({
                icon: 'warning',
                title: 'Pengajuan Ditolak!',
                html: `
                    <div class="text-left">
                        <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 mb-4">
                            <p class="font-semibold text-orange-800 mb-2"><i class="fas fa-exclamation-triangle mr-2"></i>Alasan:</p>
                            <p class="text-orange-900">${alasan}</p>
                        </div>
                    </div>
                `,
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#f59e0b'
            });
        }
    };

    window.notifKonfirmasiHapus = function(namaPenduduk, onHapus) {
        if (window.SwalHelper) {
            SwalHelper.deleteConfirm(
                'Konfirmasi Hapus',
                `Hapus data: <strong>${namaPenduduk}</strong>?`,
                onHapus
            );
        }
    };

    window.notifNomorAntrian = function(nomorAntrian, jenisLayanan, estimasiWaktu) {
        if (window.SwalHelper) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'info',
                title: 'Nomor Antrian',
                html: `
                    <div class="text-center py-2">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl px-6 py-4 mb-3">
                            <p class="text-xs text-blue-100">NOMOR ANTRIAN</p>
                            <p class="text-4xl font-bold text-white font-mono">${nomorAntrian}</p>
                        </div>
                        <div class="flex justify-center gap-6 text-sm">
                            <div><span class="text-gray-500">Layanan:</span> <span class="font-semibold text-blue-600">${jenisLayanan}</span></div>
                            <div><span class="text-gray-500">Estimasi:</span> <span class="font-semibold text-orange-600">${estimasiWaktu}</span></div>
                        </div>
                    </div>
                `,
                showConfirmButton: false,
                timer: 8000,
                timerProgressBar: true
            });
        }
    };

    window.notifCariBerhasil = function(jumlahHasil, keyword) {
        if (window.SwalHelper) {
            SwalHelper.success(`${jumlahHasil} data ditemukan untuk "${keyword}"`);
        }
    };

    window.notifCariKosong = function(keyword) {
        if (window.SwalHelper) {
            SwalHelper.warning(`Tidak ada data untuk "${keyword}"`);
        }
    };

    window.notifKonfirmasi = function(pesan, onSetuju, onBatal) {
        if (window.SwalHelper) {
            SwalHelper.confirm('Konfirmasi', pesan, onSetuju);
        }
    };

    window.notifDisetujui = function(namaPemohon) {
        if (window.SwalHelper) {
            SwalHelper.success(`Pengajuan ${namaPemohon} telah disetujui!`);
        }
    };

    window.notifLoading = function(pesan) {
        if (window.SwalHelper) {
            SwalHelper.loading(pesan);
        } else {
            Swal.fire({
                title: pesan || 'Memproses...',
                html: '<i class="fas fa-circle-notch fa-spin text-3xl text-green-500"></i>',
                showConfirmButton: false,
                allowOutsideClick: false
            });
        }
    };

    window.notifToast = function(icon, judul, pesan, durasi) {
        if (window.SwalHelper) {
            const icons = {
                success: 'success',
                error: 'error',
                warning: 'warning',
                info: 'info'
            };
            const method = icons[icon] || 'info';
            SwalHelper[method](`${judul}: ${pesan}`);
        } else {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: icon,
                title: judul,
                text: pesan,
                timer: durasi || 4000,
                showConfirmButton: false
            });
        }
    };

})(window);
