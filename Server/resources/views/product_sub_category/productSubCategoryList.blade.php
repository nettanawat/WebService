@extends('master')

@section('title', 'Product Category')

@section('content')
<!--count($records)-->

<div class="container-fluid">
    <div class="col-md-12 text-right">
        <a href="/productsubcategory/add" class="btn btn-default">Add Product Sub Category</a>
    </div>
    <h2 class="col-md-12">Product Sub Category</h2>

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
            @foreach($productSubCategories as $productSubCategory)
            <tr>
                <td>{{$productSubCategory->id}}</td>
                <td>{{$productSubCategory->name}}</td>
                <td>{{$productSubCategory->slug}}</td>
                <td>{{$productSubCategory->created_at}}</td>
                <td>{{$productSubCategory->updated_at}}</td>
                <td>-</td>
            </tr>
            @endforeach
        </table>
    </div>
</div>


@endsection