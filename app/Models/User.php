<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'username',
        'password',
        'security_question_id',
        'security_question_answer',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'security_question_answer',
    ];

    protected $casts = [
        'password' => 'hashed',
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
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
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

    public function securityQuestion()
    {
        return $this->belongsTo(SecurityQuestion::class);
    }
}
