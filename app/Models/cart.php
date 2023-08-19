<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class cart extends Model
{
    use HasFactory;
    protected $fillable = [
      
        'user_id',
        'buyer_id',
        'quantity',
        'price'

    ];
    public function buyer(){
        return $this->belongsTo(User::class,'buyer_id');
    }

    public function seller(){
        return $this->belongsTo(User::class,'user_id');
    }
}
