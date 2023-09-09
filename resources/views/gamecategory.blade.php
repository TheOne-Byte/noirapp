@extends('layouts/main')
@section('container')

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

    @php
        $groupedCategories = $categories->groupBy('name');
    @endphp

    @foreach ($groupedCategories as $categoryName => $categoryItems)
        <div class="col-md-4">
            <a href="/categories/{{ $categoryItems[0]->slug }}" class="text-decoration-none text-white">
            <div class="card bg-dark">

                @if ($categoryItems[0]->image)
                  <img src="{{ asset('storage/' .$categoryItems[0]->image) }}" class="card-img" alt="..." width="410" height="410">
                @else
                  <img src="https://source.unsplash.com/500x500?{{ $categoryItems[0]->name }}" class="card-img" alt="...">
                @endif

                <div class="card-img-overlay d-flex align-items-center p-0">
                  <h2 class="card-title text-center flex-fill p-4 fs-3" style="background-color:rgba(0, 0, 0, 0.7) ">{{ $categoryName }}</h2>
                </div>
              </div>
            </a>
        </div>
    @endforeach
    </div>
</div>

@endsection
