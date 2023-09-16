<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rating extends Model
{
    protected $fillable = [
        'rating',
        'buyer_id',
        'seller_id',
        'comment',
        'transaction_id'

    ];
    use HasFactory;

  
}
