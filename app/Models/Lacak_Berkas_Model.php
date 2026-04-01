<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Lacak_Berkas_Model extends Model
{
    use HasFactory;

    protected $table = 'lacak_berkas';
    protected $primaryKey = 'lacak_berkas_id';
    public $timestamps = true;

    protected $fillable = [
        'antrian_online_id',
        'status',
        'tanggal',
        'keterangan',
        'alasan_penolakan',
        'detail_form',
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
            if (empty($model->lacak_berkas_id)) {
                $model->lacak_berkas_id = (string) Str::uuid();
            }
        });
    }

    /**
     * Relasi ke antrian online
     */
    public function antrian_online(): BelongsTo
    {
        return $this->belongsTo(Antrian_Online_Model::class, 'antrian_online_id', 'antrian_online_id');
    }
}
