<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'image_id'];

    public $timestamps = ['created_at'];
    const UPDATED_AT = null;

    public function image()
    {
        return $this->belongsTo(UploadFile::class, 'image_id');
    }
}
