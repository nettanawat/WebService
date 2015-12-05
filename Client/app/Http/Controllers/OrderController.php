<?php

namespace App\Http\Controllers;

use App\Model\Order;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use PhpSpec\Exception\Exception;

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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required',
            'customer_email' => 'required',
            'customer_phone_number' => 'required',
            'line1' => 'required',
            'district' => 'required',
            'province' => 'required',
            'post_code' => 'required',
            'product_id' => 'required',
            'product_name' => 'required',
            'amount' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        $order = new Order();
        $order->server_order_id = 1;
        $order->product_id = $request->get('product_id');
        $order->product_name = $request->get('product_name');
        $order->product_amount = $request->get('amount');
        $order->status = 0;
        $order->is_paid = 0;
        $order->save();

        $data = array(
            'order_id' => $order->id,
            'customer_name' => $request->get('customer_name'),
            'customer_email' => $request->get('customer_email'),
            'customer_phone_number' => $request->get('customer_phone_number'),
            'line1' => $request->get('line1'),
            'district' => $request->get('district'),
            'province' => $request->get('province'),
            'post_code' => $request->get('post_code'),
            'product_id' => $request->get('product_id'),
            'product_name' => $request->get('product_name'),
            'amount' => $request->get('amount')
        );

        $data_string = json_encode($data);

        $url = curl_init('http://localhost:8000/api/order/placeorder');
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );

        $result = curl_exec($url);
        $this->getBackOrderId($result, $order->id);

        Session::flash('flash_message', $result);
        return redirect('/order');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function placeOrder()
    {
        $obj = file_get_contents('http://localhost:8000/api/product');
        $products = json_decode($obj, true);
        return view('order.placeorder', $products);
    }

    public function cancelOrder(Request $request)
    {
        $order = Order::findOrNew($request->get('order_id'));
        $order->status = 2;
        $order->save();

        $data = array(
            'server_order_id' => $request->get('server_order_id')
        );
        $data_string = json_encode($data);

        $url = curl_init('http://localhost:8000/api/order/cancel');
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );

        $result = curl_exec($url);
        Session::flash('flash_message', 'Your order is canceled');
        return redirect('/order');
    }

    public function confirmOrderAPI(Request $request)
    {

        $order = Order::where('server_order_id', '=', $request->get('order_id'))->first();
        $order->status = 1;
        $order->save();

        $notificationController = new NotificationController();
        $notificationController->store($request);

        return $order->id;
    }

    public function cancelOrderAPI(Request $request)
    {
        $order = Order::where('server_order_id', '=', $request->get('order_id'))->first();
        $order->status = 2;
        $order->save();

        $notificationController = new NotificationController();
        $notificationController->store($request);
        return $order->id;
    }

    public function getBackOrderId($serverOrderId, $id)
    {
        $order = Order::findOrNew($id);
        $order->server_order_id = $serverOrderId;
        $order->save();
    }
}
