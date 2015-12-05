<?php

namespace App\Http\Controllers;

use App\Model\Bill;
use App\Model\Customer;
use App\Model\CustomerAddress;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Model\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();
        foreach($orders as $order){
            if($order->orderDetail->amount > $order->orderDetail->product->amount){
                $order->stock_status = false;
            } else {
                $order->stock_status = true;
            }
        }
        return view('order.orderList', ['orders' => $orders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->get('customer_name') == null) {
            return response()->json([
            'response_order_message' => 'fail',
            'response_order_message_detail' => 'Customer name is required'
            ]);
        }

        $customer = Customer::where('name', '=', $request->get('customer_name'))->first();
        if($customer == null) {
            $customer = new Customer();
            $customer->name = $request->get('customer_name');
            $customer->slug = str_slug($customer->name);
            $customer->phone_number = $request->get('customer_phone_number');
            $customer->email = $request->get('customer_email');
            $customer->save();

            $customerAddress = new CustomerAddress();
            $customerAddress->line1 = $request->get('line1');
            $customerAddress->line2 = $request->get('line2');
            $customerAddress->district = $request->get('district');
            $customerAddress->province = $request->get('province');
            $customerAddress->post_code = $request->get('post_code');
            $customerAddress->customer_id = $customer->id;
            $customerAddress->save();
        }

        $order = new Order();
        $order->customer_id = $customer->id;
        $order->status = 0;
        $order->save();

        $orderDetail = new OrderDetail();
        $orderDetail->order_id = $order->id;
        $orderDetail->product_id = $request->get('product_id');
        $orderDetail->amount = $request->get('amount');
        $orderDetail->total_price = Product::findOrNew($orderDetail->product_id)->price * $orderDetail->amount;
        $orderDetail->save();

        return $order->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return sizeof(Order::all());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function getOrderByCustomerId($customerId){
        $order = Order::where('customer_id', '=', $customerId);
        return response()->json(['order' => $order]);
    }

    public function instruction(){

        $customer = [
            'customer_name' => 'customer_name',
            'customer_phone_number' => 'customer_phone_number',
            'customer_email' => 'customer_email',
        ];

        $customerAddress = [
            'line1' => 'line1',
            'line2' => 'line2',
            'district' => 'district',
            'province' => 'province',
            'post_code' => 'post_code',
        ];

        $product = [
            'id' => 'id',
            'name' => 'name',
            'amount' => 'amount',
            'price' => 'price',
        ];

        $requireInformation = [
            'product_information' => $product,
            'customer_information' => $customer,
            'address_information' => $customerAddress,
            'url' => '/api/order/placeorder'
        ];
//        $instruction->customer = $customer;
//        $instruction->customer->address = $customerAddress;
        return response()->json([
            'response_message' => 'success',
            'required_information' => $requireInformation
        ]);
    }

    public function acceptOrder(Request $request){

        $order = Order::findOrNew($request->get('order_id'));
        $order->status = 1; //accepted
        $order->save();

        $product = Product::findOrNew($request->get('product_id'));
        $product->amount = $product->amount - $request->get('product_amount');
        $product->save();


        $bill = new Bill();
        $bill->status = 0;
        $bill->customer_id = 1;
        $bill->order_id = $order->id;
        $bill->save();

        $passingData = array(
            'order_id' => $order->id,
            'message_title' => 'Confirmed order',
            'message_detail' => 'You order id '.$request->get('order_id').' has been confirm (product_name : '
                .$request->get('product_name'). ', order_date : '.$request->get('order_date').')'
        );
        $data_string = json_encode($passingData);

        $url = curl_init('http://localhost:8080/api/order/confirm');
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );

//        response back
        $result = curl_exec($url);

        $data = array(
            'name' => $order->customer->name,
            'phone_number' => $order->customer->phone_number,
            'email' => $order->customer->email,
            'line1' => $order->customer->customerAddress->line1,
            'district' => $order->customer->customerAddress->district,
            'province' => $order->customer->customerAddress->province,
            'post_code' => $order->customer->customerAddress->post_code,
            'product_name' => $order->orderDetail->product->name,
            'product_amount' => $order->orderDetail->amount,
            'total_price' => $order->orderDetail->total_price,
            'is_paid' => 0,
            'order_id' => $order->id
        );
        $data_string = json_encode($data);

        $url2 = curl_init('http://localhost:8080/api/bill/create');
        curl_setopt($url2, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url2, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($url2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url2, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );

        $result2 = curl_exec($url2);


        $notificationData = array(
            'message_title' => 'Notify Payment',
            'message_detail' => 'Your bill which has order id '.$request->get('order_id'). 'is waiting for payment.'
        );
        $data_string = json_encode($notificationData);

        $notificationUrl = curl_init('http://localhost:8080/api/notification/add');
        curl_setopt($notificationUrl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($notificationUrl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($notificationUrl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($notificationUrl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );

//        response back
        $result3 = curl_exec($notificationUrl);

        return redirect()->back();
    }

    public function cancelOrder(Request $request) {

        $order = Order::findOrNew($request->get('order_id'));
        $order->status = 2;//canceled
        $order->save();

        $passingDate = array(
            'order_id' => $order->id,
            'message_title' => 'Canceled order',
            'message_detail' => 'You order id '.$request->get('order_id').' has been canceled (product_name : '
                .$request->get('product_name'). ', order_date : '.$request->get('order_date').')'
        );
        $data_string = json_encode($passingDate);

        $url = curl_init('http://localhost:8080/api/order/cancel');
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );

//        response back
        $result = curl_exec($url);
        return redirect()->back();
    }

    public function cancelOrderAPI(Request $request){
        $order = Order::findOrNew($request->get('server_order_id'));
        $order->status = 2;//canceled
        $order->save();
        return $order->id;
    }

    public function updatepaid(Request $request){
        $order = Order::findOrNew($request->get('order_id'));
        $order->is_paid = 1;//canceled
        $order->save();
        return $order->id;
    }
}
