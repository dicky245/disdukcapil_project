<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * Antrian_Online_Model - Model untuk tabel antrian_online
 * 
 * Alias/backward compatibility untuk AntrianOnline
 * Menggunakan tabel yang sama: antrian_online
 */
class Antrian_Online_Model extends Model
{
    use HasFactory;

    protected $table = 'antrian_online';

    protected $primaryKey = 'antrian_online_id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;

    protected $fillable = [
        'antrian_online_id',
        'nomor_antrian',
        'nik',
        'nama_lengkap',
        'alamat',
        'layanan_id',
        'status_antrian',
        'file_ktp_path',
        'ocr_raw_text',
        'ocr_confidence',
        'ocr_field_confidence',
        'ocr_processed_at',
    ];

    protected $casts = [
        'status_antrian' => 'string',
        'ocr_confidence' => 'decimal:4',
        'ocr_field_confidence' => 'array',
        'ocr_processed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Status constants
    public const STATUS_MENUNGGU = 'Menunggu';
    public const STATUS_DOKUMEN_DITERIMA = 'Dokumen Diterima';
    public const STATUS_VERIFIKASI = 'Verifikasi Data';
    public const STATUS_PROSES_CETAK = 'Proses Cetak';
    public const STATUS_SIAP_PENGAMBILAN = 'Siap Pengambilan';
    public const STATUS_DITOLAK = 'Ditolak';
    public const STATUS_DIBATALKAN = 'Dibatalkan';

    /**
     * Boot method untuk auto-generate UUID
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    /**
     * Relasi ke tabel layanan
     */
    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan_Model::class, 'layanan_id', 'layanan_id');
    }

    /**
     * Relasi ke tabel lacak_berkas
     */
    public function lacak_berkas(): HasMany
    {
        return $this->hasMany(Lacak_Berkas_Model::class, 'antrian_online_id', 'antrian_online_id');
    }

    /**
     * Scope untuk antrian yang menunggu
     */
    public function scopeMenunggu($query)
    {
        return $query->where('status_antrian', self::STATUS_MENUNGGU);
    }

    /**
     * Scope untuk antrian hari ini
     */
    public function scopeHariIni($query)
    {
        return $query->whereDate('created_at', now()->toDateString());
    }

    /**
     * Scope untuk pencarian berdasarkan nomor antrian
     */
    public function scopeCariNomor($query, string $nomor)
    {
        $nomor = strtoupper(trim($nomor));
        $nomorClean = str_replace('-', '', $nomor);
        
        return $query->where(function($q) use ($nomor, $nomorClean) {
            $q->where('nomor_antrian', $nomor)
              ->orWhere('nomor_antrian', 'like', $nomor . '%')
              ->orWhereRaw("REPLACE(UPPER(nomor_antrian), '-', '') LIKE ?", [$nomorClean . '%']);
        });
    }

    /**
     * Scope untuk pencarian berdasarkan nama
     */
    public function scopeCariNama($query, string $nama)
    {
        return $query->where('nama_lengkap', 'like', '%' . trim($nama) . '%');
    }
}
