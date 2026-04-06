<?php

namespace App\Helpers;

/**
 * Helper untuk masking dan validasi NIK
 *
 * @package App\Helpers
 */
class NikHelper
{
    /**
     * Mask NIK untuk display (hanya tampilkan 4 digit pertama dan terakhir)
     *
     * @param string|null $nik
     * @param bool $showFull - jika true, tampilkan NIK lengkap (hanya untuk admin tertentu)
     * @return string
     */
    public static function mask(?string $nik, bool $showFull = false): string
    {
        if (empty($nik)) {
            return '-';
        }

        if ($showFull) {
            return $nik;
        }

        // Tampilkan 4 digit pertama dan terakhir
        if (strlen($nik) >= 16) {
            return substr($nik, 0, 4) . '********' . substr($nik, -4);
        }

        // Jika format tidak sesuai, masking semua
        return '****';
    }

    /**
     * Validasi format NIK Indonesia
     *
     * @param string $nik
     * @return bool
     */
    public static function isValid(string $nik): bool
    {
        // NIK harus 16 digit angka
        return preg_match('/^[0-9]{16}$/', $nik) === 1;
    }

    /**
     * Format NIK dengan spasi untuk readability
     *
     * @param string $nik
     * @return string
     */
    public static function format(string $nik): string
    {
        if (strlen($nik) !== 16) {
            return $nik;
        }

        // Format: 1234 5678 9012 3456
        return wordwrap($nik, 4, ' ', true);
    }

    /**
     * Generate fake NIK untuk testing (JANGAN digunakan di production)
     *
     * @param string $provinsi - kode provinsi (2 digit)
     * @param string $kabupaten - kode kabupaten (2 digit)
     * @param string $kecamatan - kode kecamatan (2 digit)
     * @param bool $gender - true untuk laki-laki, false untuk perempuan
     * @return string
     */
    public static function generateFake(
        string $provinsi = '12',
        string $kabupaten = '01',
        string $kecamatan = '01',
        bool $gender = true
    ): string {
        // Kode wilayah: 6 digit
        $kodeWilayah = $provinsi . $kabupaten . $kecamatan;

        // Nomor urut: 4 digit (ganjil untuk laki-laki, genap untuk perempuan)
        $nomorUrut = mt_rand(1, 9999);
        if ($gender) {
            if ($nomorUrut % 2 === 0) {
                $nomorUrut++; // Pastikan ganjil
            }
        } else {
            if ($nomorUrut % 2 !== 0) {
                $nomorUrut++; // Pastikan genap
            }
        }

        // Tanggal lahir: 6 digit (DDMMYY)
        $tanggal = str_pad(mt_rand(1, 31), 2, '0', STR_PAD_LEFT);
        $bulan = str_pad(mt_rand(1, 12), 2, '0', STR_PAD_LEFT);
        $tahun = str_pad(mt_rand(0, 99), 2, '0', STR_PAD_LEFT);

        return $kodeWilayah . $tanggal . $bulan . $tahun . str_pad($nomorUrut, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Cek apakah NIK sudah di-encrypt
     *
     * @param string $nik
     * @return bool
     */
    public static function isEncrypted(string $nik): bool
    {
        // Encrypted string biasanya lebih panjang dari 16 digit
        return strlen($nik) > 20 || preg_match('/[^0-9]/', $nik);
    }
}
