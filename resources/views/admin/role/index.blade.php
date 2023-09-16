@extends('admin.layouts.main')
@section('container')
<h1 class="h2">ROLE REQUEST</h1>

@if(session()->has('success'))
  <div class="alert alert-success col-lg-5" role="alert">
      {{ session('success') }}
  </div>
@endif

<div class="table-responsive small col-lg-5">
  {{-- <a class="btn btn-primary mb-3" href="/dashboard/categories/create">CREATE NEW CATEGORY</a> --}}
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
        {{-- bs dipake krn dlm foreach --}}
        <td>{{ $permission->user->name }}</td>
        <td>{{ $permission->category->name }}</td>
        <td>{{ $permission->role->name }}</td>
        <td>
        
            <button type="button" value="{{ $permission->id }}" class="badge bg-info showbtn"><span class="bi bi-eye " style="color: black"></span></button>
            {{-- <a href="/dashboard/role/{{ $permission->id }}" class="badge bg-info"><span class="bi bi-eye " style="color: black"></span></a> --}}
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

<script>
    $( document ).ready(function() {
        $(document).on('click','.showbtn',function(){
            var permi_id = $(this).val();
            alert();
        });
    });
</script>

@endsection

@section('scripts')
<script>
    $( document ).ready(function() {
        $(document).on('click','.showbtn',function(){
            var permi_id = $(this).val();
            alert();
        });
    });
</script>
@endsection