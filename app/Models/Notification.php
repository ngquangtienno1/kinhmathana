<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'content',
        'data',
        'is_read'
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'created_at' => 'datetime'
    ];

    public $timestamps = ['created_at'];
    const UPDATED_AT = null;

    // Notification types
    const TYPE_ORDER_NEW = 'order_new';
    const TYPE_ORDER_STATUS = 'order_status';
    const TYPE_STOCK_ALERT = 'stock_alert';
    const TYPE_PROMOTION = 'promotion';
    const TYPE_ORDER_CANCELLED = 'order_cancelled';
    const TYPE_MONTHLY_REPORT = 'monthly_report';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }

    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
