<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecurityQuestion extends Model
{
    protected $fillable = [
        'question',
    ];

    /**
     * Relasi dengan User
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
