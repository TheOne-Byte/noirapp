@extends('layouts.main')

@section('container')
<div class="container mt-5">
    <h2 class="text-center">Transaction</h2>

    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($transactions->isEmpty())
            <p class="text-center text-danger">No transaction available.</p>
    @else
    <table class="table text-danger">
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->status }}</td>
                    <td>
                        <form action="{{ route('transactions.markAsDone', $transaction->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success">Mark as Done</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
