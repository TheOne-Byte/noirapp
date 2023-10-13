<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'slug',
        'buyer_id',
        'seller_id',
        'schedule_id',
        'price',
        'status'
    ];

    // Definisikan relasi dengan model User jika diperlukan
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
    public function schedule(){
        return $this->belongsTo(Schedule::class,'schedule_id');
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
