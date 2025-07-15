<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'entity_type', 'entity_id', 'content', 'status', 'is_hidden',];

    public $timestamps = ['created_at'];
    const UPDATED_AT = null;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'entity_id');
    }

    public function news()
    {
        return $this->belongsTo(News::class, 'entity_id');
    }
    public function entity()
    {
        return $this->morphTo('entity', [Product::class, News::class]);
    }
}
