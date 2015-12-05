@extends('master')

@section('title', 'Bill Information')

@section('content')


    @if(Session::has('response_order_message'))
        <div id="alert" class="alert alert-success">
            {{ Session::get('flash_message') }}
        </div>
    @endif


    <div class="container">
        <div class="col-md-12">
            @if($bill->is_paid == 0)
                <h1 class="text-right">Bill</h1>
                @else
                <h1 class="col-md-6" style="color: red;">THIS BILL IS ALREADY PAID</h1>
                <h1 class="text-right col-md-6">Bill</h1>
            @endif
            <hr class="col-md-12">
            <div class="col-md-8">
                <h3>Naive Beverage</h3>
                <br>
                <p style="font-size: 15px">
                    Charn Issara Tower 2,<br>
                    34th fl., New Petchaburi Rd,<br>
                    Bang Kapi, Huai Khwang,<br>
                    Bangkok 10310
                </p>
            </div>
            <div class="col-md-4">
                <div style="padding-top: 20px;" class="col-md-12">
                    <div class="col-md-4">
                        <p>DATE</p>
                    </div>
                    <div style="background-color: darkblue; color: white" class="col-md-8 text-center">
                        <p>{{$bill->created_at}}</p>
                    </div>
                    <div class="col-md-4">
                        <p>Bill #</p>
                    </div>
                    <div style="border: solid 1px; border-bottom: none" class="col-md-8 text-center">
                        <p>{{$bill->id}}</p>
                    </div>
                    <div class="col-md-4">
                        <p>Customer #</p>
                    </div>
                    <div style="border: solid 1px" class="col-md-8 text-center">
                        <p>286</p>
                    </div>
                </div>
            </div>
{{--bill to--}}
            <div class="col-md-12"></div>
            <div style="padding-top: 25px;" class="col-md-4">
                <div style="background-color: darkblue; color: white" class="col-md-10">
                    <p style="font-size: 17px"><strong>Bill To</strong></p>
                </div>
                <div style="padding-top: 10px;" class="col-md-12">
                    <p>Naive Bakery<br>
                        {{$bill->line1}},<br>
                        {{$bill->district}}, {{$bill->province}}, {{$bill->post_code}}<br>
                        {{$bill->phone_number}}
                    </p>
                </div>
            </div>

            <div class="col-md-12">
                <table width="100%" class="table">
                <tr style="background-color: darkblue; color: white">
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Price</th>
                </tr>
                <tr>
                    <td>{{$bill->product_name}}</td>
                    <td>{{$bill->product_amount}}</td>
                    <td>{{number_format($bill->total_price)}}</td>
                </tr>
                <tr>
                    <td>Service Fee</td>
                    <td> </td>
                    <td>1,500</td>
                </tr>
                <tr>
                    <td>Shipping Cost</td>
                    <td> </td>
                    <td>20,000</td>
                </tr>
                    </table>
            </div>
            <div class="col-md-12">
                </div>
                <div style="padding-top: 20px;" class="col-md-6">
                    <div style="background-color: darkblue; color: white" class="col-md-12">
                        <p>OTHER COMMENTS</p>
                    </div>
                    <div style="border-bottom: solid 1px; border-right: solid 1px; border-left: solid 1px;" class="col-md-12">
                        <p>
                            1. Total payment due in 30 days<br>
                            2. Please include bill number on your check
                        </p>
                    </div>

                </div>

                <div class="col-md-offset-3 col-md-3">
                    <div class="col-md-6">
                        <p><b>Subtotal</b></p>
                    </div>
                    <div class="col-md-6 text-right">
                        <p><b>{{number_format($bill->total_price + 1500 + 20000)}}</b></p>
                    </div>
                    <div class="col-md-6">
                        <p><b>Tax rate</b></p>
                    </div>
                    <div style="border: solid 1px;" class="col-md-6 text-right">
                        <p><b>7 %</b></p>
                    </div>
                    <div class="col-md-6">
                        <p><b>Tax due</b></p>
                    </div>
                    <div class="col-md-6 text-right">
                        <p><b>{{number_format(($bill->total_price + 1500 + 20000)*0.07)}}</b></p>
                    </div>
                    <div class="col-md-6">
                        <p><b>Other</b></p>
                    </div>
                    <div style="border: solid 1px;" class="col-md-6 text-right">
                        <p><b>-</b></p>
                    </div>
                    <div style="background-color: black; margin-top: 10px;" class="col-md-12"></div>
                    <div style="background-color: black; margin-top: 5px;" class="col-md-12"></div>
                    <div class="col-md-6">
                        <p style="font-size: 16px;"><strong>Grand total</strong></p>
                    </div>
                    <div class="col-md-6 text-right">
                        <p style="font-size: 16px;"><strong>{{number_format(($bill->total_price + 1500 + 20000)+(($bill->total_price + 1500 + 20000)*0.07))}}</strong></p>
                    </div>
                </div>
        </div>
        <div style="padding-top: 50px;" class="col-md-12 text-center">
            <p>If you have any question about this bill, please contact</p>
            <p>Sam Smith, Phone number +6688-255-2314, Email naivebeverage-customersupport@naive.com</p>
        </div>
        <div style="padding-top: 10px;" class="col-md-12 text-center">
            <h3>Thank You For Your Business!</h3>
        </div>

        @if($bill->is_paid == 0)
        <nav class="navbar navbar-inverse navbar-fixed-bottom" style="background-color: transparent; border: none">
            <div class="container-fluid">
                <form action="/bill/paybill" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="{{$bill->id}}">
                    <input type="hidden" name="order_id" value="{{$bill->order_id}}">
                    <input type="submit" class="btn btn-lg btn-success" value="Pay bill">
                </form>
            </div><!-- /.container-fluid -->
        </nav>

            @else
            <nav class="navbar navbar-inverse navbar-fixed-bottom" style="background-color: transparent; border: none">
                <div class="container-fluid">
                    <a href="/bill" class="btn btn-default">Back</a>
                </div><!-- /.container-fluid -->
            </nav>
            @endif


    </div>
    <style>
        table {
            border-collapse: collapse;
        }

        table {
            border: 1px solid black;
        }
    </style>

    <script type="text/javascript">
        $('#alert').delay(3000).fadeOut()
    </script>
@endsection