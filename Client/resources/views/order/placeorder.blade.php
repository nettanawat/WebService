@extends('master')

@section('title', 'Place order')

@section('content')


@if (isset($response_order_message))
<div id="responseBack">
    @if($response_order_message == 'success')
    <div class="alert alert-success text-center">
            <h3>{{ $response_order_message }}</h3>
            <li><h4>{{ $response_order_message_detail }}</h4></li>
    </div>
    @else
    <div class="alert alert-danger  text-center">
        <ul>
            <li>{{ $response_order_message }}</li>
            <li><h4>{{ $response_order_message_detail }}</h4></li>
        </ul>
    </div>
    @endif
</div>

@endif

<div class="container-fluid">
    <div class="col-md-12 text-center">
        <h1>--Place order--</h1>
    </div>
    <form method="post" action="http://localhost:8000/api/order/placeorder">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <h2 class="col-md-12">Customer Information</h2>
        <div class="col-md-6 form-group">
            <label>Customer name</label>
            <input type="text" name="customer_name" class="form-control">
        </div>
        <div class="col-md-6 form-group">
            <label>Customer email</label>
            <input type="email" name="customer_email" class="form-control">
        </div>
        <div class="col-md-6 form-group">
            <label>Customer phone number</label>
            <input type="text" name="customer_phone_number" class="form-control">
        </div>
        <hr class="col-md-12">

        <h2 class="col-md-12">Customer Address</h2>
        <div class="col-md-6 form-group">
            <label>Address line1</label>
            <input type="text" name="line1" class="form-control">
        </div>
        <div class="col-md-6 form-group">
            <label>Address line2</label>
            <input type="text" name="line2" class="form-control">
        </div>
        <div class="col-md-6 form-group">
            <label>District</label>
            <input type="text" name="district" class="form-control">
        </div>
        <div class="col-md-6 form-group">
            <label>Province</label>
            <input type="text" name="province" class="form-control">
        </div>
        <div class="col-md-6 form-group">
            <label>Post code</label>
            <input type="text" name="post_code" class="form-control">
        </div>



        <hr class="col-md-12">

        <h2 class="col-md-12">Product</h2>
        <div class="col-md-6 form-group">
            <label>Select product</label>
            <select class="form-control" name="product_id">
                @foreach($response_data as $product)
                    <option value="{{$product['id']}}">{{$product['product']}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6 form-group">
            <label>Amount</label>
            <input type="text" name="amount" class="form-control">
        </div>
        <div class="col-md-6 form-group">
            <input type="submit" class="btn btn-default" value="Place order">
        </div>

    </form>
</div>

<script type="text/javascript">
    $('#responseBack').delay(3000).fadeOut()
</script>
@endsection