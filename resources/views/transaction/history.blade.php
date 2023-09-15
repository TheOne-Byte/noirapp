@extends('layouts.main')

@section('container')
    <h2 class="text-center">Transaction History</h2>
    @if ($transactions->isEmpty())
    <p class="text-center text-danger">No transaction available.</p>
    @else
    <table class="table text-danger">
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif
@endsection
