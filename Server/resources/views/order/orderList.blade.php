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
                <th>order_amount</th>
                <th>in_stock</th>
                <th>total_price</th>
                <th>date</th>
                <th>status</th>
                <th>actions</th>
            </tr>
            @foreach($orders as $order)
            @if($order->stock_status == false)
            <tr class="alert-danger">
                <td>{{$order->id}}</td>
                <td>{{$order->customer->name}}</td>
                <td><a href="/product/{{$order->orderDetail->product->slug}}">{{$order->orderDetail->product->name}}</a></td>
                <td>{{number_format($order->orderDetail->amount)}}</td>
                <td>{{number_format($order->orderDetail->product->amount)}}</td>
                <td>{{number_format($order->orderDetail->total_price)}}</td>
                <td>{{$order->created_at}}</td>
                @if($order->status == 0)
                <td id="status{{$order->id}}">pending</td>
                @elseif($order->status == 1)
                <td id="status{{$order->id}}">confirmed</td>
                @else
                <td id="status{{$order->id}}">canceled</td>
                @endif
                <td>
                    @if($order->status == 0)
                    <form id="actionCancel{{$order->id}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="POST">
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
                <td id="status{{$order->id}}">pending</td>
                @elseif($order->status == 1)
                <td id="status{{$order->id}}">confirmed</td>
                @else
                <td id="status{{$order->id}}">canceled</td>
                @endif
                <td>
                    @if($order->status == 0)
                    <form id="actionConfirm{{$order->id}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="POST">
                        <input type="hidden" name="product_id" id="product{{$order->id}}" value="{{$order->orderDetail->product_id}}">
                        <input type="hidden" name="product_amount" id="product_amount{{$order->id}}" value="{{$order->orderDetail->amount}}">
                        <button style="background-color: transparent; border: none" id="{{$order->id}}" type="submit" class="confirm" ><span class="glyphicon glyphicon-ok-circle"></span></button>
                    </form>
                    <form id="actionCancel{{$order->id}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="POST">
                        <button style="background-color: transparent; border: none" id="{{$order->id}}" type="submit" class="cancel" ><span class="glyphicon glyphicon-remove-circle"></span></button>
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

    $("button.confirm").click(function(e) {
        e.preventDefault();
        var orderId = this.id;
        var productId = $('#product'+orderId).val();
        var productAmount = $('#product_amount'+orderId).val();
        if (confirm("Are you sure to confirm order?")) {
            $.ajax({
                method: "POST",
                url: "/order/accept",
                data: { id: orderId, productId: productId, productAmount: productAmount}
            }).done(function (deleteId) {
                $('#status' + orderId).html('confirmed');
                $('#actionConfirm' + orderId).remove();
                $('#actionCancel' + orderId).remove();
            });
        }
    });

    $("button.cancel").click(function(e) {
        e.preventDefault();
        var orderId = this.id;


        if (confirm("Are you sure to cancel order?")) {
            $.ajax({
                method: "POST",
                url: "/order/cancel",
                data: { id: orderId}
            }).done(function (deleteId) {
                $('#status' + orderId).html('canceled');
                $('#actionConfirm' + orderId).remove();
                $('#actionCancel' + orderId).remove();
            });
        }
    });
</script>

@endsection