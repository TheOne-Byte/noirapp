@extends('admin.layouts.main')
@section('container')
<div class="pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">GAME CATEGORIES</h1>

    @if(session()->has('success'))
      <div class="alert alert-success col-lg-5" role="alert">
          {{ session('success') }}
      </div>
    @endif
    
    <div class="table-responsive small col-lg-5">
      <a class="btn btn-primary mb-3" href="/dashboard/categories/create">CREATE NEW CATEGORY</a>
      <table class="table table-striped table-sm ">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Category Name</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>

        @foreach($categories as $category)
          <tr>
            <td>{{ $loop ->iteration }}</td>
            {{-- bs dipake krn dlm foreach --}}
            <td>{{ $category->name }}</td>
            <td>
                {{-- <a href="/dashboard/categories/{{ $category->slug }}" class="badge bg-info"><span class="bi bi-eye " style="color: black"></span></a> --}}
                <a href="/dashboard/categories/{{ $category->slug }}/edit" class="badge bg-warning"><span class="bi bi-pencil-square " style="color: darkblue"></span></a>

                <form action="/dashboard/categories/{{ $category->slug }}" method="POST" class="d-inline">
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