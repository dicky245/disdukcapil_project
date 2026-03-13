<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
