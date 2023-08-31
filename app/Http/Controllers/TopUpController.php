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
        return view('point.top_up', [
            "title" => "order",
            'active' => 'order'
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'payment_method' => 'required',
            'point_top_up' => 'required'
        ]);
        top_up::create($request->all());
        return view('point.success', [
            'active' => 'top_up'
        ]);
    }
}
