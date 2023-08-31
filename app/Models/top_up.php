<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class top_up extends Model
{
    use HasFactory;
    public $fillable = ['username', 'point_top_up', 'payment_method', 'status'];
}
