<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id', 'type', 'amount', 'status', 'transaction_code',
        'payment_method_id', 'note', 'verified_by', 'verified_at', 'verify_note'
    ];

    public $timestamps = ['created_at'];
    const UPDATED_AT = null;

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
