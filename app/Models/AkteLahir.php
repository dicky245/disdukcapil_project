<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AkteLahir extends Model
{
    protected $table = 'akte_lahir';

    protected $fillable = [
        'layanan_id',
        'nomor_registrasi',
        'nama',
        'alamat',
        'fotokopi_buku_nikah',
        'surat_bidan',
        'ktp_orangtua',
        'fotokopi_kk',
        'identitas_saksi',
        'status',
    ];

    protected $hidden = [
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
