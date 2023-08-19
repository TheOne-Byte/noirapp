@extends('layouts/main')
@section('container')
{{-- @dd($cart) --}}
{{-- <form action="/addtocart" method="GET"> --}}
    {{ $cart }}
    {{-- {{ $cart->seller->username }} --}}

{{-- </form> --}}

@endsection