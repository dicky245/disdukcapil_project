<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GantiKepalaKK extends Model
{
    protected $table = 'ganti_kepala_kk';
    protected $fillable =[
        'uuid',
        'layanan_id',
        'nomor_registrasi',
        'nama',
        'alamat',
        'nik',
        'formulir_f102',
        'fotokopi_akta_kematian',
        'kk_lama',
        'surat_pernyataan_wali',
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
