<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Spherical extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'sort_order'];


    protected $casts = [
        'value' => 'float',
        'sort_order' => 'integer'
    ];

    public function getDisplayValueAttribute()
    {
        return $this->value;
    }
}