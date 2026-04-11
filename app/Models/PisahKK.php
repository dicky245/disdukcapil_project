<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PisahKK extends Model
{
    protected $table = 'pisah_kk';
    protected $fillable =[
        'uuid',
        'layanan_id',
        'nomor_registrasi',
        'nama',
        'alamat',
        'nik',
        'formulir_f102',
        'fotokopi_buku_nikah',
        'kk_lama',
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
