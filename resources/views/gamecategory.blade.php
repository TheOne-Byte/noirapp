@extends('layouts/main')
@section('container')

{{-- @dd(auth()) --}}
<a href="/cart/{{auth()->user()->username  }}">WOI</a>

<div class="container">
    <div class="row">
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
        @foreach ($categories as $categories)
        <div class="col-md-4">        
            <a href="/categories/{{ $categories->slug }}" class="text-decoration-none text-white"> 
            <div class="card bg-dark">
                <img src="https://source.unsplash.com/500x500?{{ $categories->name }}" class="card-img" alt="...">
                <div class="card-img-overlay d-flex align-items-center p-0">
                  <h2 class="card-title text-center flex-fill p-4 fs-3" style="background-color:rgba(0, 0, 0, 0.7) ">{{ $categories->name }}</h2>
                  {{-- <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                  <p class="card-text"><small>Last updated 3 mins ago</small></p> --}}
                </div>
              </div>        
            </a>
        </div>
        @endforeach
    </div>
</div>


       
@endsection
