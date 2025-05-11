<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AiMessage extends Model
{
    use HasFactory;

    protected $fillable = ['chat_id', 'sender', 'message', 'is_feedback'];

    public $timestamps = ['created_at'];
    const UPDATED_AT = null;

    public function chat()
    {
        return $this->belongsTo(AiChat::class, 'chat_id');
    }
}
