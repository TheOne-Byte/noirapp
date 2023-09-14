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
                                <input type="checkbox" class="item-checkbox" data-item-id="{{ $cartItems[0]->id }}" data-seller-name="{{ $sellerName }}" data-price="{{ $cartItems[0]->price }}" name="selectedItems[]" value="{{ $cartItems[0]->id }}">
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
                                <form action="/addtocart/{{ $cartItems[0]->id }}" method="POST" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button class="badge bg-danger border-0" onclick="return confirm('are you sure deleting this?')"><span class="bi bi-trash " style="color: white"></span></button>
                                  </form>
                                {{-- <a href="#" class="badge bg-danger border-0 delete-item" data-item-id="{{ $cartItems[0]->id }}"><span class="bi bi-trash" style="color: white"></span></a> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-center">
        <h3>Total: <span id="grand-total">${{ number_format($totalPrice, 2) }}</span></h3>
    </div>

    <form id="placeOrderForm" method="POST" class="d-flex justify-content-center">
        @csrf
        <button type="submit" class="btn btn-primary">Place Order</button>
    </form>
</div>

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('form#placeOrderForm').on('submit', function(e) {
        e.preventDefault();

        // Mengumpulkan ID item yang dicheck
        var selectedItems = [];
        $('.item-checkbox:checked').each(function() {
            selectedItems.push($(this).data('item-id'));
        });

        // Kirim data ke route 'place.order' dengan method POST
        $.ajax({
            type: 'POST',
            url: '{{ route('place.order') }}',
            data: { selectedItems: selectedItems, _token: '{{ csrf_token() }}' },
            success: function(data) {
                alert('Order placed successfully!');
                // Jika Anda ingin melakukan sesuatu setelah berhasil, tambahkan di sini.
            },
            error: function(error) {
                alert('Error placing order. Please try again later.');
                console.error(error);
            }
        });
    });
});
// function submitForm() {
//     var selectedItems = document.querySelectorAll('input.item-checkbox:checked');
//     var itemIds = Array.from(selectedItems).map(item => item.value);
//     // console.log(itemIds);

//     var formData = new FormData();
//     formData.append('selectedItems', itemIds.join(','));

//     fetch('/orderpage', {
//         method: 'POST',
//         body: formData,
//         headers: {
//             'X-CSRF-TOKEN': '{{ csrf_token() }}'
//         }
//     }).then(function(response) {
//         if (!response.ok) {
//             throw new Error('Network response was not ok');
//         }
//         return response.json();
//     }).then(function(data) {
//         // Lakukan manipulasi DOM atau alihkan pengguna ke halaman lain
//         window.location.href = '/orderpage'; // Contoh mengalihkan ke halaman order
//     }).catch(function(error) {
//         console.error('There was a problem with the fetch operation:', error);
//     });

//     return false; // Mengembalikan false untuk mencegah formulir mengirimkan permintaan lagi
// }
    // Get all quantity input fields
    const quantityInputs = document.querySelectorAll('.quantity-input');
    const grandTotalElement = document.getElementById('grand-total');
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');

    // Array to store selected item IDs
    const selectedItems = [];

    // Add input event listener to each input
    quantityInputs.forEach((input) => {
        input.addEventListener('input', function() {
            updateQuantityInDatabase(input);
            updateSubtotal(input);
        });
    });

    // Add change event listener to each checkbox
    itemCheckboxes.forEach((checkbox) => {
        checkbox.addEventListener('change', function() {
            updateTotals();
            updateSelectedItems();
        });
    });

    // Function to update totals based on checkbox state
    function updateTotals() {
        let grandTotal = 0;

        itemCheckboxes.forEach((checkbox) => {
            if (checkbox.checked) {
                const price = parseFloat(checkbox.getAttribute('data-price'));
                const quantityInput = document.querySelector(`.quantity-input[data-item-id="${checkbox.getAttribute('data-item-id')}"]`);
                const quantity = parseInt(quantityInput.value);
                grandTotal += price * quantity;
            }
        });

        grandTotalElement.textContent = `$${grandTotal.toFixed(2)}`;
    }

    // Function to update quantity in the database
    function updateQuantityInDatabase(input) {
        const itemId = input.getAttribute('data-item-id');
        const quantity = input.value;

        // Send an AJAX request to update the quantity in the database
        $.ajax({
            type: 'PUT', // Use PUT to update the resource
            url: `/cart/${itemId}`, // Use the correct URL based on your routes
            data: {
                _token: '{{ csrf_token() }}', // Include the CSRF token
                quantity: quantity
            },
            success: function(response) {
                console.log('Quantity updated successfully in the database.');
            },
            error: function(error) {
                console.error('Error updating quantity in the database:', error);
            }
        });
    }

    // Function to update the subtotal based on quantity change
    function updateSubtotal(input) {
        const row = input.closest('tr');
        const price = parseFloat(row.querySelector('.item-checkbox').getAttribute('data-price'));
        const quantity = parseInt(input.value);
        const subtotal = row.querySelector('.subtotal');
        const newSubtotal = (price * quantity).toFixed(2);
        subtotal.textContent = `$${newSubtotal}`;
    }

    // Function to update the list of selected items
    function updateSelectedItems() {
        selectedItems.length = 0; // Clear the array

        itemCheckboxes.forEach((checkbox) => {
            if (checkbox.checked) {
                const itemId = checkbox.getAttribute('data-item-id');
                selectedItems.push(itemId);
            }
        });

        // Enable the "Place Order" button if items are selected
        // const orderButton = document.getElementById('order-button');
        // orderButton.disabled = selectedItems.length === 0;
    }

    // // Handle the "Place Order" button click
    // const orderButton = document.getElementById('order-button');

    // orderButton.addEventListener('click', function() {
    //     const selectedItems = [];

    //     itemCheckboxes.forEach((checkbox) => {
    //         if (checkbox.checked) {
    //             const itemId = checkbox.getAttribute('data-item-id');
    //             selectedItems.push(itemId);
    //         }
    //     });

    //     if (selectedItems.length === 0) {
    //         alert('Please select at least one item before placing an order.');
    //         return;
    //     }

    //     const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    //     fetch('/place-order', {
    //         method: 'POST',
    //         headers: {
    //             'Content-Type': 'application/json',
    //             'X-CSRF-TOKEN': csrfToken,
    //         },
    //         body: JSON.stringify({ selectedItems }),
    //     })
    //     .then(response => response.json())
    //     .then(data => {
    //         console.log(data); // Handle response from server if needed

    //         const selectedItemsString = selectedItems.join(',');
    //         const orderPageUrl = `/orderpage?selectedItems=${selectedItemsString}`;

    //         // Redirect to the order page
    //         window.location.href = orderPageUrl;
    //     })
    //     .catch(error => {
    //         console.error('Error:', error);
    //     });
    // });
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
