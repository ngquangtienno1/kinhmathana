<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'summary',
        'content',
        'image',
        'author_id',
        'is_active',
        'published_at',
        'views'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'published_at' => 'datetime',
        'views' => 'integer'
    ];

    protected $dates = ['deleted_at'];

    public function category()
    {
        return $this->belongsTo(NewsCategory::class, 'category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', now());
    }

    /**
     * Tăng lượt xem của bài viết
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    /**
     * Lấy danh sách bài viết được xem nhiều nhất
     */
    public function scopeMostViewed($query, $limit = 5)
    {
        return $query->orderBy('views', 'desc')->limit($limit);
    }

    /**
     * Lấy danh sách bài viết mới nhất
     */
    public function scopeLatest($query, $limit = 5)
    {
        return $query->orderBy('published_at', 'desc')->limit($limit);
    }
}
