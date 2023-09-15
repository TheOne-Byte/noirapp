<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\Item;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\OrderValidation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
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
    public function showOrderPage(Request $request)
{
    // $selectedItems = $request->input('selectedItems'); // Ambil item yang dicek dari request
    // $cart = []; // Inisialisasi array untuk menampung item-item yang dicek
    // $totalPrice = 0; // Inisialisasi total harga

    // // Dapatkan item dari session dan pilih hanya item yang dicek
    // foreach ($request->session()->get('cart') as $item) {
    //     if (in_array($item->id, $selectedItems)) {
    //         $cart[] = $item;
    //         $totalPrice += $item->quantity * $item->price;
    //     }
    // }

    // $user = Auth::user();
    // $points = $user->points;

    // return view('order.orderpage', compact('points', 'totalPrice'), ['active' => 'orderPage']);
}

    public function confirmOrder(Request $request)
    {
        $selectedItems = $request->input('selectedItems');
        $cartItems = Cart::whereIn('id', $selectedItems)->get();

        return view('order.orderpage', compact('cartItems'));
    }

    public function placeOrder(Request $request)
    {

        $selectedItems = $request->input('selectedItems');
        // dd($selectedItems);

        // Validasi apakah ada item yang dipilih
        if (empty($selectedItems)) {
            return redirect()->back()->with('error', 'Please select at least one item before placing an order.');
        }
        $cartItems = cart::whereIn('id', $selectedItems)->get();
        // dd($cartItems);

        try {
            $totalPrice = 0; // Inisialisasi total harga

        // Hitung total harga
        foreach ($cartItems as $cartItem) {
            $totalPrice += $cartItem->price * $cartItem->quantity;
        }

        // Ambil user yang sedang login
        $user = User::find(Auth::user()->id);

        // Periksa apakah poin pengguna mencukupi
        if ($user->points >= $totalPrice) {
            // Kurangi poin pengguna
            $user->points -= $totalPrice;
            $user->save();

            // Tambahkan pesanan ke database
            foreach ($cartItems as $cartItem) {
                $orderValidation = new OrderValidation;
                $orderValidation->buyer_id = $user->id;
                $orderValidation->seller_id = $cartItem->user_id;
                $orderValidation->price = $cartItem->price;
                $orderValidation->quantity = $cartItem->quantity;
                $orderValidation->total_price = $cartItem->price * $cartItem->quantity;
                $orderValidation->status = 'REQ';
                $orderValidation->save();
            }

            // Hapus item dari Cart
            // cart::whereIn('id', $selectedItems)->delete();

            return redirect()->route('home', ['active' => 'home']);
        } else {
            return redirect()->back()->with('error', 'Insufficient points. Please top up first.');
        }
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['trace' => $e->getTrace()]);

        }
    }

    public function processOrder(Request $request)
    {
        $selectedItems = $request->input('selectedItems');
        // dd($selectedItems);

        // Validasi apakah ada item yang dipilih
        if (empty($selectedItems)) {
            return redirect()->back()->with('error', 'Please select at least one item before placing an order.');
        }
        $cartItems = cart::whereIn('id', $selectedItems)->get();
        // dd($cartItems);

        try {
            // Ambil data dari Cart
            // dd($cartItems);

            foreach ($cartItems as $cartItem) {
                $orderValidation = new OrderValidation;
                $orderValidation->buyer_id = auth()->user()->id; // Pembeli adalah user yang sedang login
                $orderValidation->seller_id = $cartItem->user_id; // Penjual adalah pemilik item di cart
                $orderValidation->price = $cartItem->price;
                $orderValidation->quantity = $cartItem->quantity;
                $orderValidation->total_price = $cartItem->price * $cartItem->quantity;
                $orderValidation->status = 'REQ'; // Status awal adalah request
                $orderValidation->save();
            }
            // dd($orderValidation);
            // Hapus item dari Cart
            // cart::whereIn('id', $itemIds)->delete();

            // Redirect atau kirim respons sesuai kebutuhan aplikasi Anda
            return redirect()->route('home')->with('error', 'An error occurred while processing the order.');
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['trace' => $e->getTrace()]);

        }
    }

    public function processOrderValidation(Request $request)
{

    $selectedItems = $request->input('selectedItems');
    dd($selectedItems);
    if (empty($selectedItems)) {
        return response()->json(['error' => 'Please select at least one item before placing an order.'], 422);
    }

    try {
        // Proses validasi pesanan dan simpan ke database
        foreach ($selectedItems as $itemId) {
            // Ambil item dari Cart
            $cartItem = Cart::find($itemId);

            if ($cartItem) {
                $orderValidation = new OrderValidation;
                $orderValidation->buyer_id = auth()->user()->id;
                $orderValidation->seller_id = $cartItem->user_id;
                $orderValidation->price = $cartItem->price;
                $orderValidation->quantity = $cartItem->quantity;
                $orderValidation->total_price = $cartItem->price * $cartItem->quantity;
                $orderValidation->status = 'REQ';
                $orderValidation->save();

                // Hapus item dari Cart
                $cartItem->delete();
            }
        }

        return response()->json(['success' => 'Order placed successfully.'], 200);
    } catch (\Exception $e) {
        Log::error($e->getMessage(), ['trace' => $e->getTrace()]);
        return response()->json(['error' => 'An error occurred while processing your order. Please try again later.'], 500);
    }
}

    public function validateOrder(Request $request, $id)
    {
        try {
            $orderValidation = OrderValidation::findOrFail($id);

            // Check if the user has enough points
            $amount = $orderValidation->total_price;

            if ($this->hasEnoughPoints($orderValidation->buyer, $amount)) {
                $orderValidation->status = 'APV';
                $orderValidation->save();

                // Masukkan ke transaksi
                Transaction::create([
                    'buyer_id' => $orderValidation->buyer_id,
                    'seller_id' => $orderValidation->seller_id,
                    'price' => $orderValidation->price,
                    'quantity' => $orderValidation->quantity,
                    'total_price' => $orderValidation->total_price,
                    'status' => 'ON_GOING'
                ]);

                // Potong saldo
                $this->deductPoints($orderValidation->buyer, $amount);

                // Kirim notifikasi ke pengguna
            } else {
                return redirect()->back()->with('error', 'Saldo tidak mencukupi.');
            }

            return redirect()->back()->with('success', 'Order validation status updated.');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function orderRequest()
    {
        // Dapatkan daftar OrderValidation yang membutuhkan validasi
        $sellerId = auth()->user()->id;
        $orderValidations = OrderValidation::where('status', 'REQ')
                                          ->where('seller_id', $sellerId)
                                          ->get();

        return view('order.orderrequest', compact('orderValidations'),['active' => 'OrderReq']);
    }

    public function acceptOrder($id)
{
    $orderValidation = OrderValidation::findOrFail($id);
    $orderValidation->status = 'APV';
    $orderValidation->save();
    Transaction::create([
        'buyer_id' => $orderValidation->buyer->id,
        'seller_id' => $orderValidation->seller_id,
        'price' => $orderValidation->price,
        'quantity' => $orderValidation->quantity,
        'total_price' => $orderValidation->total_price,
        'status' => 'ON_GOING'
    ]);
    return redirect()->route('order.request')->with('success', 'Order accepted.');
}

public function rejectOrder($id)
{

    $orderValidation = OrderValidation::findOrFail($id);
    $user = User::find($orderValidation->buyer_id);

    if (!$user) {
        return redirect()->route('order.request')->with('error', 'User not found.');
    }

    $user->points += $orderValidation->total_price;
    $user->save();

    $orderValidation->status = 'RJC';
    $orderValidation->save();

    return redirect()->route('order.request')->with('success', 'Order rejected.');
}

    private function hasEnoughPoints($user, $amount) {
        return $user->points >= $amount;
    }
    private function deductPoints($user, $amount) {
        return $user->points >= $amount;
    }
}
