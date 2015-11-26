<?php

namespace App\Http\Controllers;

use App\Model\Customer;
use App\Model\CustomerAddress;
use App\Model\Order;
use App\Model\OrderDetail;
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
        $order = Order::all();
        return view('order.orderList', ['orders' => $order]);
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
                'response_message' => 'fail',
                'response_data' => 'Customer name is required',
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

//        $order = new Order();
//        $order->customer_id = $customer->id;
//        $order->status = 0;
//        $order->save();
//        $orderDetailController = new OrderDetailController();
//        $orderDetailController->store($request, $order->id);

        return  response()->json([
            'response_message' => 'success',
            'response_data' => 'OK'
        ]);
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

    public function cancelOrder($id) {
        $order = Order::findOrNew($id);
        $order->status = 2;//canceled
        $order->save();
    }

    public function getOrderByCustomerId($customerId){
        $order = Order::where('customer_id', '=', $customerId);
        return response()->json(['order' => $order]);
    }

    public function instruction(){

        $customer = [
            'customerName' => 'customer_name',
            'customerPhoneNumber' => 'customer_phone_number',
            'customerEmail' => 'customer_email',
        ];

        $customerAddress = [
            'addressLine1' => 'line1',
            'addressLine2' => 'line2',
            'addressDistrict' => 'district',
            'addressProvince' => 'province',
            'addressPostCode' => 'post_code',
        ];

        $product = [
            'productId' => 'id',
            'productName' => 'name',
            'productAmount' => 'amount',
            'productPrice' => 'price',
        ];

        $requireInformation = [
            'product_information' => $product,
            'customer_information' => $customer,
            'address_information' => $customerAddress
        ];
//        $instruction->customer = $customer;
//        $instruction->customer->address = $customerAddress;
        return response()->json([
            'response_message' => 'success',
            'required_information' => $requireInformation
        ]);
    }

    public function acceptOrder($id){
        $order = Order::findOrNew($id);
        $order->status = 1; //accepted
        $order->save();

        //return invoice to customer
        return null;
    }
}
