<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function index(User $user){
        return view('order.index', [
            "title" => "order",
            'active' => 'order',
            'user' => $user
            // Post::find($id)

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        // $buyer_id = $request->user()->id;
        // dd($buyer_id);
        // dd($request->user()->name);

        $validated = $request->validate([
            'quantity' =>'min:1|required'
        ]);

        $validated['user_id'] = $request->user_id;
        $validated['price'] = $request->price;
        $validated['buyer_id'] = auth()->user()->id;

        if($request->user_id == auth()->user()->id){
            return redirect('/game')->with('error','Cant Order Yourself!');
        }
        cart::create($validated);

        $users = DB::table('users')->where('id',$request->user_id)->get('username');

        // return redirect()->route('user',['username' => DB::table('users')->where('id',$request->user_id)->get('username')])->with('success','Add To Cart!');
        return redirect('/game')->with('success','Add To Cart!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function GetCartByUserId(User $user)
    {
        // dd('masuk');
        // dd($cart);

        return view('order.show', [
            "title" => "order show",
            'active' => 'order show',
            'cart' => $user->cart
            // Post::find($id)

        ]);



    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         cart::destroy($id);
        return redirect()->back()->with('success','Item Sudah Dihapus!');    
    }

    //For deleting item in cart
    // public function deleteItem($id)
    // {
    //     // Find the Cart item by ID
    //     $cartItem = cart::find($id);

    //     // Check if the item exists
    //     if (!$cartItem) {
    //         return redirect('/cart')->with('error', 'Item not found in the cart.');
    //     }

    //     // Check if the item belongs to the currently authenticated user
    //     if ($cartItem->buyer_id !== auth()->user()->id) {
    //         return redirect('/cart')->with('error', 'You cannot delete this item as it does not belong to you.');
    //     }

    //     // Delete the item
    //     $cartItem->delete();

    //     return redirect('/cart')->with('success', 'Item removed from the cart.');
    // }



}
