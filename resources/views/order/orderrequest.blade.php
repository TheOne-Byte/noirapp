@extends('layouts/main')

@section('container')
    <div class="container mt-4">
        <h1 class="h2-title-text mb-4">ORDER REQUEST</h1>
        <hr>

        @if ($orderValidations->isEmpty())
            <p class="text-center text-danger">No order requests available.</p>
        @else
            <table class="table table-bordered table-white-text text-white">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Buyer</th>
                        <th>Price</th>
                        <th>Schedule</th> <!-- Ganti Quantity dengan Schedule -->
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orderValidations as $orderValidation)
                            <td>{{ $loop ->iteration }}</td>
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
                                    <button type="submit" class="btn btn-danger" style="margin-top: 6px">Reject</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
