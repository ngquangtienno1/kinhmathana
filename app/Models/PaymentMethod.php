<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'description',
        'logo',
        'api_key',
        'api_secret',
        'api_endpoint',
        'api_settings',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'api_settings' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    public $timestamps = true;
    protected $dates = ['deleted_at'];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Scope để lấy các phương thức thanh toán đang hoạt động
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope để sắp xếp theo thứ tự
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }
}
