@extends('layouts/main')

@section('container')
<div class="container">
    <h2 class="text-white text-center">Order Details</h2>

    <div class="card">
        <div class="card-body">
            <h3>Selected Items:</h3>

            <ul>
                @foreach ($selectedItems as $item)
                    <li>
                        <strong>Product Name:</strong> {{ $item->name }}<br>
                        <strong>Price:</strong> ${{ $item->price }}<br>
                        <!-- Add any other item details you want to display -->
                    </li>
                    <hr>
                @endforeach
            </ul>
