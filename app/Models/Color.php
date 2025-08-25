<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Color extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'hex_code', 'image_url', 'sort_order'];

    public $timestamps = false;

    public function variations()
    {
        return $this->hasMany(Variation::class, 'color_id');
    }

    public function orderItems()
    {
        return $this->hasManyThrough(
            OrderItem::class,
            Variation::class,
            'color_id',
            'variation_id',
            'id',
            'id'
        );
    }

    public function canBeDeleted()
    {
        return $this->variations()->count() === 0;
    }
}