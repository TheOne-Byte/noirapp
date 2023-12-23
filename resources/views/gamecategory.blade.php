@extends('layouts/main')
@section('container')

<div class="container py-4 overflow-hidden">
  <h1 class="h2-title-text mb-4">GAME <br>CATEGORIES</h1>
  <hr>

  <div class="row px-3">
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
    <!-- <div class="col-6 col-md-4 col-lg-3">
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
        </div> -->
    <div class="col-12 col-sm-6 col-lg-3 p-1 p-md-2">
      <a class="max-h-card card-category bg-dark card border border-0" href="/categories/{{ $categoryItems[0]->slug }}" >
        @if ($categoryItems[0]->image)
        <img src="{{ asset('storage/' .$categoryItems[0]->image) }}" class="card-img-top" alt="...">
        @else
        <img src="https://source.unsplash.com/500x500?{{ $categoryItems[0]->name }}" class="card-img-top" alt="...">
        @endif
        <div class="card-body-absolute d-flex justify-content-between align-items-end">
          <h4 class="card-title m-0">{{ $categoryName }}</h4>
          <div class="d-flex align-items-center h-100" style="color:white">
            <i class="bi bi-caret-right-fill"></i>
          </div>
        </div>
      </a>
    </div>

    @endforeach
  </div>
</div>

@endsection