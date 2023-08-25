@extends('layouts/main')

@section('container')
<div class="container">
    <h2 class="text-white text-center">My Cart</h2>

    @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <!-- Add a form to wrap the table and Place Order button -->
            <form method="POST" action="{{ route('place.order') }}">
                @csrf <!-- Add CSRF token -->

                <table class="table table-white-text">
                    <thead>
                        <tr>
                            <th class="white-text text-center">Check</th>
                            <th class="white-text text-center">Product</th>
                            <th class="white-text text-center">Price</th>
                            <th class="white-text text-center">Quantity</th>
                            <th class="white-text text-center">Subtotal</th>
                            <th class="white-text text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalPrice = 0; // Initialize total price outside the loop
                        @endphp

                        @foreach ($cart->groupBy('seller.name') as $sellerName => $cartItems)
                            @php
                                $sellerSubtotal = $cartItems->sum(function ($item) {
                                    return $item->quantity * $item->price;
                                });
                                $totalPrice += $sellerSubtotal;
                            @endphp

                            <tr>
                                <td class="text-center">
                                    <!-- Add a checkbox input for item selection -->
                                    <input type="checkbox" name="selectedItems[]" value="{{ $cartItems[0]->id }}">
                                </td>
                                <td class="text-center">{{ $sellerName }}</td>
                                <td class="text-center">{{ $cartItems[0]->price }}</td>
                                <td class="text-center">
                                    <!-- Use number input to allow quantity changes with custom styles -->
                                    <input type="number" class="form-control quantity-input text-center" value="{{ $cartItems[0]->quantity }}" min="1" data-item-id="{{ $cartItems[0]->id }}" oninput="updateQuantityInDatabase(this); updateSubtotal(this);">
                                </td>
                                <td class="text-center subtotal">
                                    ${{ number_format($sellerSubtotal, 2) }}
                                </td>
                                <td class="text-center">
                                    <a href="#" class="badge bg-danger border-0 delete-item" data-item-id="{{ $cartItems[0]->id }}"><span class="bi bi-trash" style="color: white"></span></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Place Order button -->
                <div class="text-center">
                    <button id="order-button" class="btn btn-primary" type="submit" disabled>Place Order</button>
                </div>
            </form>
        </div>
    </div>

    <div class="text-center">
        <h3>Total: <span id="grand-total">${{ number_format($totalPrice, 2) }}</span></h3>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- ... Existing JavaScript code ... -->
</div>
