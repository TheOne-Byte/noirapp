@extends('layouts/main')

@section('container')
<style>
    .rating-details {
        max-width: 600px;
        margin: 0 auto;
    }

    .rating-card {
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        background-color: #f9f9f9;
    }

    .user-name {
        font-weight: bold;
        margin-bottom: 10px;
    }

    .comment {
        color: #555;
    }
</style>
<div class="rating-details">
    <h1 class="title text-white">Detail Rating</h1>
    @foreach($ratings as $rating)
        <div class="rating-card">
            <div class="user-name">{{ $rating->buyer->name }}</div>
            <div class="comment">{{ $rating->comment }}</div>
        </div>
    @endforeach
</div>
@endsection
