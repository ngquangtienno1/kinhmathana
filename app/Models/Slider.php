<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'image_id', 'link', 'sort_order', 'is_active'
    ];

    public $timestamps = false;

    public function image()
    {
        return $this->belongsTo(UploadFile::class, 'image_id');
    }
}
