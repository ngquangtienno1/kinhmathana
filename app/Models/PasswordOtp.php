<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordOtp extends Model
{
    protected $fillable = [
        'user_id', 'email', 'otp_code', 'expires_at', 'used'
    ];
    protected $casts = [
        'expires_at' => 'datetime',
        'used' => 'boolean',
    ];
}
