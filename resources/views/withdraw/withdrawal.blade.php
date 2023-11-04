@extends('layouts/main')
@section('container')

    <div class="row justify-content-center text-center">
        <div class="col-md-12 mt-5">
            <form action="/withdrawal" method="POST">
            @csrf
            @if(session()->has('error'))
            <div class="alert alert-danger col-md-12" role="alert">
                <h3 style="color: #141432"> {{ session('error') }}</h3>
            </div>
            @elseif(session()->has('success'))
            <div class="alert alert-success col-md-12" role="alert">
                <h3 style="color: #141432"> {{ session('success') }}</h3>
            </div>
            @else
            <div class="alert alert-primary col-md-12" role="alert">
                <h3 style="color: #141432">Withdrawal Request</h3>
            </div>
            @endif

        </div>
        <div class="text-white">
            <label for="Withdrawal">Your Gatcha Balance Now : {{ auth()->user()->points == null | 0 ? 0 : auth()->user()->points }}</label>
        </div>
        <div class="col-md-4 mt-5 text-center">
            <div class="form-floating">
                <label for="Withdrawal">Your Balance Now : {{ auth()->user()->points }}</label>
            </div>
            <div class="form-floating">
                <input value="{{ old('Withdrawal') }}" type="number" class="mb-2 form-control  @error('Withdrawal') is-invalid @enderror rounded-bottom" id="Withdrawal" placeholder="Withdrawal" name="Withdrawal">
                <label for="Withdrawal">Withdrawal number</label>
                @error('Withdrawal')
                <div class="invalid-feedback">{{$message }}</div>
                @enderror
            </div>
        </div>        
    </div>     
    
    <div class="row justify-content-center text-center">
        <div class="col-md-5">

        <button class="btn btn-primary w-30 " type="submit" id="idnumcardreq">Withdraw</button>
    </div>

    </div>
    </form>

@endsection
