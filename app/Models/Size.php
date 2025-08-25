<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Size extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'sort_order'];

    public $timestamps = false;

    public function variations()
    {
        return $this->hasMany(Variation::class, 'size_id');
    }

    public function orderItems()
    {
        return $this->hasManyThrough(
            OrderItem::class, 
            Variation::class, 
            'size_id', // Foreign key on variations table
            'variation_id', // Foreign key on order_items table
            'id', // Local key on sizes table
            'id' // Local key on variations table
        );
    }

    public function canBeDeleted()
    {
        return $this->variations()->count() === 0;
    }
}
