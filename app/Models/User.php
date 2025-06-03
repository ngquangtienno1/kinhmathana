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
        'phone_verified_at'
    ];
    protected $casts = [
        'banned_until' => 'datetime',
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

    public function hasPermission($permission)
    {
        if (!$this->role) {
            Log::info('User has no role', ['user_id' => $this->id]);
            return false;
        }

        $hasPermission = $this->role->permissions->contains('slug', $permission);
        Log::info('Checking permission', [
            'user_id' => $this->id,
            'role_id' => $this->role_id,
            'permission' => $permission,
            'has_permission' => $hasPermission,
            'user_permissions' => $this->role->permissions->pluck('slug')
        ]);

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
}