<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Keagamaan_Model extends Model
{
    use HasFactory;

    protected $table = 'keagamaan';
    protected $primaryKey = 'keagamaan_id';
    public $timestamps = true;

    protected $fillable = [
        'jenis_keagamaan_id',
        'alamat',
        'keterangan',
    ];

    /**
     * Relasi ke jenis keagamaan
     */
    public function jenis_keagamaan(): BelongsTo
    {
        return $this->belongsTo(Jenis_Keagamaan_Model::class, 'jenis_keagamaan_id', 'jenis_keagamaan_id');
    }
}
