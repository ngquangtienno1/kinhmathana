<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'password',
        'date_birth',
        'gender',
        'status_user',
        'avatar_id',
        'role',
        'email_verified_at',
        'phone_verified_at'
    ];

    protected $hidden = ['password', 'remember_token'];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'date_birth' => 'date',
            'password' => 'hashed',
        ];
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function otps()
    {
        return $this->hasMany(Otp::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}