<?php

namespace App\Models;

use App\Models\Otp;
use App\Models\Role;
use App\Models\Favorite;
use App\Models\Customer;
use App\Models\Order;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Send the password reset notification using custom notification.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\ClientResetPassword($token));
    }

    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'password',
        'date_birth',
        'gender',
        'status_user',
        'avatar',
        'role_id',
        'email_verified_at',
        'phone_verified_at',
    ];
    protected $casts = [
        'banned_until' => 'datetime',
        'created_at' => 'datetime',
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

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function hasPermission($permission)
    {
        if (!$this->role) {
            return false;
        }

        $hasPermission = $this->role->permissions->contains('slug', $permission);
        return $hasPermission;
    }

    public function hasAnyPermission(array $permissions)
    {
        if (!$this->role) {
            return false;
        }

        return $this->role->permissions->whereIn('slug', $permissions)->count() > 0;
    }

    public function hasAllPermissions(array $permissions)
    {
        if (!$this->role) {
            return false;
        }

        return $this->role->permissions->whereIn('slug', $permissions)->count() === count($permissions);
    }
    public function isBanned()
    {
        return $this->banned_until && $this->banned_until->isFuture();
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'from_id')->orWhere('to_id', $this->id);
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'from_id');
    }
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'to_id');
    }
}
