<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UploadFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name', 'file_type', 'file_path', 'object_type', 'object_id'
    ];

    public $timestamps = ['created_at'];
    const UPDATED_AT = null;

    /**
     * Polymorphic relation: upload belongs to various models
     */
    public function object()
    {
        return $this->morphTo(null, 'object_type', 'object_id');
    }
}
