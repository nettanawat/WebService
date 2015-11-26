<?php

namespace App\Http\Controllers;

use App\Model\Customer;
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
        $customer = Customer::findOrNew($request->get('customer_id'));
        if($customer->id == null){
            return response()->json([
                'response_message' => 'fail, invalid customer id'
            ]);
        }
        $order = new Order();
        $order->customer_id = $customer->id;
        $order->status = 0;
        $order->save();
        $orderDetailController = new OrderDetailController();
        $orderDetailController->store($request, $order->id);

        return  response()->json([
            'response_message' => 'success',
            'response_data' => $order
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
        $order->status = 2;
        $order->save();
    }

    public function getOrderByCustomerId($customerId){
        $order = Order::where('customer_id', '=', $customerId);
        return response()->json(['order' => $order]);
    }

}
