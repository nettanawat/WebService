@extends('master')

@section('title', 'Managing order')

@section('content')


@if(Session::has('response_order_message'))
<div id="alert" class="alert alert-success">
        {{ Session::get('flash_message') }}
</div>
@endif


<div class="container-fluid">
    <div class="col-md-12 text-right">
        <a href="/order/placeorder" class="btn btn-default">Place order</a>
    </div>
    <div class="col-md-12 text-center">
        <h1>Order</h1>
    </div>
    <table class="table">
        <tr>
            <th>id</th>
            <th>order_id</th>
            <th>product_id</th>
            <th>product_name</th>
            <th>product_amount</th>
            <th>status</th>
            <th>is_paid</th>
            <th>action</th>
        </tr>
        @foreach($orders as $order)
        <tr>
            <td>{{$order->id}}</td>
            <td>{{$order->server_order_id}}</td>
            <td>{{$order->product_id}}</td>
            <td>{{$order->product_name}}</td>
            <td>{{number_format($order->product_amount)}}</td>
            @if($order->status==0)
                <td>pending</td>
            @elseif($order->status==1)
                <td style="color: #31708f"><strong>confirmed</strong></td>
            @else
                <td style="color: red"><strong>canceled</strong></td>
            @endif
            @if($order->is_paid==0)
                <td style="color: orange"><strong>pending</strong></td>
            @else
                <td style="color: darkgreen"><strong>paid</strong></td>
            @endif
            <td>
                @if($order->status==0)
                <form action="/order/cancel" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="order_id" value="{{$order->id}}">
                    <input type="hidden" name="server_order_id" value="{{$order->server_order_id}}">
                    <input type="submit" value="Cancel order" class="btn btn-xs btn-danger">
                </form>
                @endif
            </td>
        </tr>
        @endforeach
    </table>

</div>

<script type="text/javascript">
    $('#alert').delay(3000).fadeOut()
</script>
@endsection