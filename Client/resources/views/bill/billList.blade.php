@extends('master')

@section('title', 'Bills')

@section('content')


    @if(Session::has('response_order_message'))
        <div id="alert" class="alert alert-success">
            {{ Session::get('flash_message') }}
        </div>
    @endif


    <div class="container-fluid">
        <div class="col-md-12 text-center">
            <h1>Bill</h1>
        </div>
        <table class="table">
            <tr>
                <th>id</th>
                <th>order_id</th>
                <th>product_name</th>
                <th>product_amount</th>
                <th>total_price</th>
                <th>date</th>
                <th>payment status</th>
                <th>action</th>
            </tr>

            @foreach($bills as $bill)
                <tr>
                    <td>{{$bill->id}}</td>
                    <td>{{$bill->order_id}}</td>
                    <td>{{$bill->product_name}}</td>
                    <td>{{$bill->product_amount}}</td>
                    <td>{{number_format($bill->total_price)}}</td>
                    <td>{{$bill->created_at}}</td>
                    @if($bill->is_paid == 0)
                        <td style="color: orange"><strong>pending</strong></td>
                        @else
                        <td style="color: darkgreen"><strong>paid</strong></td>
                    @endif
                    <td>
                        <a href="/bill/{{$bill->id}}" class="btn btn-sm btn-info">Bill info</a>
                    </td>
                </tr>
                @endforeach

        </table>

    </div>

    <script type="text/javascript">
        $('#alert').delay(3000).fadeOut()
    </script>
@endsection