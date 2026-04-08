<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KartuKeluarga extends Model
{
    protected $table = 'kk';
    protected $fillable =[
        'uuid',
        'layanan_id',
        'nomor_registrasi',
        'nama',
        'alamat',
        'kutipan_perkawinan',
        'keterangan_pindah',
        'kk_lama',
        'surat_keterangan_pengganti',
        'salinan_kepres',
        'izin_tinggal_asing',
        'alasan_penolakan',
        'status',
    ];
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->uuid) {
                $model->uuid = Str::uuid();
            }
        });
    }
}
