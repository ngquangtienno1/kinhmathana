<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactMessage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'status',
        'note',
        'is_spam',
        'ip_address',
        'user_agent',
        'reply_at',
        'replied_by'
    ];

    protected $casts = [
        'is_spam' => 'boolean',
        'reply_at' => 'datetime',
    ];
    protected $dates = ['deleted_at'];

    public function replier()
    {
        return $this->belongsTo(User::class, 'replied_by');
    }
}