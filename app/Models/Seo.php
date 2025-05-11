<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seo extends Model
{
    use HasFactory;

    protected $fillable = [
        'entity_type', 'entity_id', 'meta_title', 'meta_description', 'meta_keywords'
    ];

    public $timestamps = false;
}
