@extends('layouts/main')

@section('container')
<div class="container">
    <h1>Your Cart</h1>

    <div class="card">
        <div class="card-body">
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
                    @foreach ($cart->groupBy('seller.name') as $sellerName => $cartItems)
                        @php
                            $totalQuantity = $cartItems->sum('quantity');
                            $totalPrice = $cartItems->sum(function ($item) {
                                return $item->quantity * $item->price;
                            });
                        @endphp

                        <tr>
                            <td class="text-center">
                                <input type="checkbox">
                            </td>
                            <td class="text-center">{{ $sellerName }}</td>
                            <td class="text-center">{{ $cartItems[0]->price }}</td>
                            <td class="text-center">
                                <!-- Use number input to allow quantity changes with custom styles -->
                                <input type="number" class="form-control quantity-input text-center" value="{{ $totalQuantity }}" min="1">
                            </td>
                            <td class="text-center subtotal">
                                ${{ number_format($totalPrice, 2) }}
                            </td>
                            <td class="text-center">
                                <a href="/deleteItem/{{ $cartItems[0]->id }}" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Get all quantity input fields
    const quantityInputs = document.querySelectorAll('.quantity-input');

    // Add change event listener to each input
    quantityInputs.forEach((input) => {
        input.addEventListener('change', updateSubtotal);
    });

    // Function to update subtotal based on quantity change
    function updateSubtotal(event) {
        const input = event.target;
        const row = input.closest('tr');
        const price = parseFloat(row.querySelector('.text-center:eq(2)').textContent);
        const quantity = parseInt(input.value);
        const subtotal = row.querySelector('.subtotal');

        // Calculate new subtotal
        const newSubtotal = (price * quantity).toFixed(2);

        // Update the subtotal in the corresponding row
        subtotal.textContent = `$${newSubtotal}`;
    }
</script>

<style>
    /* Define the text color for the table content */
    .table-white-text tbody tr td {
        color: white;
    }
    /* Define the text color for the specific header cells */
    .white-text {
        color: white;
    }

    /* Style for the quantity input */
    .quantity-input {
        width: 50px !important; /* Adjust this as needed */
        padding: 0.25rem 0.5rem !important; /* Adjust padding as needed */
        font-size: 14px !important; /* Adjust font size as needed */
     }

    /* Center-align both header and data in the Quantity column */
    .table th.text-center, .table td.text-center {
        text-align: center !important;
    }
</style>
@endsection
