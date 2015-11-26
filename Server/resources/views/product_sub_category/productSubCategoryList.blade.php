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
                <th>{{$productSubCategory->id}}</th>
                <th>{{$productSubCategory->name}}</th>
                <th>{{$productSubCategory->slug}}</th>
                <th>{{$productSubCategory->created_at}}</th>
                <th>{{$productSubCategory->updated_at}}</th>
                <th>-</th>
            </tr>
            @endforeach
        </table>
    </div>
</div>


@endsection