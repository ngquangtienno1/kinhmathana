<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderStatusLog extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'old_status', 'new_status', 'changed_at'];

    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
