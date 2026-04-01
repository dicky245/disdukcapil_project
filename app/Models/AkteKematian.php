<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class AkteKematian extends Model
{
    use SoftDeletes;

    protected $table = 'akte_kematian';

    protected $fillable = [
        'layanan_id',
        'nama_almarhum',
        'nik_almarhum',
        'tgl_meninggal',
        'tempat_meninggal',
        'sebab_meninggal',
        'nik_pelapor',
        'nama_pelapor',
        'hubungan_pelapor',
        'surat_keterangan_kematian',
        'ktp_almarhum',
        'kartu_keluarga',
        'status',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Boot function from Laravel.
     */
    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }
}
