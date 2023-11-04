@extends('layouts/main')
<link rel="stylesheet" href="/css/order.css" >
@section('container')
    <form action="/addtocart" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        <table id="cart" class="table table-hover table-condensed text-white">
            <thead>
            <tr>
                <th style="width:50%">Product</th>
                <th style="width:10%">Price</th>
                <th style="width:10%"></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td data-th="Product">
                    <div class="row">
                        <div class="col-sm-3 hidden-xs"><img src="http://placehold.it/100x100" alt="..." class="img-responsive"/></div>
                        <div class="col-sm-9">
                            <h4 class="nomargin">{{ $user->role->name }}</h4>
                            <p>{{ $user->username }}</p>
                        </div>
                    </div>
                </td>

                <td data-th="Price">{{ $user->price }}</td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <td><button type="submit" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</button></td>
                <td colspan="2" class="hidden-xs"></td>
                <input type="hidden" name="price" id="price" value="{{ $user->price }}">
            </tr>
            </tfoot>
        </table>
    </form>
@endsection
