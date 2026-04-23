<?php

namespace App\Models;

use App\Traits\EncryptsSensitiveData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Antrian_Online_Model extends Model
{
    use EncryptsSensitiveData, HasFactory;

    protected $table = 'antrian_online';

    protected $primaryKey = 'antrian_online_id';

    public $timestamps = true;

    protected $fillable = [
        'antrian_online_id',
        'nomor_antrian',
        'nama_lengkap',
        'nik',
        'foto_ktp',
        'foto_selfie',
        'alamat',
        'tanggal_lahir',
        'layanan_id',
        'status_antrian',
    ];

    /**
     * Daftar sensitive fields yang akan di-encrypt
     */
    public function getSensitiveFields(): array
    {
        return [
            'nik',
            'foto_ktp',
            'foto_selfie',
        ];
    }

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The "type" of auto-incrementing ID.
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
            if (empty($model->antrian_online_id)) {
                $model->antrian_online_id = (string) Str::uuid();
            }
        });

        static::bootEncryptsSensitiveData();
    }

    /**
     * Relasi ke layanan
     */
    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan_Model::class, 'layanan_id', 'layanan_id');
    }

    /**
     * Relasi ke lacak berkas
     */
    public function lacak_berkas(): HasMany
    {
        return $this->hasMany(Lacak_Berkas_Model::class, 'antrian_online_id', 'antrian_online_id');
    }
}