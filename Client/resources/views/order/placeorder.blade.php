@extends('master')

@section('title', 'Place order')

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
    <div class="col-md-12 text-center">
        <h1>--Place order--</h1>
    </div>
    <form method="post" action="/order">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <h2 class="col-md-12">Customer Information</h2>
        <div class="col-md-6 form-group">
            <label>Customer name</label>
            <input type="text" name="customer_name" class="form-control" value="NAIVE Bakery" readonly>
        </div>
        <div class="col-md-6 form-group">
            <label>Customer email</label>
            <input type="email" name="customer_email" class="form-control" value="naivebakery@naivecoporation.com" readonly>
        </div>
        <div class="col-md-6 form-group">
            <label>Customer phone number</label>
            <input type="text" name="customer_phone_number" class="form-control" value="+66(0)2-888-1549" readonly>
        </div>
        <hr class="col-md-12">

        <h2 class="col-md-12">Customer Address</h2>
        <div class="col-md-6 form-group">
            <label>Select branch</label>
            <select class="form-control" id="selectBranch">
                <option value="1">Please select branch</option>
                <option value="1">Chiang Mai</option>
                <option value="2">Pathumthani</option>
                <option value="3">Nonthaburi</option>
                <option value="4">Phuket</option>
            </select>
        </div>
        <div class="col-md-6 form-group">
            <label>Address line1</label>
            <input type="text" name="line1" id="line1" class="form-control" readonly>
        </div>
        <div class="col-md-6 form-group">
            <label>Address line2</label>
            <input type="text" name="line2" id="line2" class="form-control" readonly>
        </div>
        <div class="col-md-6 form-group">
            <label>District</label>
            <input type="text" name="district" id="district" class="form-control" readonly>
        </div>
        <div class="col-md-6 form-group">
            <label>Province</label>
            <input type="text" name="province" id="province" class="form-control" readonly>
        </div>
        <div class="col-md-6 form-group">
            <label>Post code</label>
            <input type="text" name="post_code" id="post_code" class="form-control" readonly>
        </div>



        <hr class="col-md-12">

        <h2 class="col-md-12">Product</h2>
        <div class="col-md-6 form-group">
            <label>Select product</label>
            <select class="form-control" name="product_id" id="selectProduct">
                @foreach($response_data as $product)
                    <option value="{{$product['id']}}">{{$product['name']}}</option>
                @endforeach
            </select>
            <input type="hidden" name="product_name" class="form-control" id="productNameId" value="">
        </div>

        <div class="col-md-6 form-group">
            <label>Amount</label>
            <input type="text" name="amount" id="amountId" class="form-control">
        </div>
        <div class="col-md-6 form-group">
            <input id="submitOrder" type="submit" class="btn btn-default" value="Place order">
        </div>

    </form>
</div>

<script type="text/javascript">
    $( document ).ready(function() {
        var name = $( "#selectProduct option:selected").text();
        $("#productNameId").val(name);
    });

    $( "#selectProduct" ).change(function() {
        var name = $( "#selectProduct option:selected").text();
        $("#productNameId").val(name);
    });

    $( "#selectBranch" ).change(function() {
        var selectBranch = $( "#selectBranch").val();

        if(selectBranch == 1) {
            $( "#line1").val("40 Nimmarnhemin Rd., T.Suthep");
            $( "#district").val("Muang");
            $( "#province").val("Chiang Mai");
            $( "#post_code").val("50200");
        } else if(selectBranch == 2) {
            $( "#line1").val("182/3 Pathum-Samkoke Rd., T.Bangprok");
            $( "#district").val("Muang");
            $( "#province").val("Pathumthani");
            $( "#post_code").val("12000");
        } else if(selectBranch == 3) {
            $( "#line1").val("23/67 Nana Rd., T.Bangkruay");
            $( "#district").val("Muang");
            $( "#province").val("Nonthaburi");
            $( "#post_code").val("22000");
        }else if(selectBranch == 4) {
            $( "#line1").val("177/36 Moo 4 Srisoonthorn Road, T.Srisoonthorn");
            $( "#district").val("Thalang");
            $( "#province").val("Phuket");
            $( "#post_code").val("83110");
        } else {

        }
    });
</script>
@endsection