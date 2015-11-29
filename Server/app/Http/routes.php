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
Route::get('/api/product', 'ProductController@allProductsApi');
Route::get('/api/product/{slug}', 'ProductController@productApi');
Route::get('/api/order', 'OrderController@instruction');
Route::post('/api/order/placeorder', 'OrderController@store');
Route::get('/api/order/{id}', 'OrderController@show');


//NORMAL
Route::get('/productcategory', 'ProductCategoryController@index');
Route::post('/productcategory', 'ProductCategoryController@store');
Route::get('/productcategory/add', 'ProductCategoryController@create');


Route::get('/productsubcategory', 'ProductSubCategoryController@index');
Route::post('/productsubcategory', 'ProductSubCategoryController@store');
Route::get('/productsubcategory/add', 'ProductSubCategoryController@create');


Route::get('/product', 'ProductController@index');
Route::get('/product/overview', 'ProductController@overview');
Route::post('/product', 'ProductController@store');
Route::get('/product/add', 'ProductController@create');
Route::get('/product/{slug}', 'ProductController@show');

Route::get('/order', 'OrderController@index');
Route::post('/order/cancel', 'OrderController@cancelOrder');
Route::post('/order/accept', 'OrderController@acceptOrder');
