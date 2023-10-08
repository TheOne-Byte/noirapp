{{-- BUAT HALAMAN DETAIL POST --}}
@extends('layouts/main')
@section('container')

    <div class="container">
        <div class="row justify-content-center mb-5">

            <div class="col-md-4 d-inline-block justify-content-right">

                <img style="border-radius: 10px" src="https://source.unsplash.com/400x500?{{ $user->username }}" class="img-fluid" alt="{{ $user->username }}">

                <h2 class="mb-3 mt-2">{{ $user->username }}</h2>

                <div class="col-md-4 d-inline">
                    <a href="/addtocart/{{ $user->username }}" class="btn">Order</a>
                    <button type="submit" class="btn-chat" data-chat-with="{{ $user->id }}" onclick="window.location.href='/chatify'"><i class="bi bi-chat-heart"></i> Chat</button>
                    <i class="bi bi-calendar" onclick="openSchedulePage('{{ $user->id }}')"></i>

                </div>
            </div>

            <div class="col-md-3">
                <p style="font-size: 2rem; color:orange; font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif">Skill</p>
                <hr>

                <div class="row">
                    <div class="col-md-5">
                        <img style="border-radius: 10px" src="https://source.unsplash.com/40x50/?game" class="card-img-top" alt="...">
                    </div>
                    <div class="col-md-6 text-white mt-5" >
                        {{ $user -> category -> name }}

                        <div class="price mt-1"><i class="bi bi-coin"></i> {{ $user->price }} / match</div>
                    </div>
                </div>

                <p class="mt-4" style="font-size: 2rem; color:orange; font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif">Bio</p>
                <hr>
                <div class="informasi">
                        <p>{{ $user->body }}</p>
                </div>

            </div>
        </div>
    </div>
    <script>
        function openSchedulePage(userId) {
            window.open(`/schedule/${userId}`, '_blank');
        }
    </script>
@endsection




