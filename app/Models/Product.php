<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'description_short', 'description_long', 'price',
        'import_price', 'sale_price', 'discount_price',
        'category_id', 'brand_id', 'status', 'is_featured', 'views'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function variations()
    {
        return $this->hasMany(Variation::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags');
    }
    protected static function booted()
    {
        static::deleting(function ($product) {
            if ($product->isForceDeleting()) {
                foreach ($product->images as $image) {
                    if (Storage::disk('public')->exists($image->image_path)) {
                        Storage::disk('public')->delete($image->image_path);
                    }
                }
            }
        });
    }
}
