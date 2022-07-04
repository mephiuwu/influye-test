<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/items', 'ItemsController@getItems');
Route::put('/item', 'ItemsController@createItem');
Route::delete('/item/{id_item}', 'ItemsController@deleteItem');
Route::put('/item/{id_item}/stock', 'ItemsController@addStock');
Route::get('transactions/{id_item}', 'ItemsController@getTransactions');