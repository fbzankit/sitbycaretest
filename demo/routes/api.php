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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Without using authentiaton
Route::post('register',[App\Http\Controllers\Api\Register::Class,'register']);
Route::post('login',[App\Http\Controllers\Api\Login::Class,'login']);

// Authentication route
Route::group(['middleware' => 'auth.jwt'],function(){
	Route::post('profile',[App\Http\Controllers\Api\Login::Class,'profile']);
	Route::post('logout',[App\Http\Controllers\Api\Login::Class,'logout']);
});
