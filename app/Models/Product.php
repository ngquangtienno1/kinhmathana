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

    // Scope để lấy sản phẩm hoạt động
    public function scopeActive($query)
    {
        return $query->where('status', 'Hoạt động');
    }
    public function getMinimumPriceAttribute()
    {
        if ($this->product_type === 'variable') {
            $prices = $this->variations->pluck('sale_price')->filter();
            $regularPrices = $this->variations->pluck('price')->filter();
            return $prices->min() ?? $regularPrices->min() ?? 0;
        }
        return $this->sale_price ?? $this->price ?? 0;
    }


    public function getTotalStockQuantityAttribute()
    {
        return $this->variations->sum('stock_quantity') ?? $this->stock_quantity ?? 0;
    }

    public function getFeaturedMedia()
    {
        $featured = $this->images()->where('is_featured', true)->first();
        \Log::info('Featured image for product ID ' . $this->id . ': ' . ($featured ? $featured->image_path : 'null'));
        if ($featured) {
            return (object) [
                'path' => $featured->image_path,
                'is_video' => $featured->is_video,
            ];
        }
        $defaultImage = $this->images()->first();
        \Log::info('Default image for product ID ' . $this->id . ': ' . ($defaultImage ? $defaultImage->image_path : 'null'));
        if ($defaultImage) {
            return (object) [
                'path' => $defaultImage->image_path,
                'is_video' => $defaultImage->is_video,
            ];
        }
        return (object) [
            'path' => 'path/to/default-image.jpg',
            'is_video' => false,
        ];
    }

    protected static function booted()
    {
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = \Illuminate\Support\Str::slug($product->name);
            }
        });
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