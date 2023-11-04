@extends('layouts.main')

@section('container')
<div class="container mt-5">
    <h2 class="text-center">My Schedule</h2>

    {{-- @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif --}}
    @if ($schedules->isEmpty())
            <p class="text-center text-danger">No transaction available.</p>
    @else
    <table class="table text-white">
        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Date</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($schedules as $schedule)
                <tr>
                    <td>{{ $loop ->iteration }}</td>
                    <td>{{ $schedule->buyer->name }}</td>
                    <td>{{ $schedule->date}}</td>
                    <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
{{-- <div class="container mt-5">
    <h2>Your Schedules</h2>

        @if($schedules->isEmpty())
            <p>You have no schedules yet.</p>
        @else
            <ul>
                @foreach($schedules as $schedule)
                    <li>
                        Date: {{ $schedule->date }}, Time: {{ $schedule->start_time }} - {{ $schedule->end_time }}<br>
                        Seller: {{ $schedule->seller->name }}
                    </li>
                @endforeach
            </ul>
        @endif
</div> --}}
@endsection
