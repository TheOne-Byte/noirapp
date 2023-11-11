{{-- BUAT HALAMAN DETAIL POST --}}
@extends('layouts/main')

@section('container')
    <style>
        .carousel-image,
        .carousel-video {
            height: 300px;
            /* Set the desired height for your images and videos */
            object-fit: cover;
            /* Ensures the content is completely covered while maintaining aspect ratio */
        }

        /* Adjust the position of carousel controls */
        .carousel-control-prev,
        .carousel-control-next {
            width: auto;
            /* Allow the buttons to adjust their width based on the content */
            padding: 0 15px;
            /* Add some padding to the buttons */
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 30px;
            /* Set the width of the carousel control icons */
            height: 30px;
            /* Set the height of the carousel control icons */
        }
    </style>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-4 d-inline-block justify-content-right">
                <div id="imageVideoCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @if ($user->updateSingleBlade->image_path != NULL)
                            <div class="carousel-item active">
                                <img src="{{ asset('storage/' . $user->updateSingleBlade->image_path) }}"
                                    class="d-block w-100 carousel-image" alt="Profile Image">
                            </div>
                        @endif
                        @if ($user->updateSingleBlade->video_path)
                            <div class="carousel-item @unless ($user->updateSingleBlade->image_path) active @endunless">
                                <video class="d-block w-100 carousel-video" controls>
                                    <source src="{{ asset('storage/' . $user->updateSingleBlade->video_path) }}"
                                        type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        @endif
                    </div>
                    <a class="carousel-control-prev" href="#imageVideoCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#imageVideoCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
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
                <p class="mt-4" style="font-size: 2rem; color:orange; font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif">Available Times</p>
                <hr>
                <div class="informasi">
                    <ul>
                        @foreach($availableTimes as $availableTime)
                        @php
                            $startTime = strtotime($availableTime->start_time);
                            $endTime = strtotime($availableTime->end_time);
                            $day = $availableTime->day;
                        @endphp

                        <li>
                            {{ date('H:i', $startTime) }} - {{ date('H:i', $endTime) }}
                            ({{ date('l', strtotime($day)) }})
                        </li>
                    @endforeach
                    </ul>
                </div>

                @if (isset($image) && isset($video))
                    <!-- Display image and video for role request -->
                    <img src="{{ asset('storage/' . $image) }}" alt="Image">
                    <video controls>
                        <source src="{{ asset('storage/' . $video) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @elseif(isset($bio) && isset($image) && isset($video))
                    <!-- Display updated data for update request -->
                    <p>Bio: {{ $bio }}</p>
                    <img src="{{ asset('storage/' . $image) }}" alt="Image">
                    <video controls>
                        <source src="{{ asset('storage/' . $video) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @else
                    <!-- Handle other cases or show an error message -->
                    <p>Error: Invalid request</p>
                @endif

            </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('scheduleForm');
            form.addEventListener('submit', function(event) {
                const dateInput = document.getElementById('date');
                const selectedDate = new Date(dateInput.value);

                const availableDays = [@foreach($availableTimes as $availableTime) '{{ date("D", strtotime($availableTime->day)) }}', @endforeach];

                const selectedDay = selectedDate.toLocaleDateString('en-US', { weekday: 'short' });

                if (!availableDays.includes(selectedDay)) {
                    event.preventDefault();
                    alert('Tanggal tidak tersedia. Silakan pilih tanggal lain.');
                }
            });
        });
        @if(session('error'))
        // Show a JavaScript alert with the error message
        alert('{{ session('error') }}');
        @endif
    </script>
@endsection
