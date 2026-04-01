<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Antrian_Online_Model extends Model
{
    use HasFactory;

    protected $table = 'antrian_online';
    protected $primaryKey = 'antrian_online_id';

    public $incrementing = true; // ✅ auto increment
    protected $keyType = 'int';  // ✅ integer

    protected $fillable = [
        'antrian_online_id',
        'nomor_antrian',
        'nama_lengkap',
        'alamat',
        'tanggal_lahir',
        'layanan_id',
        'status_antrian',
    ];

    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan_Model::class, 'layanan_id', 'layanan_id');
    }

    public function lacak_berkas(): HasMany
    {
        return $this->hasMany(Lacak_Berkas_Model::class, 'antrian_online_id', 'antrian_online_id');
    }
}