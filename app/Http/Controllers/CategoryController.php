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
            'users' => $users,
            'category' => $category,
        ]);
    }


    public function filterByRole(Request $request, category $category)
    {
        $roleId = $request->input('role');
        $selectedDay = $request->input('day');
        $startTime = $request->input('start_time');
        $endTime = $request->input('end_time');

        $users = User::whereHas('role', function ($query) use ($roleId) {
            if ($roleId != 'all') {
                $query->where('id', $roleId);
            }
        });

        if ($category) {
            // If category is provided, filter by category
            $users->whereHas('category', function ($query) use ($category) {
                $query->where('slug', $category->slug);
            });
        }
        if ($selectedDay) {
            // If day is selected, filter by day
            $users->whereHas('availableTimes', function ($query) use ($selectedDay) {
                $query->where('day', $selectedDay);
            });
        }

        if ($startTime && $endTime) {
            $users->whereHas('availableTimes', function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                      ->whereBetween('end_time', [$startTime, $endTime]);
            });
        }

        $users = $users->get();

        return view('users', [
            'title' => 'Filtered Users',
            'active' => 'category',
            'users' => $users,
            'category' => $category,
        ]);
    }
}
