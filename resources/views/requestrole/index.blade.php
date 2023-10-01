@extends('layouts/main')
@section('container')
<div class="row justify-content-center">
    <div class="col-lg-5">
    @if(session()->has('success'))
      <div class="alert alert-success col-lg-5" role="alert">
          {{ session('success') }}
      </div>
    @endif

    @if(session()->has('danger'))
      <div class="alert alert-danger col-lg-5" role="alert">
          {{ session('danger') }}
      </div>
    @endif
    <main class="form-registration">

      <h1 class="h3 mb-3 fw-normal text-center" id="registertext">Request Role Form</h1>
        <form action="/role/request" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="form-floating">
            <div class="">
                <label for="gamecategory" class="text-white">Game Category</label>
            </div>
                <select class="form-select" id="category" name="category_id" >
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? ' selected' : ' ' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
          </div>

          <div class="form-floating mt-2">
            <div class="text-white">
                <label for="rolecategory">Role</label>
            </div>
            <select class="form-select" id="role" name="role_id" >
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? ' selected' : ' ' }}>{{ $role->name }}</option>
                @endforeach
            </select>
          </div>

          <div class="form-floating mt-2">
            <div class="text-white">
                <label for="price">Price</label>
            </div>
            <input style="border-radius: 5px"  value="{{ old('price',100) }}" type="number" class="mb-2 form-control @error('price') is-invalid @enderror" id="price" placeholder="price" name="price">

            @error('price')
            <div class="invalid-feedback">{{$message }}</div>
            @enderror
          </div>

          <div class="mb-3 text-white">
            <label for="image" class="form-label">Upload Your Game Skill Image</label>
            {{-- ini bawah, biar bisa preview image --}}
            <img class="img-preview img-fluid mb-3 col-sm-5">
            <input class="form-control @error('image') is-invalid @enderror" style="border-radius: 5px" type="file" id="image" name="image" onchange="previewImage()">

            @error('image')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        </div>
        <div class="form-floating mt-2">
            <div class="text-white">
                <label for="available_times">Available Times</label>
            </div>

            <div class="row">
                <div class="col">
                    @for ($i = 0; $i < 7; $i++)
                        @php
                            $dayName = date('l', strtotime("Sunday +$i days"));
                        @endphp
                        <label for="{{ $dayName }}" class="form-check-label text-white">
                            {{ $dayName }}<br>
                            <input type="checkbox" name="available_days[{{ $dayName }}]" value="{{ $dayName }}">
                        </label>
                    @endfor
                    <div class="form-floating mt-2">
                        <div class="text-white">
                            <label for="available_times">Choose Time</label>
                        </div>
                        <select name="available_time_start" class="form-select mb-2">
                            @for ($hour = 0; $hour <= 23; $hour++)
                                @for ($minute = 0; $minute <= 59; $minute += 15)
                                    <option value="{{ sprintf('%02d:%02d', $hour, $minute) }}">{{ sprintf('%02d:%02d', $hour, $minute) }}</option>
                                @endfor
                            @endfor
                        </select>
                        <select name="available_time_end" class="form-select mb-2">
                            @for ($hour = 0; $hour <= 23; $hour++)
                                @for ($minute = 0; $minute <= 59; $minute += 15)
                                    <option value="{{ sprintf('%02d:%02d', $hour, $minute) }}">{{ sprintf('%02d:%02d', $hour, $minute) }}</option>
                                @endfor
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
        </div>
          <button class="btn btn-primary w-50" type="submit" id="register">Request now</button>
        </form>

    </main>
    </div>

    <script>
        function previewImage(){
            const image = document.querySelector('#image');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';
            const ofReader = new FileReader();
            ofReader.readAsDataURL(image.files[0]);

            ofReader.onload = function(oFREvent ){
                imgPreview.src = oFREvent.target.result;
            }
            }
    </script>

  </div>
@endsection
