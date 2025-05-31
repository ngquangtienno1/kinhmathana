<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['product_id', 'sku', 'price', 'sale_price', 'stock_quantity', 'status', 'color_id', 'size_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function images()
    {
        return $this->hasMany(VariationImage::class, 'variation_id'); 
    }
}
