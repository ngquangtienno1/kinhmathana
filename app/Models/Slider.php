<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'image_url', 'link', 'sort_order', 'status'
    ];

    public $timestamps = false;
}
