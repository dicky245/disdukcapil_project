<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * Kolom yang boleh diisi (mass assignment)
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'security_question_id',
        'security_question_answer',
    ];

    /**
     * Kolom yang disembunyikan
     */
    protected $hidden = [
        'password',
        'remember_token',
        'security_question_answer',
    ];

    /**
     * Casting attribute
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * Relasi ke tabel security_questions
     */
    public function securityQuestion()
    {
        return $this->belongsTo(SecurityQuestion::class);
    }

    /**
     * Relasi ke tabel keagamaan
     */
    public function detail_keagamaan()
    {
        return $this->hasOne(Keagamaan_Model::class, 'user_id', 'id');
    }

    /**
     * Override username field untuk login
     */
    public function username(): string
    {
        return 'username';
    }
}