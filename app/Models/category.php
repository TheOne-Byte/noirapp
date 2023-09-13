<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class category extends Model
{

    use HasFactory;

    protected $fillable = [

        'name',
        'slug',
        'image'

    ];
    public function user (){
        return $this->hasMany(User::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
