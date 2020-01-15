<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register','Api\NormalController@register');
Route::post('/login','Api\NormalController@login');

Route::middleware('auth:api-user')->group(function(){
    Route::post('/order', 'Api\NormalController@order');

    Route::put('/points', 'Api\NormalController@points');

    Route::get('/menu', 'Api\NormalController@get');
    Route::get('/{user}/orders', 'Api\NormalController@getOrders');
});


Route::post('/admin/login', 'Api\AdminController@login');
Route::post('/admin/register','Api\AdminController@register');

Route::middleware('auth:admin')->group(function(){
    Route::post('/admin/add', 'Api\AdminController@addFoodItem');

    Route::get('/admin/items', 'Api\AdminController@getFoodItems');
    Route::get('/admin/getOrders', 'Api\AdminController@getOrders');

    Route::delete('/admin/delete/{id}', 'Api\AdminController@deleteFoodItem');
    Route::put('/admin/new/menu', 'Api\AdminController@newMenu');
});

