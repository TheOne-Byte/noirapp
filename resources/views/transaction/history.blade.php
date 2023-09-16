@extends('layouts.main')

@section('container')
    <h2 class="text-center">Transaction History</h2>
    @if ($transactions->isEmpty())
    <p class="text-center text-danger">No transaction available.</p>
    @else
    <table class="table text-white">
        <thead>
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Player/Coach</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Review</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $loop ->iteration }}</td>
                    <td>{{ $transaction->seller->name }}</td>
                    <td>{{ $transaction->seller->role->name }}</td>
                    <td>{{ $transaction->quantity }}</td>
                    <td>{{ $transaction->price }}</td>
                    <td>{{ $transaction->total_price }}</td>
                    <td>{{ $transaction->status }}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif
@endsection
