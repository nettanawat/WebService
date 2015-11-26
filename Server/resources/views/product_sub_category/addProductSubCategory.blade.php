@extends('master')

@section('title', 'Add Product Sub Category')

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

    <h2 class="col-md-12">Add Product Sub Category</h2>

    <div class="row">
        <form class="col-md-12" action="/productsubcategory" method="post">
            <div class="col-md-6 form-group">
                <label>Product Category Name</label>
                <input type="text" class="form-control" name="name">
            </div>
            <div class="col-md-6 form-group">
                <label>Product Category Name</label>
                <select class="form-control" name="product_category_id">
                    @foreach($productCategories as $productCategory)
                        <option value="{{$productCategory->id}}">{{$productCategory->name}}</option>
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="col-md-12 form-group">
                <input type="submit" class="btn btn-default" value="Add">
            </div>
        </form>
    </div>
</div>


@endsection