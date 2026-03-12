<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'username',
        'password',
<<<<<<< Updated upstream
=======
        'security_question_id',
        'security_question_answer',
>>>>>>> Stashed changes
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'security_question_answer',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function username(): string
    {
        return 'username';
    }
    public function detail_keagamaan()
    {
        // User memiliki satu record di tabel keagamaan
        return $this->hasOne(Keagamaan_Model::class, 'user_id', 'id');
    }
<<<<<<< Updated upstream
=======

    /**
     * Relasi dengan SecurityQuestion
     */
    public function securityQuestion()
    {
        return $this->belongsTo(SecurityQuestion::class);
    }
>>>>>>> Stashed changes
}
