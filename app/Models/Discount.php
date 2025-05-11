<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'discount_percent', 'discount_amount',
        'quantity', 'start_date', 'end_date', 'is_active'
    ];

    public $timestamps = false;

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
