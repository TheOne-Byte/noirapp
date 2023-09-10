@extends('layouts/main')
@section('container')
<div class="row justify-content-center">
  <div class="col-lg-5">
  <main class="form-registration">
    <h1 class="h3 mb-3 fw-normal text-center" id="registertext">Registration Form</h1>
      <form action="/register" method="POST">
        @csrf
        <div class="form-floating">
          <input value="{{ old('name') }}" type="text" class="ml-3 mb-2 @error('name') is-invalid @enderror form-control rounded-top" id="name" placeholder="Name" name="name" >
          <label for="name">Name</label>
          
          @error('name')
          <div class="invalid-feedback">{{$message }}</div>
          @enderror

        </div>
        <div class="form-floating">
          <input value="{{ old('username') }}" type="text" class="mb-2 form-control  @error('username') is-invalid @enderror" id="username" placeholder="username" name="username">
          <label for="username">Username</label>

          @error('username')
          <div class="invalid-feedback">{{$message }}</div>
          @enderror
        </div>
        <div class="form-floating">
          <input  value="{{ old('password') }}" type="password" class="mb-2 form-control @error('password') is-invalid @enderror" id="password" placeholder="password" name="password">
          <label for="password">Password</label>

          @error('password')
          <div class="invalid-feedback">{{$message }}</div>
          @enderror
        </div>
        <div class="form-floating">
          <input value="{{ old('email') }}" type="email" class="mb-2 form-control  @error('email') is-invalid @enderror rounded-bottom" id="email" placeholder="name@example.com" name="email">
          <label for="email">Email address</label>
          @error('email')
          <div class="invalid-feedback">{{$message }}</div>
          @enderror
        </div>
        
        <button class="btn btn-primary w-50" type="submit" id="register">Register</button>
      </form>

      <small class="d-block text-center mt-3 text-white">have an account?<a href="/login">Login Here</a></small>
  </main>
  </div>
</div>
@endsection