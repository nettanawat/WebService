@extends('master')

@section('title', 'Managing order')

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
                <th>order_amount</th>
                <th>in_stock</th>
                <th>total_price</th>
                <th>date</th>
                <th>status</th>
                <th>payment status</th>
                <th>actions</th>
            </tr>
            @foreach($orders as $order)
            @if($order->stock_status == false)
            <tr>
                <td>{{$order->id}}</td>
                <td>{{$order->customer->name}}</td>
                <td><a href="/product/{{$order->orderDetail->product->slug}}">{{$order->orderDetail->product->name}}</a></td>
                <td style="color: red"><strong>{{number_format($order->orderDetail->amount)}}</strong></td>
                <td style="color: red"><strong>{{number_format($order->orderDetail->product->amount)}}</strong></td>
                <td>{{number_format($order->orderDetail->total_price)}}</td>
                <td>{{$order->created_at}}</td>
                @if($order->status == 0)
                    <td id="status{{$order->id}}"><strong>pending</strong></td>
                    @elseif($order->status == 1)
                    <td id="status{{$order->id}}" style="color: #31708f"><strong>confirmed</strong></td>
                    @else
                    <td id="status{{$order->id}}" style="color: red"><strong>canceled</strong></td>
                @endif
                @if($order->is_paid == 0)
                    <td style="color: orange"><strong>pending</strong></td>
                @else
                    <td style="color: darkgreen;"><strong>pending</strong></td>
                @endif
                <td>
                    @if($order->status == 0)
                        <form method="post" action="order/cancel">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="order_id" value="{{$order->id}}">
                            <input type="hidden" name="product_id" value="{{$order->orderDetail->product_id}}">
                            <input type="hidden" name="product_name" value="{{$order->orderDetail->product->name}}">
                            <input type="hidden" name="product_amount" value="{{$order->orderDetail->amount}}">
                            <input type="hidden" name="order_date" value="{{$order->created_at}}">
                        <a tabindex="0" style="color: darkred" role="button" data-placement="left" data-toggle="popover"
                           data-trigger="focus" title="There is not enough product in stock"
                           data-content="Confirm order action is not allowed in this order. {{$order->orderDetail->product->name}} in stock is {{$order->orderDetail->product->amount}} but order amount is {{$order->orderDetail->amount}}"><span class="glyphicon glyphicon-question-sign"></span></a>
                        <button style="background-color: transparent; border: none" id="{{$order->id}}" type="submit" class="cancel" ><span class="glyphicon glyphicon-remove-circle"></span></button>
                    </form>
                    @endif
                </td>
            </tr>
            @else
            <tr>
                <td>{{$order->id}}</td>
                <td>{{$order->customer->name}}</td>
                <td><a href="/product/{{$order->orderDetail->product->slug}}">{{$order->orderDetail->product->name}}</a></td>
                <td>{{number_format($order->orderDetail->amount)}}</td>
                <td>{{number_format($order->orderDetail->product->amount)}}</td>
                <td>{{number_format($order->orderDetail->total_price)}}</td>
                <td>{{$order->created_at}}</td>
                @if($order->status == 0)
                <td id="status{{$order->id}}"><strong>pending</strong></td>
                @elseif($order->status == 1)
                <td id="status{{$order->id}}" style="color: #31708f"><strong>confirmed</strong></td>
                @else
                <td id="status{{$order->id}}" style="color: red"><strong>canceled</strong></td>
                @endif
                @if($order->is_paid == 0)
                    <td style="color: orange"><strong>pending</strong></td>
                @else
                    <td style="color: darkgreen;"><strong>paid</strong></td>
                @endif
                <td>
                    @if($order->status == 0)
                    <form method="post" action="/order/confirm">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="order_id" value="{{$order->id}}">
                        <input type="hidden" name="product_id" value="{{$order->orderDetail->product_id}}">
                        <input type="hidden" name="product_name" value="{{$order->orderDetail->product->name}}">
                        <input type="hidden" name="product_amount" value="{{$order->orderDetail->amount}}">
                        <input type="hidden" name="order_date" value="{{$order->created_at}}">
                        <button style="background-color: transparent; border: none" id="{{$order->id}}" type="submit" class="confirm" ><span class="glyphicon glyphicon-ok-circle"></span></button>
                    </form>

                    <form method="post" action="order/cancel">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="order_id" value="{{$order->id}}">
                        <input type="hidden" name="product_id" value="{{$order->orderDetail->product_id}}">
                        <input type="hidden" name="product_name" value="{{$order->orderDetail->product->name}}">
                        <input type="hidden" name="product_amount" value="{{$order->orderDetail->amount}}">
                        <input type="hidden" name="order_date" value="{{$order->created_at}}">
                        <button style="background-color: transparent; border: none" type="submit" class="cancel" ><span class="glyphicon glyphicon-remove-circle"></span></button>
                    </form>
                    @endif
                </td>
            </tr>
            @endif
            @endforeach
        </table>
    </div>
</div>

<script>
    $(function () {
        $('[data-toggle="popover"]').popover()
    })
</script>

@endsection