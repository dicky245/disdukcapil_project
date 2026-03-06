<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    ];

    /**
     * Relasi ke antrian online
     */
    public function antrian_online(): BelongsTo
    {
        return $this->belongsTo(Antrian_Online_Model::class, 'antrian_online_id', 'antrian_online_id');
    }
}
