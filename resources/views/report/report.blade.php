@extends('layouts/main')

@section('container')
    <div class="container">
        @if (session()->has('success'))
        <div class="alert alert-success col-lg-5" role="alert">
            {{ session('success') }}
        </div>
    @endif
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Report</h2>

                        <form action="/createreport" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <div class="form-floating mt-2">
                                <div class="text-white">
                                    <label for="header">Report Header</label>
                                </div>
                                <input style="border-radius: 5px" value="{{ old('header') }}" type="text"
                                    class="mb-1 form-control @error('header') is-invalid @enderror" id="header" placeholder="header"
                                    name="header">

                                @error('header')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-floating mt-2">
                                <div class="text-white">
                                    <label for="header">Report Detail</label>
                                </div>
                                <input style="border-radius: 5px" value="{{ old('detail') }}" type="text"
                                    class="mb-1 form-control @error('detail') is-invalid @enderror" id="detail" placeholder="detail"
                                    name="detail">

                                @error('detail')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 text-white">
                                <label for="image" class="form-label">Upload Image</label>
                                {{-- ini bawah, biar bisa preview image --}}
                                <img class="img-preview img-fluid mb-3 col-sm-5">
                                <input class="form-control @error('image') is-invalid @enderror" style="border-radius: 5px"
                                    type="file" id="image" name="image" onchange="previewImage()">

                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Send Report</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function previewImage() {
                const image = document.querySelector('#image');
                const imgPreview = document.querySelector('.img-preview');

                imgPreview.style.display = 'block';
                const ofReader = new FileReader();
                ofReader.readAsDataURL(image.files[0]);

                ofReader.onload = function(oFREvent) {
                    imgPreview.src = oFREvent.target.result;
                }
            }
    </script>

@endsection
