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
     * Override getNikFields untuk menentukan field NIK yang di-encrypt
     *
     * @return array
     */
    public function getNikFields(): array
    {
        return [
            'nik_almarhum',
            'nik_pelapor',
        ];
    }

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
