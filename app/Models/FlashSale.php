<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FlashSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'discounted_price', 'start_at', 'end_at'
    ];

    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
