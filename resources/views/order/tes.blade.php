@extends('layouts.main')

@section('content')
<div class="container text-center mt-4">
    <h2>Order Page</h2>
    <button type="button" class="btn btn-primary" id="orderButton">Order</button>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#orderButton').click(function() {
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

        $.ajax({
            type: 'POST',
            url: '/ordervalidation',
            data: {
                _token: '{{ csrf_token() }}',
                checkedItems: checkedItemsData
            },
            success: function(response) {
                console.log('Data sent successfully.');
            },
            error: function(error) {
                console.error('Error sending data:', error);
            }
        });
    });
});
</script>
@endsection
