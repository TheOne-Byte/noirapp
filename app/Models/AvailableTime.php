<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailableTime extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'day', 'start_time', 'end_time'];

    // Relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
