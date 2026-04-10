<?php

namespace App\Models;

use App\Traits\HasEncryptedNIK;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class AkteKematian extends Model
{
    use SoftDeletes, HasEncryptedNIK;

    protected $table = 'akte_kematian';

    protected $fillable = [
        'uuid',
        'layanan_id',
        'antrian_online_id',
        'nomor_registrasi',
        'nama_almarhum',
        'nik_almarhum',
        'tgl_meninggal',
        'tempat_meninggal',
        'sebab_meninggal',
        'yang_menerangkan',
        'nik_pelapor',
        'nomor_kk_pelapor',
        'nama_pelapor',
        'hubungan_pelapor',
        'nik_saksi_1',
        'nama_saksi_1',
        'nik_saksi_2',
        'nama_saksi_2',
        'surat_keterangan_kematian',
        'ktp_almarhum',
        'kartu_keluarga',
        'dokumen_perjalanan',
        'status',
        'alasan_penolakan',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    /**
     * Tentukan field NIK yang akan dienkripsi secara otomatis
     */
    public function getNikFields(): array
    {
        return [
            'nik_almarhum',
            'nik_pelapor',
            'nik_saksi_1',
            'nik_saksi_2',
        ];
    }

    /**
     * Boot function untuk menangani pembuatan UUID secara otomatis
     */
    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            // Kita mengisi kolom 'uuid', bukan kolom 'id'
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Relasi ke Master Layanan
     */
    public function layanan()
    {
        return $this->belongsTo(Layanan_Model::class, 'layanan_id', 'layanan_id');
    }

    /**
     * Relasi ke Antrian Online
     */
    public function antrian_online()
    {
        return $this->belongsTo(Antrian_Online_Model::class, 'antrian_online_id', 'antrian_online_id');
    }
}