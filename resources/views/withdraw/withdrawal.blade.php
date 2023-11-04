@extends('layouts/main')
@section('container')

    <div class="row justify-content-center text-center">
        <div class="col-md-12 mt-5">
            <form action="/withdrawal/request" method="POST">
            @csrf
            <div class="alert alert-danger col-md-12" role="alert">
                <h3 style="color: #141432">Withdrawal Request</h3>
            </div>
        </div>
        <div class="col-md-4 mt-5 text-center">
            <div class="form-floating">
                <label for="Withdrawal">Your Balance Now : {{ auth()->user->points }}</label>
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

        <button class="btn btn-primary w-30 " type="submit" id="idnumcardreq">Register</button>
    </div>

    </div>
    </form>

@endsection
