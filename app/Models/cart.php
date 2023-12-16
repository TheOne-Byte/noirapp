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
        'price',
        'schedule_id',
        'timer_expiry'

    ];
    public function buyer(){
        return $this->belongsTo(User::class,'buyer_id');
    }

    public function seller(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function schedule(){ // Tambahkan relasi dengan Schedule
        return $this->belongsTo(Schedule::class,'schedule_id');
    }
}
