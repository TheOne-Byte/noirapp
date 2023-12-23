@extends('admin.layouts.main')
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
@section('container')
<h1 class="h2">REPORT DETAIL</h1>

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
        <th scope="col">Reporter(s)</th>
        <th scope="col">Reason</th>
        <th scope="col">Details</th>
        <th scope="col">Photo</th>
      </tr>
    </thead>
    <tbody>

    @foreach($reports as $report)
      <tr class="text-center">
        <td>{{ $loop ->iteration }}</td>
        <td>{{ $report->buyer->username }}</td>
        <td>{{ $report->header }}</td>
        <td>{{ $report->detail }}</td>
        <td>
            <button type="button" class="badge bg-info showbtn" data-toggle="modal" data-target="#imageModal{{ $report->id }}"><span class="bi bi-eye " style="color: black"></span></button>
        </td>

      </tr>
    </tbody>
    <div class="modal fade" id="imageModal{{ $report->id }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $report->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="imageModalLabel{{ $report->id }}">Image Preview</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body text-center">
              <img src="{{ asset('storage/' . $report->image) }}" alt="Uploaded Image" style="max-width: 100%;">
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </table>
</div>
</div>



@endsection

