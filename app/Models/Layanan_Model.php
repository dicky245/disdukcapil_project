<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Layanan_Model extends Model
{
    use HasFactory;

    protected $table = 'layanan';
    protected $primaryKey = 'layanan_id';
    public $timestamps = true;

    protected $fillable = [
        'nama_layanan',
    ];

    /**
     * Relasi ke antrian online
     */
    public function antrian_online(): HasMany
    {
        return $this->hasMany(Antrian_Online_Model::class, 'layanan_id', 'layanan_id');
    }
}
