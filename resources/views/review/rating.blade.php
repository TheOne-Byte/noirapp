
@extends('layouts/main')
<link rel="stylesheet" href="/css/rating.css" >
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
@section('container')
@section('container')
<div class="container col-md-4 mt-5">
    <div class="card">
        <div class="card-body">
            <div class="row justify-content-center">
                <form class="form-horizontal poststars" action="/rating" id="addStar" method="POST">
                @csrf
                <div class="form-group required">
                    <div class="col-md-12">
                    <input class="star star-5" value="5" id="star-5" type="radio" name="star">
                    <label class="star star-5" for="star-5"></label>
                    <input class="star star-4" value="4" id="star-4" type="radio" name="star"/>
                    <label class="star star-4" for="star-4"></label>
                    <input class="star star-3" value="3" id="star-3" type="radio" name="star"/>
                    <label class="star star-3" for="star-3"></label>
                    <input class="star star-2" value="2" id="star-2" type="radio" name="star"/>
                    <label class="star star-2" for="star-2"></label>
                    <input class="star star-1" value="1" id="star-1" type="radio" name="star"/>
                    <label class="star star-1" for="star-1"></label>
                    </div>        
                </div>
                    
                <div class="col-md-4">
                    <button type="submit">Submit</button>
                </div>
            </form>  
            </div>
        </div>
    </div>
</div>
  <script>
    $('#addStar').change('.star', function(e) {
    $(this).submit();
    });
</script>
  @endsection
