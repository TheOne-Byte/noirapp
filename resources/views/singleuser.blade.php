{{-- BUAT HALAMAN DETAIL POST --}}
@extends('layouts/main')

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>

@section('container')
    <style>
        .carousel-control-prev, .carousel-control-next {
            background-color: orange;
        }
        .carousel-controls {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 0 20px;
            z-index: 1;
        }

        .carousel-control-prev {
            left: 1em;
            margin-left: 325px;
        }

        .carousel-control-next {
            right: 1em;
            margin-right: 350px;

        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 30px;
            height: 30px;
            background-size: 100%;
            filter: invert(1);
        }

        .carousel-item img,
        .carousel-item video {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }
    </style>

    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-4 d-inline-block justify-content-right">
                <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @if (
                            !empty($user->updateSingleBlade->image_path) &&
                                !empty($user->updateSingleBlade->video_path) &&
                                $user->updateSingleBlade->is_approved === 1)
                            <!-- Display content when both image_path and video_path are not empty and is_approved is 1 -->
                            <div class="carousel-item active">
                                <img src="{{ asset('storage/' . $user->updateSingleBlade->image_path) }}"
                                    class="d-block w-100" alt="Profile Image">
                            </div>
                            <div class="carousel-item">
                                <video class="d-block w-100" controls>
                                    <source src="{{ asset('storage/' . $user->updateSingleBlade->video_path) }}"
                                        type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        @elseif (!$permissions->isEmpty())
                            <!-- Display content based on permissions -->
                            @foreach ($permissions as $permission)
                                @if ($permission->statcode === 'APV')
                                    <div class="carousel-item active">
                                        <img src="{{ asset('storage/' . $permission->image) }}" alt="Uploaded Image"
                                            class="d-block w-100">
                                    </div>
                                    <div class="carousel-item">
                                        <video class="d-block w-100" controls>
                                            <source src="{{ asset('storage/' . $permission->video) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <!-- Display default image when both permissions and updateSingleBlade data are empty -->
                            <div class="carousel-item active">
                                <img src="https://source.unsplash.com/800x400/?game" class="d-block w-100"
                                    alt="Default Image">
                            </div>
                        @endif
                    </div>
                    <div class="carousel-controls">
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>

                <h2 class="mb-3 mt-2">{{ $user->username }}</h2>
                <div class="col-md-4 d-inline">
                    <a href="/addtocart/{{ $user->username }}" class="btn">Order</a>
                    <button type="submit" class="btn-chat" data-chat-with="{{ $user->id }}"
                        onclick="window.location.href='/chatify'"><i class="bi bi-chat-heart"></i> Chat</button>
                </div>
            </div>

            <div class="col-md-3">
                <p
                    style="font-size: 2rem; color:orange; font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif">
                    Skill</p>
                <hr>

                <div class="row">
                    <div class="col-md-5">
                        <img style="border-radius: 10px" src="https://source.unsplash.com/40x50/?game" class="card-img-top"
                            alt="...">
                    </div>
                    <div class="col-md-6 text-white mt-5">
                        {{ $user->category->name }}
                        <div class="price mt-1"><i class="bi bi-coin"></i> {{ $user->price }} / match</div>
                    </div>
                </div>

                <p class="mt-4"
                    style="font-size: 2rem; color:orange; font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif">
                    Bio</p>
                <hr>
                <div class="informasi">
                    @if ($user->updateSingleBlade && $user->updateSingleBlade->approved)
                        <p>{{ $user->updateSingleBlade->updated_bio }}</p>
                    @else
                        <p>{{ $user->body }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
