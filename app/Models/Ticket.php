<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    //
    use SoftDeletes;

     protected $fillable = [
        'title', 'description', 'status', 'priority', 'user_id', 'assigned_to'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    public function notes()
{
    return $this->hasMany(TicketNote::class);
}
}
