<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VariationDetail extends Model
{
    use HasFactory;

    protected $fillable = ['variation_id', 'color_id', 'size_id'];

    public $timestamps = ['created_at'];
    const UPDATED_AT = null;

    public function variation()
    {
        return $this->belongsTo(Variation::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }
}
