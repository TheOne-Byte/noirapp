<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderValidation extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_id',
        'seller_id',
        'price',
        'quantity',
        'total_price',
        'status',
    ];

    // Relationship dengan User (pembeli)
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    // Relationship dengan User (penjual)
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
