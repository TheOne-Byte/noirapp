@extends('layouts/main')
@section('container')

<div class="row justify-content-center">
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
    <h1 class="h3 mb-3 fw-normal text-center" id="logintext">LOGIN</h1>
      <form action="/login" method="POST">
        @csrf
        <div class="form-floating">
          <input  type="email" class="@error('email') is-invalid @enderror form-control" id="floatingInput" placeholder="name@gmail.com" autofocus required name="email" value="{{ old('email') }}"> 
          <label for="floatingInput">Email address</label>
          @error('email')
          <div class="invalid-feedback">{{$message }}</div>
          @enderror
        </div>
        <div class="form-floating">
          <input  type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" required>
          <label for="floatingPassword">Password</label>
        </div>
        
        <button class="btn btn-primary w-50" type="submit" id="login">Login</button>
      </form>

      <small class="d-block text-center mt-3 text-white">Dont have an account?<a href="/register"> Register Here</a></small>
  </main>
  </div>
</div>



@endsection