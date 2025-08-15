<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
class WebsiteSetting extends Model
{
    use HasFactory;
    protected $table = 'website_settings'; // ⚠️ Quan trọng

    protected $guarded = [];

    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('website_settings');
        });

        static::deleted(function () {
            Cache::forget('website_settings');
        });
    }
    protected $fillable = [
        'website_name',
        'logo_url',
        'contact_email',
        'hotline',
        'address',
        'facebook_url',
        'instagram_url',
        'default_shipping_fee',
        'shipping_providers',
        'shipping_fee_by_province',
        'smtp_host',
        'smtp_port',
        'smtp_username',
        'smtp_password',
        'smtp_encryption',
        'mail_from_address',
        'mail_from_name',
        'enable_ai_recommendation',
        'ai_api_key',
        'ai_api_endpoint',
        'ai_settings',
        'ai_chat_enabled',
        'ai_guest_limit',
        'ai_user_limit'
    ];

    protected $casts = [
        'shipping_providers' => 'array',
        'shipping_fee_by_province' => 'array',
        'ai_settings' => 'array',
        'default_shipping_fee' => 'decimal:2',
        'enable_ai_recommendation' => 'boolean',
        'ai_chat_enabled' => 'boolean'
    ];

    public $timestamps = false;
}
