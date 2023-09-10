@extends('admin.layouts.main')
@section('container')
<h1 class="h2">CREATE NEW POST</h1>
<div class="col-lg-8">
    <form method="POST" action="/dashboard/categories" class="mb-5" enctype="multipart/form-data">  
        {{-- enctype itu untuk ambil file --}}
        {{-- masuk ke method store di dashpostcontr --}}
        @csrf
        <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" >

        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        </div>

        <div class="mb-3">
        <label for="slug" class="form-label @error('slug') is-invalid @enderror">Slug</label>
        <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') }}"  readonly >

        @error('slug')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Category Image</label>
            {{-- ini bawah, biar bisa preview image --}}
            <img class="img-preview img-fluid mb-3 col-sm-5">
            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" onchange="previewImage()">

            @error('image')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        </div>


        <script>
            const name = document.querySelector("#name");
            const slug = document.querySelector("#slug");
    
            name.addEventListener("change", function() { //bisa jadi keyup ato change
                let preslug = name.value;
                preslug = preslug.replace(/ /g,"-"); //replace smua spasi di tulisan jd -
                slug.value = preslug.toLowerCase();
            });

            document.addEventListener('trix-file-accept',function(e){
                e.preventDefault();
            })


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

       
        <button type="submit" class="btn btn-primary">Create Category</button>
    </form>
</div>
@endsection