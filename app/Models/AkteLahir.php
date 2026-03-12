<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AkteLahir extends Model
{
    protected $name = 'aktelahir';
    protected $fillable = [
    'layanan_id',
    'nomor_registrasi',
    'nama',
    'alamat',
    'fotokopi_buku_nikah',
    'surat_bidan',
    'ktp_orangtua',
    'fotokopi_kk',
    'identitas_saksi'
    ];
}
