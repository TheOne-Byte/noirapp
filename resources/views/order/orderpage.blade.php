@extends('layouts/main')

{{-- @section('title', 'Order Details') --}}

@section('container')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Order Summary</h5>
                    <table class="table">
                        <tr>
                            <th>Points</th>
                            <td><span id="points">{{ $points }}</span></td>
                        </tr>
                        <tr>
                            <th>Total Price</th>
                            <td><span id="totalPrice">{{ number_format($totalPrice, 2) }}</span></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="color: red; text-align: center;" id="topUpMessage">
                                @if ($points < $totalPrice)
                                    You have insufficient points. <a href="{{ route('top_up') }}">Click here to top up.</a>
                                @endif
                            </td>
                        </tr>
                    </table>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-secondary mx-2" id="cancelOrder">Cancel</button>
                        <button type="button" class="btn btn-primary mx-2" id="confirmOrder">OK</button>
                        <form id="newButtonForm" action="/orderValidation" method="POST">
                            @csrf
                            <button type="button" class="btn btn-primary mx-2" id="newButton">New Button</button>
                        </form>
                    </div>
                </div>

            </div>
            <form id="newButtonForm" action="/orderValidation" method="POST">
                @csrf
                <button type="button" class="btn btn-primary mx-2" id="newButton">New Button</button>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js">
   $('#newButton').click(function() {
    var selectedItems = $('input[name="selectedItems[]"]:checked');
    var checkedItemsData = [];

    selectedItems.each(function() {
        var itemId = $(this).data('item-id');
        var sellerName = $(this).data('seller-name');
        var price = parseFloat($(this).data('price'));
        var quantity = parseInt($(this).closest('tr').find('.quantity-input').val());
        var subtotal = price * quantity;

        checkedItemsData.push({
            itemId: itemId,
            sellerName: sellerName,
            price: price,
            quantity: quantity,
            subtotal: subtotal
        });
    });

    // Submit the form
    $('#newButtonForm').submit();
});
</script>
@endsection
