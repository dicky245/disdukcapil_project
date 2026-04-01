<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AkteLahir extends Model
{
    protected $table = 'aktelahirs';
    protected $fillable = [
    'uuid',
    'layanan_id',
    'nomor_registrasi',
    'nama',
    'alamat',
    'fotokopi_buku_nikah',
    'surat_bidan',
    'ktp_orangtua',
    'fotokopi_kk',
    'identitas_saksi',
    'alasan_penolakan',
    'status',
    'deleted_at',
    'created_at',
    'update_at'
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
