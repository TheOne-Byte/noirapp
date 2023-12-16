@extends('layouts/main')

@section('container')
    <div class="container mt-5">
        <h2 class="text-center">Order Requests</h2>

        @if ($orderValidations->isEmpty())
            <p class="text-center text-danger">No order requests available.</p>
        @else
            <table class="table table-bordered table-white-text text-white">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Buyer</th>
                        <th>Price</th>
                        <th>Schedule</th> <!-- Ganti Quantity dengan Schedule -->
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orderValidations as $orderValidation)
                        <tr>
                            <td>{{ $orderValidation->id }}</td>
                            <td>{{ $orderValidation->buyer->name }}</td>
                            <td>{{ $orderValidation->price }}</td>
                            <td>
                                @if ($orderValidation->schedule)
                                    Date: {{ $orderValidation->schedule->date }},
                                    Time: {{ $orderValidation->schedule->start_time }} - {{ $orderValidation->schedule->end_time }}
                                @endif
                            </td>
                            <td>{{ $orderValidation->status }}</td>
                            <td>
                                <form action="{{ route('order.process', $orderValidation->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Accept</button>
                                </form>
                                <form action="{{ route('order.reject', $orderValidation->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Reject</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
