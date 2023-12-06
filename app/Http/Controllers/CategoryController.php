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

    public function showuserbycategory(category $category) // Keep it as provided
    {
        if (!$category) {
            abort(404); // or handle the error in another way
        }

        if(auth()->user()){
            $users = $category->user()
            ->with('permissions') // Eager load the permissions relationship
            ->whereIn('role_id', [1, 2])
            ->where('id', '!=', auth()->user()->id)
            ->get();
            // dd($users->pluck('permissions'));
            }
        else{
            $users = $category->user()->whereIn('role_id', [1, 2])->get();
        }
        return view('users', [
            'title' => "User by category",
            'active' => 'category',
            'users' => $users
        ]);
    }

}
