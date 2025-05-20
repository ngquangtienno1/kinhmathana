<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VariationImage extends Model
{
    use HasFactory;

    protected $fillable = ['variation_id', 'image_path'];

    public $timestamps = true; // bảng có created_at

    public function variation()
    {
        return $this->belongsTo(Variation::class);
    }
}