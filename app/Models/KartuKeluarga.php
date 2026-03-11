<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KartuKeluarga extends Model
{
    protected $table = 'kk';
    protected $fillable =[
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
        'deleted_at',
        'created_at',
        'update_at'
    ];
}
