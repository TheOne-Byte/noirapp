<?php

namespace App\Http\Controllers;

use App\Models\cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function getCartData()
{
    $cartItems = cart::where('user_id', auth()->user()->id)->get();

    return response()->json(['cartItems' => $cartItems]);
}
}
