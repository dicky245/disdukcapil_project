<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AkteLahir extends Model
{
    protected $table = 'aktelahirs';
    protected $fillable = [
    'uuid',
    'layanan_id',
    'nomor_registrasi',
    'nama_pelapor',
    'nik_pelapor',
    'nomor_dokumen',
    'nomor_kk',
    'kewarganegaraan_pelapor',
    'nama_saksi1',
    'nik_saksi1',
    'nomor_kk_saksi1',
    'kewarganegaraan_saksi1',
    'nama_saksi2',
    'nik_saksi2',
    'nomor_kk_saksi2',
    'kewarganegaraan_saksi2',
    'nama_ayah',
    'nik_ayah',
    'tempat_lahir_ayah',
    'tanggal_lahir_ayah',
    'kewarganegaraan_ayah',
    'nama_ibu',
    'nik_ibu',
    'tempat_lahir_ibu',
    'tanggal_lahir_ibu',
    'kewarganegaraan_ibu',
    'nama_anak',
    'jenis_kelamin',
    'tempat_dilahirkan',
    'tempat_kelahiran',
    'hari_tanggal_lahir',
    'pukul',
    'jenis_kelahiran',
    'kelahiran_ke',
    'penolong',
    'berat_bayi',
    'panjang_bayi',
    'file_surat_lahir',
    'file_buku_nikah',
    'file_kk',
    'file_sptjm_kelahiran',
    'file_sptjm_pasutri',
    'file_berita_acara_polisi',
    'alasan_penolakan',
    'status',
    'deleted_at',
    'created_at',
    'update_at'
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
