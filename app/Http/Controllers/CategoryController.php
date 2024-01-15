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

    public function showuserbycategory(Category $category)
    {
        if (!$category) {
            abort(404); // or handle the error in another way
        }

        if (auth()->user()) {
            $users = $category->user()
                ->with(['permissions' => function ($query) {
                    $query->where('statcode', 'APV')->latest('created_at');
                }])
                ->whereIn('role_id', [1, 2])
                ->where('id', '!=', auth()->user()->id)
                ->get();
        } else {
            $users = $category->user()->whereIn('role_id', [1, 2])->get();
        }

        // You can remove the dd() here if you want to proceed to rendering the view
        // dd([
        //     'title' => "User by category",
        //     'active' => 'category',
        //     'users' => $users,
        // ]);

        return view('users', [
            'title' => "User by category",
            'active' => 'category',
            'users' => $users,
        ]);
    }




}
