<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactSupport extends Model
{
    use HasFactory;

    protected $fillable = ['full_name', 'phone', 'email', 'content', 'status'];

    public $timestamps = ['created_at'];
    const UPDATED_AT = null;
}
