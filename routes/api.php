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

//Web Services
Route::get('/user/{user}/{password}',['uses'=>'ApiLoginController@generarToken']);
Route::get('/user/{token}/',['uses'=>'ApiLoginController@iniciarSesion']);
Route::get('/userInfo/{token}',['uses'=>'ApiLoginController@userInfo']);
Route::get('/userNoti/{token}',['uses'=>'ApiLoginController@userNoti']);
Route::post('/user/InfoDevice/{token}',['uses'=>'ApiLoginController@infoDevice']);
Route::post('/user/deviceToken',['uses'=>'ApiLoginController@saveDeviceToken']);
Route::get('/user/recoveryPwd/{email}',['uses'=>'ApiLoginController@sendEmail']);
