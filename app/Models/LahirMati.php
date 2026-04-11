<?php

namespace App\Models;

use App\Traits\HasEncryptedNIK;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class LahirMati extends Model
{
    use SoftDeletes, HasEncryptedNIK;

    protected $table = 'lahir_mati';

    protected $fillable = [
        'uuid',
        'layanan_id',
        'antrian_online_id',
        'nomor_registrasi',
        'nik_pelapor',
        'nama_pelapor',
        'hubungan_pelapor',
        'nama_bayi',
        'jenis_kelamin',
        'tgl_lahir',
        'tempat_lahir',
        'lama_kandungan',
        'penolong_persalinan',
        'nama_ayah',
        'nik_ayah',
        'nama_ibu',
        'nik_ibu',
        'nik_saksi_1',
        'nama_saksi_1',
        'nik_saksi_2',
        'nama_saksi_2',
        'keterangan',
        'surat_keterangan_lahir_mati',
        'ktp_ayah',
        'ktp_ibu',
        'kk_orangtua',
        'status',
        'alasan_penolakan',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    /**
     * Override getNikFields untuk menentukan field NIK yang di-encrypt
     *
     * @return array
     */
    public function getNikFields(): array
    {
        return [
            'nik_ayah',
            'nik_ibu',
            'nik_pelapor',
            'nik_saksi_1',
            'nik_saksi_2',
        ];
    }

    // CATATAN PERBAIKAN:
    // Menghapus public $incrementing = false; dan protected $keyType = 'string';
    // Karena ID utama tabel ini adalah Angka (Auto Increment), bukan string.

    /**
     * Boot function from Laravel.
     */
    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            // CATATAN PERBAIKAN:
            // Masukkan UUID ke kolom 'uuid', BUKAN ke kolom 'id'
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Relasi dengan antrian online
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function antrian_online()
    {
        return $this->belongsTo(Antrian_Online_Model::class, 'antrian_online_id', 'antrian_online_id');
    }

    /**
     * Relasi dengan layanan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function layanan()
    {
        return $this->belongsTo(Layanan_Model::class, 'layanan_id', 'layanan_id');
    }
}