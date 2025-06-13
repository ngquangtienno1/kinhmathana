<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'variation_id',
        'type',
        'quantity',
        'reference',
        'order_id',
        'import_document_id',
        'note',
        'status',
        'user_id',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variation()
    {
        return $this->belongsTo(Variation::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function importDocument()
    {
        return $this->belongsTo(ImportDocument::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
