<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class KartuKeluarga extends Model
{
    use SoftDeletes;

    protected $table = 'kk';

    protected $fillable = [
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
        'status',
    ];

    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at',
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