@extends('master')

@section('title', 'Product')

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

<div class="container-fluid">
    <div class="col-md-12 text-right">
        <a href="/product/add" class="btn btn-default">Add Product</a>
    </div>
    <h2 class="col-md-12">Product</h2>

    <div class="row">
        <table class="table table-hover text-center">
            <tr>
                <th class="text-center">product_id</th>
                <th class="text-center">product_name</th>
                <th class="text-center">in_stock (unit)</th>
                <th class="text-center">cost</th>
                <th class="text-center">price</th>
                <th class="text-center">sub_category</th>
                <th class="text-center">main_category</th>
                <th class="text-center">created_at</th>
                <th class="text-center">updated_at</th>
                <th class="text-center">action</th>
            </tr>
            @foreach($products as $product)
            <tr>
                <td>{{$product->id}}</td>
                <td>{{$product->name}}</td>
                <td>{{$product->amount}}</td>
                <td>{{$product->cost}}</td>
                <td>${{$product->price}}</td>
                <td>{{$product->productSubcategory->name}}</td>
                <td>{{$product->productSubcategory->productCategory->name}}</td>
                <td>{{$product->created_at}}</td>
                <td>{{$product->updated_at}}</td>
                <td>-</td>
            </tr>
            @endforeach
        </table>

    </div>
</div>




@endsection