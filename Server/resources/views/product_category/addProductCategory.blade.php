@extends('master')

@section('title', 'Product Category')

@section('content')

@if (count($errors) > 0)
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="container">

    <h2 class="col-md-12">Add Product Category</h2>

    <div class="row">
        <form class="col-md-12" action="/productcategory" method="post">
            <div class="col-md-6 form-group">
                <label>Product Category Name</label>
                <input type="text" class="form-control" name="name">
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="col-md-12 form-group">
                <input type="submit" class="btn btn-default" value="Add">
            </div>
        </form>
    </div>
</div>


@endsection