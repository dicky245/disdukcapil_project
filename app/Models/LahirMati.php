<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LahirMati extends Model
{
    use SoftDeletes;

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
}
