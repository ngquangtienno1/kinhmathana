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
        'name',
        'description_short',
        'description_long',
        'product_type',
        'sku',
        'stock_quantity',
        'price',
        'sale_price',
        'slug',
        'brand_id',
        'status',
        'is_featured',
        'views',
        'video_path',
    ];

    protected $appends = ['total_stock_quantity'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
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

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'entity_id')->where('entity_type', 'product');
    }

    public function getTotalStockQuantityAttribute()
    {
        return $this->variations->sum('stock_quantity') ?? $this->stock_quantity ?? 0;
    }

    public function getFeaturedMedia()
    {
        $featured = $this->images()->where('is_featured', true)->first();
        if ($featured) {
            return (object) [
                'path' => Storage::url($featured->image_path),
                'is_video' => $featured->is_video,
            ];
        }
        return null;
    }

    protected static function booted()
    {
        static::deleting(function ($product) {
            if ($product->isForceDeleting()) {
                foreach ($product->images as $image) {
                    if (Storage::disk('public')->exists($image->path)) {
                        Storage::disk('public')->delete($image->path);
                    }
                }
                foreach ($product->variations as $variation) {
                    foreach ($variation->images as $image) {
                        if (Storage::disk('public')->exists($image->image_path)) {
                            Storage::disk('public')->delete($image->image_path);
                        }
                    }
                }
            }
        });
    }
}
