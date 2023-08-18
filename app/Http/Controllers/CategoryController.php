<?php

namespace App\Http\Controllers;
use App\Models\category;
use App\Models\User;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function showcategory(){
        return view('gamecategory', [
            'title' => "User by category",
            'active' => 'category',
            'categories' => category::all() //ini category sm author karena di html nya dipanggil catgory sm author
            // Post::find($id)
    
        ]);
    }
    
    public function showuserbycategory(category $category){            
        return view('users', [
            'title' => "User by category",
            'active' => 'category',
            'users' => $category -> user  //ini category sm author karena di html nya dipanggil catgory sm author
            // Post::find($id)
    
        ]);
    }
}
