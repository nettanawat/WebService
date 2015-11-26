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

    <h2 class="col-md-12">Add Product</h2>

    <div class="row">
        <form class="col-md-12" action="/product" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="col-md-6 form-group">
                <label>Product Name</label>
                <input type="text" class="form-control" name="name">
            </div>
            <div class="col-md-6 form-group">
                <label>Amount</label>
                <input type="text" class="form-control" name="amount">
            </div>
            <div class="col-md-6 form-group">
                <label>Cost (each)</label>
                <input type="text" class="form-control" name="cost">
            </div>
            <div class="col-md-6 form-group">
                <label>Price</label>
                <input type="text" class="form-control" name="price">
            </div>
            <div class="col-md-6 form-group">
                <label>Product Sub Category</label>
                <select class="form-control" name="product_sub_category_id">
                    @foreach($productSubCategories as $productSubCategory)
<!--                    <optgroup label="_________">-->
                        <option value="{{$productSubCategory->id}}">{{$productSubCategory->name}}</option>
<!--                    </optgroup>-->
                    @endforeach
                </select>
            </div>
            <div class="col-md-12 form-group">
                <input type="submit" class="btn btn-default" value="Add">
            </div>
        </form>
    </div>
</div>

@endsection