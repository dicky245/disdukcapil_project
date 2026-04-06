<?php

namespace App\Traits;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

/**
 * Trait untuk handle encryption dan decryption NIK
 *
 * Penggunaan:
 * 1. Tambah trait ini ke Model
 * 2. Tambah field NIK ke $fillable
 * 3. Gunakan accessor/mutator yang sudah disediakan
 *
 * @package App\Traits
 */
trait HasEncryptedNIK
{
    /**
     * Boot trait untuk menambahkan event listeners
     */
    protected static function bootHasEncryptedNIK()
    {
        // Encrypt NIK sebelum disimpan
        static::saving(function ($model) {
            $model->encryptNikFields();
        });

        // Decrypt NIK setelah diambil dari database
        static::retrieved(function ($model) {
            $model->decryptNikFields();
        });
    }

    /**
     * Daftar field NIK yang akan di-encrypt
     * Override di model untuk menyesuaikan
     *
     * @return array
     */
    public function getNikFields(): array
    {
        return [
            'nik',
            'nik_suami',
            'nik_istri',
            'nik_almarhum',
            'nik_pelapor',
            'nik_ayah',
            'nik_ibu',
            'nik_kepala_keluarga',
            'nomor_kk',
        ];
    }

    /**
     * Encrypt semua field NIK sebelum disimpan
     *
     * @return void
     */
    protected function encryptNikFields(): void
    {
        $nikFields = $this->getNikFields();

        foreach ($nikFields as $field) {
            if (isset($this->attributes[$field]) && !empty($this->attributes[$field])) {
                try {
                    // Cek apakah sudah di-encrypt (encrypted string lebih panjang)
                    $value = $this->attributes[$field];

                    // Jangan encrypt jika sudah di-encrypt atau null
                    if ($this->isEncrypted($value)) {
                        continue;
                    }

                    // Validate NIK format (16 digit)
                    if ($this->isValidNikFormat($value)) {
                        $this->attributes[$field] = Crypt::encryptString($value);
                    } else {
                        Log::warning('Invalid NIK format detected', [
                            'model' => get_class($this),
                            'field' => $field,
                            'value' => maskNik($value),
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::error('Failed to encrypt NIK', [
                        'model' => get_class($this),
                        'field' => $field,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        }
    }

    /**
     * Decrypt semua field NIK setelah diambil dari database
     *
     * @return void
     */
    protected function decryptNikFields(): void
    {
        $nikFields = $this->getNikFields();

        foreach ($nikFields as $field) {
            if (isset($this->attributes[$field]) && !empty($this->attributes[$field])) {
                try {
                    $value = $this->attributes[$field];

                    // Cek apakah perlu di-decrypt
                    if ($this->isEncrypted($value)) {
                        $decrypted = Crypt::decryptString($value);
                        $this->attributes[$field] = $decrypted;
                    }
                } catch (\Exception $e) {
                    Log::error('Failed to decrypt NIK', [
                        'model' => get_class($this),
                        'field' => $field,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        }
    }

    /**
     * Cek apakah value sudah di-encrypt
     *
     * @param string $value
     * @return bool
     */
    protected function isEncrypted(string $value): bool
    {
        // Encrypted string dari Laravel Crypt biasanya lebih panjang dan mengandung karakter khusus
        return strlen($value) > 20 || preg_match('/[^0-9]/', $value);
    }

    /**
     * Validasi format NIK Indonesia (16 digit)
     *
     * @param string $nik
     * @return bool
     */
    protected function isValidNikFormat(string $nik): bool
    {
        // NIK harus 16 digit angka
        return preg_match('/^[0-9]{16}$/', $nik) === 1;
    }

    /**
     * Ambil NIK yang sudah di-decrypt (safe untuk ditampilkan)
     *
     * @param string $field
     * @return string|null
     */
    public function getDecryptedNik(string $field): ?string
    {
        return $this->attributes[$field] ?? null;
    }

    /**
     * Mask NIK untuk logging (tampilkan sebagian saja)
     *
     * @param string $nik
     * @return string
     */
    protected function maskNik(string $nik): string
    {
        if (strlen($nik) >= 16) {
            return substr($nik, 0, 4) . '********' . substr($nik, -4);
        }
        return '****';
    }
}
