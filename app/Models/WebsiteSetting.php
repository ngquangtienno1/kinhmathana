<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebsiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'website_name', 'logo_id', 'contact_email', 'hotline',
        'address', 'facebook_url', 'instagram_url'
    ];

    public $timestamps = false;

    public function logo()
    {
        return $this->belongsTo(UploadFile::class, 'logo_id');
    }
}
