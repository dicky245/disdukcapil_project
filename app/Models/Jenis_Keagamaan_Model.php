<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jenis_Keagamaan_Model extends Model
{
    use HasFactory;

    protected $table = 'jenis_keagamaan';
    protected $primaryKey = 'jenis_keagamaan_id';
    public $timestamps = true;

    protected $fillable = [
        'nama_jenis_keagamaan',
        'keterangan',
    ];

    /**
     * Relasi ke keagamaan
     */
    public function keagamaan(): HasMany
    {
        return $this->hasMany(Keagamaan_Model::class, 'jenis_keagamaan_id', 'jenis_keagamaan_id');
    }
}
