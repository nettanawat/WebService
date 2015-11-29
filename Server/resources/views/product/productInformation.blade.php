@extends('master')

@section('title', 'Product Information')

@section('content')


<div class="container">
    <div class="col-md-12">
        <div class="panel panel-info">
            <!-- Default panel contents -->
            <div class="panel-heading">
                <h2>{{$product->name}}</h2>
            </div>
            <div class="panel-body">
                <h3>Main category : {{$product->productSubCategory->productCategory->name}}</h3>
                <h4>Sub category : {{$product->productSubCategory->name}}</h4>
            </div>
            <!-- List group -->
            <ul class="list-group">
                <li class="list-group-item">In stock : {{$product->amount}}</li>
                <li class="list-group-item">Cost : {{$product->cost}}</li>
                <li class="list-group-item">Price : {{$product->price}}</li>
                <li class="list-group-item">Added at : {{$product->created_at}}</li>
            </ul>
        </div>
    </div>

</div>

@endsection