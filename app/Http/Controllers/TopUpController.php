<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\point;
use App\Models\top_up;
use App\Models\User;

use Illuminate\Http\Request;

class TopUpController extends Controller
{
    public function index()
    {
        // $points = $this->getUserPoints();
        return view('point.top_up', [
            "title" => "order",
            'active' => 'order',
        ]);
    }

    public function success(){

        return view('point.success', [
            'active' => 'point.success'
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'payment_method' => 'required',
            'point_top_up' => 'required'
        ]);

        // $username = auth()->user()->username;
        top_up::create($request->all());
        $user = User::where('username', $request->input('username'))->first();
        $user->points += $request->input('point_top_up');
        $user->save();
        return view('point.success', [
            'active' => 'top_up'
        ]);
    }

    // public function getUserPoints()
    // {
    //     $username = auth()->user()->username;
    //     $points = Point::where('username', $username)->sum('current_point');
    //     return $points;
    // }
}
