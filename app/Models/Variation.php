<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id', 'name', 'sku', 'price', 'import_price', 'sale_price', 'discount_price',
        'stock_quantity', 'stock_alert_threshold', 'status', 'color_id', 'size_id',
        'spherical_id', 'cylindrical_id'
    ];

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

    public function spherical()
    {
        return $this->belongsTo(Spherical::class);
    }

    public function cylindrical()
    {
        return $this->belongsTo(Cylindrical::class);
    }

    public function images()
    {
        return $this->hasMany(VariationImage::class, 'variation_id');
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }
}
