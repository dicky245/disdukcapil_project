<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KKHilangRusak extends Model
{
    protected $table = 'kk_hilang_rusak';
    protected $fillable =[
        'uuid',
        'layanan_id',
        'nomor_registrasi',
        'nama',
        'alamat',
        'nik',
        'fotokopi_ktp',
        'fotokopi_izin_tinggal',
        'suket_hilang_rusak',
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
