<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditDisplayed extends Model
{
    use HasFactory;
    protected $table = 'updatesingleblade';

    protected $fillable = [
        'user_id', 'bio', 'is_approved'
    ];


    public function user (){
        return $this->belongsTo(User::class,'user_id');
    }


}

