@extends('layouts.main')

@section('container')`
<div class="container">
<h1 class="h2-title-text mb-4">TRANSACTION HISTORY</h1>
    <hr>

    @if(session()->has('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
    @if(session()->has('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
    @endif
    @if ($transactions->isEmpty())
    <p class="text-center text-danger">No transaction available.</p>
    @else
    <table class="table text-white">
        <thead>
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Player/Coach</th>
                <th>Price</th>
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
                    <td>{{ $transaction->price }}</td>
                    <td>{{ $status[$loop ->iteration-1] }}</td>

                    <td>
                        @if( $status[$loop ->iteration-1]  == 'Done' && $transaction->already_review != 1 )
                        <a href="/rating?TrxNo={{ $transaction->slug }}">
                            <button type="" class="btn btn-card text-white">Review</button>
                        </a>
                        @endif
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
