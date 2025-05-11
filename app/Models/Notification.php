<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'content', 'is_read'];

    public $timestamps = ['created_at'];
    const UPDATED_AT = null;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
