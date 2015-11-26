@extends('master')

@section('title', 'Product Category')

@section('content')
<!--count($records)-->

<div class="container-fluid">
    <div class="col-md-12 text-right">
        <a href="/productcategory/add" class="btn btn-default">Add Product Category</a>
    </div>
    <h2 class="col-md-12">Orders</h2>

    <div class="row">
        <table class="table table-striped">
            <tr>
                <th>category_id</th>
                <th>name</th>
                <th>slug</th>
                <th>created_at</th>
                <th>updated_at</th>
                <th>actions</th>
            </tr>
            @foreach($productCategories as $productCategory)

            <tr>
                <th>{{$productCategory->id}}</th>
                <th>{{$productCategory->name}}</th>
                <th>{{$productCategory->slug}}</th>
                <th>{{$productCategory->created_at}}</th>
                <th>{{$productCategory->updated_at}}</th>
                <th>-</th>
            </tr>
            @endforeach
        </table>
    </div>
</div>


@endsection