<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public $timestamps = ['created_at'];
    const UPDATED_AT = null;

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
