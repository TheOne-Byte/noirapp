<?php

namespace App\Http\Controllers;
use App\Models\category;
use App\Models\User;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function showcategory()
    {
        return view('gamecategory', [
            'title' => "User by category",
            'active' => 'category',
            'categories' => category::all() // Use the correct model name
        ]);
    }

    public function showuserbycategory(category $category)
    {
        return view('users', [
            'title' => "User by category",
            'active' => 'category',
            'users' => $category->users->load('category', 'role') // Use the correct relationship name 'users'
        ]);
    }
}
