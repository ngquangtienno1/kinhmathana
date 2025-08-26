<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cylindrical extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'sort_order'];

    protected $casts = [
        'value' => 'float',
        'sort_order' => 'integer'
    ];

    public function variations()
    {
        return $this->hasMany(Variation::class, 'cylindrical_id');
    }

    public function orderItems()
    {
        return $this->hasManyThrough(
            OrderItem::class, 
            Variation::class, 
            'cylindrical_id', // Foreign key on variations table
            'variation_id', // Foreign key on order_items table
            'id', // Local key on cylindricals table
            'id' // Local key on variations table
        );
    }

    public function getDisplayValueAttribute()
    {
        return $this->value;
    }

    public function canBeDeleted()
    {
        return $this->variations()->count() === 0;
    }
}
