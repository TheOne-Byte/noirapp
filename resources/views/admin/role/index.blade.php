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
<h1 class="h2">ROLE REQUEST</h1>

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
        <th scope="col">Game Category</th>
        <th scope="col">Role</th>
        <th scope="col">Image</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>

    @foreach($permissions as $permission)
      <tr class="text-center">
        <td>{{ $loop ->iteration }}</td>
        <td>{{ $permission->user->name }}</td>
        <td>{{ $permission->category->name }}</td>
        <td>{{ $permission->role->name }}</td>
        <td>
            <button type="button" value="{{ $permission->id }}" class="badge bg-info showbtn" data-image-src="{{ asset('storage/' . $permission->image_url) }}"><span class="bi bi-eye " style="color: black"></span></button>
        </td>
        <td>
            <form action="/dashboard/role" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="id" value="{{  $permission->id  }}">
                <button type="submit" class="badge bg-success border-0" onclick="return confirm('Accept This User Role Request?')"><i class="bi bi-check2" style="color: black"></i></button>
            </form>
            <form action="/dashboard/role/{{$permission->id}}" method="POST" class="d-inline">
              @method('delete')
              @csrf
              <button type="submit" class="badge bg-danger border-0" onclick="return confirm('are you sure deleting this?')"><span class="bi bi-trash " style="color: white"></span></button>
            </form>
        </td>
      </tr>
    </tbody>
    @endforeach
  </table>
</div>
</div>
<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="imagePreview" src="" alt="Image Preview" width="100%">
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $(document).on('click', '.showbtn', function () {
        var imageSrc = $(this).data('image-src');
        var imageText = $(this).data('image-text'); // Assuming you have a data attribute for text
        $('#imagePreview').attr('src', imageSrc);
        $('#imageText').text(imageText); // Set the text content
        $('#imageModal').modal('show');
    });
});

    </script>


@endsection

@section('scripts')
<script>
    $( document ).ready(function() {
        $(document).on('click','.showbtn',function(){
            var permi_id = $(this).val();
        });
    });
</script>
@endsection
