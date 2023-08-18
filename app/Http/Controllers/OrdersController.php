<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class OrderController extends Controller
{
    public function index(User $user){
        return view('order.index', [
            "title" => "order",
            'active' => 'order',
            'user' => $user
            // Post::find($id)
    
        ]);
    }

    public function addToCart(User $user){
        if(!$user){
            abort(404);
        }
        $cart = session()->get('cart');
    }
}
