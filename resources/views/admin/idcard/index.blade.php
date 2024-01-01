@extends('admin.layouts.main')
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap JS and dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
@section('container')
<h1 class="h2">ID CARD NUMBER REQUEST</h1>

@if(session()->has('success'))
<div class="alert alert-success col-lg-5" role="alert">
  {{ session('success') }}
</div>
@endif

<div class="table-responsive small col-lg-5">
  <table class="table table-striped table-sm ">
    <thead>
      <tr class="text-center">
        <th scope="col">#</th>
        <th scope="col">Username</th>
        <th scope="col">Name</th>
        <th scope="col">Id Card Number</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>

      @foreach($users as $user)
      <tr class="text-center">
        <td>{{ $loop ->iteration }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->username }}</td>
        <td>{{ $user->idcardnumber }}</td>
        <td>
          <form action="/dashboard/idcard" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="id" value="{{  $user->id  }}">
            <button type="submit" class="badge bg-success border-0"
              onclick="return confirm('Accept This User Id Card Number Request?')"><i class="bi bi-check2"
                style="color: black"></i></button>
          </form>
          <form action="/dashboard/idcard/{{$user->id}}" method="POST" class="d-inline">
            @method('delete')
            @csrf
            <button type="submit" class="badge bg-danger border-0"
              onclick="return confirm('Reject This User Id Card Number Request?')"><i class="bi bi-x"
                style="color: white"></i></button>
          </form>
        </td>
      </tr>
    </tbody>

    @endforeach
  </table>
</div>
</div>



@endsection