<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function showsingleuser(User $user){            
        return view('singleuser', [
            'title' => "User Information",
            'active' => 'singleuser',
            'user' => $user -> load('category') //ini category sm author karena di html nya dipanggil catgory sm author
            // Post::find($id)
    
        ]);
    }
}
