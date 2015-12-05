<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

//API
Route::post('/api/order/cancel', 'OrderController@cancelOrderAPI');
Route::post('/api/order/confirm', 'OrderController@confirmOrderAPI');
Route::post('/api/order/responser-order-id/{id}', 'OrderController@getBackOrderId');
Route::post('/api/bill/create', 'BillController@store');
Route::post('/api/notification/add', 'NotificationController@store');


Route::get('/order', 'OrderController@index');
Route::post('/order', 'OrderController@store');
Route::post('/order/cancel', 'OrderController@cancelOrder');
Route::get('/order/placeorder', 'OrderController@placeOrder');

Route::post('/notification', 'NotificationController@store');
Route::get('/notification', 'NotificationController@index');
Route::put('/notification/read/{id}', 'NotificationController@update');


Route::get('/bill', 'BillController@index');
Route::post('/bill/paybill', 'BillController@update');
Route::get('/bill/{id}', 'BillController@show');