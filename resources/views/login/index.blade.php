@extends('layouts/main')
@section('container')

<div class="row justify-content-center py-4 px-4 px-lg-5">
  <div class="col-lg-5">
    <main class="form-signin">

      @if(session()->has('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif

      @if(session()->has('loginError'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('loginError') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
      
      <h1 class="h2-title-text mb-4">LOGIN</h1>
      <hr>

      <form action="/login" method="POST" class="d-flex flex-column mx-0 mx-sm-0 mt-3 mt-lg-4">
        @csrf
        <div class="form-floating">
          <input type="email" class="@error('email') is-invalid @enderror form-control" id="floatingInput"
            placeholder="name@gmail.com" autofocus required name="email" value="{{ old('email') }}">
          <label for="floatingInput" class="container">Email address</label>
          @error('email')
          <div class="invalid-feedback">{{$message }}</div>
          @enderror
        </div>
        <div class="form-floating">
          <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password"
            required>
          <label for="floatingPassword">Password</label>
        </div>
        <button class="btn btn-primary mt-3" type="submit">Login</button>
      </form>

      <small class="d-block text-center mt-4 text-white">Dont have an account? <a href="/register">Register
          Here</a></small>
    </main>
  </div>
</div>



@endsection