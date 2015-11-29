<?php

namespace App\Http\Controllers;

use App\Model\Customer;
use App\Model\CustomerAddress;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Model\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
            return back()->with([
            'response_order_message' => 'fail',
            'response_order_message_detail' => 'Customer name is required'
            ]);
        }

        $customer = Customer::findOrNew($request->get('customer_name'));
        if($customer->id == null){
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

        return back()->with([
            'response_order_message' => 'success',
            'response_order_message_detail' => 'Thank you'
        ]);
//        return  response()->json([
//            'response_message' => 'success',
//            'response_data' => 'OK'
//        ]);
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

    public function cancelOrder(Request $request) {
        $order = Order::findOrNew($request->get('id'));
        $order->status = 2;//canceled
        $order->save();
        return redirect()->back();
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
        $order = Order::findOrNew($request->get('id'));
        $order->status = 1; //accepted
        $order->save();

        $product = Product::findOrNew($request->get('productId'));
        $product->amount = $product->amount - $request->get('productAmount');
        $product->save();

        //return invoice to customer
        return redirect()->back();
    }
}
