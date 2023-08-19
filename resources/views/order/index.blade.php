@extends('layouts/main')
<link rel="stylesheet" href="/css/order.css" >
@section('container')
    <form action="/addtocart" method="POST">
        @csrf
        {{-- @foreach ($user as $value){ <input type="hidden" name="result[]" value="$value."> }@endforeach --}}
        <input type="hidden" name="user_id" value="{{ $user -> id}}">
        {{-- <input type="hidden" name="buyer_id" value="{{ auth()->user()->id}}"> --}}

    <table id="cart" class="table table-hover table-condensed">
        <thead>
        <tr>
            <th style="width:50%">Product </th>
            <th style="width:10%">Price</th>
            <th style="width:8%">Quantity</th>
            <th style="width:22%" class="text-center">Subtotal</th>
            <th style="width:10%"></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td data-th="Product">
                <div class="row">
                    <div class="col-sm-3 hidden-xs"><img src="http://placehold.it/100x100" alt="..." class="img-responsive"/></div>
                    <div class="col-sm-9">
                        <h4 class="nomargin">{{ $user->role->name }}</h4>
                        <p>{{ $user->username }}</p>
                    </div>
                </div>
            </td>

            <td data-th="Price">{{ $user->price }}</td>
            <td data-th="Quantity">
                <input type="number" class="form-control text-center" value="1" name="quantity" oninput="calculateSubtotal(this)" min="1">
            </td>
            <td data-th="Subtotal" class="text-center">{{ $user->price }}</td>
            {{-- <td class="actions" data-th="">
                <button class="btn btn-info btn-sm"><i class="fa fa-refresh"></i></button>
                <button class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>
            </td> --}}
        </tr>
        </tbody>
        <tfoot>
        {{-- <tr class="visible-xs">
            <td class="text-center"><strong>Total 1.99</strong></td>
        </tr> --}}
        <tr>
            <td><button type="submit" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</button></td>
            <td colspan="2" class="hidden-xs"></td>
            <td class="hidden-xs text-center"><strong id="grand-total">Total ${{ $user->price }}</strong></td>
            <input type="hidden" name="price" id="price" value="{{ $user->price }}">

            <input type="hidden" name="grand_total" id="grand-total" value="grand-total">

        </tr>
        </tfoot>
    </table>
    </form>


    <script>
        function calculateSubtotal(input) {
            var row = input.closest('tr');
            var price = parseFloat(row.querySelector('[data-th="Price"]').innerText);
            var quantity = parseFloat(input.value);
            var subtotal = price * quantity;
            row.querySelector('[data-th="Subtotal"]').innerText = subtotal.toFixed(2);
            
            updateGrandTotal(); // Call the function to update the grand total
        }

        function updateGrandTotal() {
            var subtotals = document.querySelectorAll('[data-th="Subtotal"]');
            var grandTotal = 0;

            subtotals.forEach(function(subtotalElement) {
                grandTotal += parseFloat(subtotalElement.innerText);
            });

            document.getElementById('grand-total').innerText = 'Total $' + grandTotal.toFixed(2);
            
        }
        
    </script>

@endsection
