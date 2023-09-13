@extends('layouts/main')

@section('title', 'Order Details')

@section('container')
<div class="container mt-4">
    <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Order Summary</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Points: <span id="points"></span></p>
                    <p>Total Price: <span id="totalPrice"></span></p>
                    <p id="topUpMessage" style="color: red;"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmOrder">OK</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    // Di dalam JavaScript Anda
    const orderButton = document.getElementById('order-button');
    const orderModal = new bootstrap.Modal(document.getElementById('orderModal'));
    const confirmOrderButton = document.getElementById('confirmOrder');
    const pointsElement = document.getElementById('points');
    const totalPriceElement = document.getElementById('totalPrice');
    const topUpMessage = document.getElementById('topUpMessage');

    orderButton.addEventListener('click', function() {
        // Di sini Anda harus mengatur points dan totalPrice sesuai dengan data yang Anda miliki
        const points = 50; // Misalnya
        const totalPrice = 100; // Misalnya

        pointsElement.textContent = points;
        totalPriceElement.textContent = totalPrice;

        if (points >= totalPrice) {
            // Lanjutkan dengan proses pesanan
            // ...
        } else {
            topUpMessage.textContent = "Top up first.";

            confirmOrderButton.addEventListener('click', function() {
                // Redirect ke halaman top up jika point kurang
                window.location.href = '/top-up'; // Ganti dengan rute yang benar
            });

            orderModal.show();
        }
    });
</script>
