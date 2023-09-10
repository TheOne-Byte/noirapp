<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use Illuminate\Support\Facades\Redirect;

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
        $validated = $request->validate([
            'quantity' => 'min:1|required'
        ]);

        // Add some logging for debugging
        Log::info('Store method is being called.'); // Check if this log is shown in your logs

        $user_id = $request->user_id;
        $buyer_id = auth()->user()->id;
        $price = $request->price;
        $quantity = $validated['quantity'];
        $subtotal = $price * $quantity; // Calculate the subtotal

        // Check if the product already exists in the cart for the current user
        $existingCartItem = cart::where('user_id', $user_id)
            ->where('buyer_id', $buyer_id)
            ->first();

        if ($existingCartItem) {
            // If the product exists, update the quantity and subtotal
            $existingCartItem->increment('quantity', $quantity);
            $existingCartItem->subtotal += $subtotal;
            $existingCartItem->save();
        } else {
            // If the product doesn't exist, create a new cart item
            cart::create([
                'user_id' => $user_id,
                'quantity' => $quantity,
                'price' => $price,
                'buyer_id' => $buyer_id,
                'subtotal' => $subtotal,
            ]);
        }

        return redirect('/game')->with('success', 'Added to Cart!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Calculate the new subtotal
        $cartItem = cart::findOrFail($id);
        $quantity = $validated['quantity'];
        $subtotal = $cartItem->price * $quantity;

        // Update the quantity and subtotal in the database
        $cartItem->quantity = $quantity;
        $cartItem->subtotal = $subtotal;
        $cartItem->save();

        return response()->json(['message' => 'Quantity updated successfully']);
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function GetCartByUserId(User $user)
    {
        // Retrieve the cart items for the user
        $cart = $user->cart;

        return view('order.show', [
            "title" => "order show",
            'active' => 'order show',
            'cart' => $cart // Pass the cart items to the view
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



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        cart::destroy($id);
        return redirect()->back()->with('success','Item Deleted!');
    }
    public function showOrderPage(Request $request, $selectedItems)
    {
        $itemIds = explode(',', $selectedItems);

        try {
            // Fetch selected items' data here

            return view('order.orderpage', ['selectedItems' => $itemIds]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }



    public function placeOrder(Request $request)
    {
        $selectedItems = $request->input('selectedItems');
        $itemIds = explode(',', $selectedItems);

        try {
            // Perform any necessary actions for placing the order here

            // Redirect to the order page with selected item IDs
            return redirect()->route('order.page', ['selectedItems' => $itemIds]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
