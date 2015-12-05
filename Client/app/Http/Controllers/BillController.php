<?php

namespace App\Http\Controllers;

use App\Model\Bill;
use App\Model\Order;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('bill.billList', ['bills' => Bill::all()]);
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
        $bill = new Bill();
        $bill->name = $request->get('name');
        $bill->phone_number = $request->get('phone_number');
        $bill->email = $request->get('email');
        $bill->line1 = $request->get('line1');
        $bill->district = $request->get('district');
        $bill->province = $request->get('province');
        $bill->post_code = $request->get('post_code');
        $bill->product_name = $request->get('product_name');
        $bill->product_amount = $request->get('product_amount');
        $bill->total_price = $request->get('total_price');
        $bill->is_paid = $request->get('is_paid');
        $bill->order_id = $request->get('order_id');
        $bill->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bill = Bill::findOrNew($id);
        return view('bill.billInfo', ['bill' => $bill]);
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
    public function update(Request $request)
    {
        $bill = Bill::findOrNew($request->get('id'));
        $bill->is_paid = 1;
        $bill->save();

        $order = Order::where('server_order_id', '=', $request->get('order_id'))->first();
        $order->is_paid = 1;
        $order->save();

        $passingData = array(
            'order_id' => $request->get('order_id')
        );
        $data_string = json_encode($passingData);

        $url = curl_init('http://localhost:8000/api/order/updatepaid');
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );

        $result = curl_exec($url);

        return redirect('/bill');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
