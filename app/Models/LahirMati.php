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
        'nomor_antrian',
        
        // Data Pemohon (Sesuai Konsep Baru)
        'nik_pemohon',
        'nomor_kk_pemohon',
        'nama_pemohon',
        'alamat_pemohon',
        'hubungan_pemohon',
        
        // Data Berkas
        'ktp_pemohon',
        'kartu_keluarga_pemohon',
        'ktp_saksi1',
        'ktp_saksi2',
        'formulir_f201',
        'surat_keterangan_lahir_mati',
        
        'keterangan',
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
            'nik_pemohon',
            'nomor_kk_pemohon',
        ];
    }

    /**
     * Boot function untuk menangani pembuatan UUID secara otomatis
     */
    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            // Memasukkan UUID ke kolom 'uuid'
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Relasi dengan antrian online
     */
    public function antrian_online()
    {
        return $this->belongsTo(Antrian_Online_Model::class, 'antrian_online_id', 'antrian_online_id');
    }

    /**
     * Relasi dengan layanan
     */
    public function layanan()
    {
        return $this->belongsTo(Layanan_Model::class, 'layanan_id', 'layanan_id');
    }
}