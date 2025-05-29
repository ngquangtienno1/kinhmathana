<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'question',
        'answer',
        'category',
        'images',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'images' => 'array',
        'is_active' => 'boolean'
    ];
}
