@extends('master')

@section('title', 'Order')

@section('content')
<!--count($records)-->

<div class="container-fluid">
    <h2>Orders</h2>
    <div class="row">
        <table class="table table-striped">
            <tr>
                <th>order_id</th>
                <th>customer</th>
                <th>product</th>
                <th>amount</th>
                <th>total_price</th>
                <th>status</th>
                <th>actions</th>
            </tr>
            @foreach($orders as $order)
                {{$order->orderDetail->product}}
            @endforeach
        </table>
    </div>
</div>


@endsection