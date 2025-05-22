<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id', 'name', 'sku', 'price', 'import_price',
        'sale_price', 'discount_price', 'stock_quantity'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variationDetails()
    {
        return $this->hasMany(VariationDetail::class);
    }

    public function images()
    {
        return $this->hasMany(VariationImage::class);
    }
}
