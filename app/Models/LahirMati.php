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
        'layanan_id',
        'nama_bayi',
        'jenis_kelamin',
        'tgl_lahir',
        'tempat_lahir',
        'nama_ayah',
        'nik_ayah',
        'nama_ibu',
        'nik_ibu',
        'keterangan',
        'surat_keterangan_lahir_mati',
        'ktp_ayah',
        'ktp_ibu',
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
            'nik_ayah',
            'nik_ibu',
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
