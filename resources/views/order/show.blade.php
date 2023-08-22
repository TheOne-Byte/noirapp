@extends('layouts.main')
@section('container')
<div class="pt-3 pb-2 mb-3 border-bottom text-white">
    <h1 class="h2 text-center" style="color: white">MY CART</h1>

    @if(session()->has('success'))
      <div class="alert alert-success" role="alert">
          {{ session('success') }}
      </div>
    @endif
    
    <div class="table-responsive small text-white">
      <table class="table table-striped table-sm col-lg-8">
        <thead>
          <tr>
            <th scope="col">Select</th>
            <th scope="col">Product Name</th>
            <th scope="col">Price</th>
            <th scope="col">Quantity</th>
            <th scope="col">Subtotal</th>
          </tr>
        </thead>
        <tbody>

        @foreach($cart as $cart)
            {{-- @php
                $totalQuantity = $cart->sum('quantity');
                $totalPrice = $cart->sum(function ($item) {
                    return $item->quantity * $item->price;
                });
            @endphp --}}
          <tr>
            <td><input type="checkbox"></td>
            <td>{{ $cart->seller->username }}</td>
            <td>{{ $cart->price }}</td>
            <td> <input type="number" class="form-control quantity-input text-center" value="{{ $cart->quantity }}" min="1">
            </td>
            <td>SUBTOTAL DISINI</td>
            <td>
                <form action="/addtocart/{{ $cart->id }}" method="POST" class="d-inline">
                  @method('delete')
                  @csrf
                  <button class="badge bg-danger border-0" onclick="return confirm('are you sure deleting this?')"><span class="bi bi-trash " style="color: white"></span></button>
                </form>
            </td>
          </tr>
        </tbody>
        @endforeach
      </table>


    </div>
  </div>
@endsection