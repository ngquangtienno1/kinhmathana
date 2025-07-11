<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'variation_id', 'product_id', 'quantity'];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function variation()
    {
        return $this->belongsTo(Variation::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
