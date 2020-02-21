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

Route::group(['prefix' => 'agents'], function () {
    Route::get('{id}', 'AgentsController@show');
});



Route::group(['prefix' => 'reviews'], function () {
  Route::get('/', 'ReviewsController@index');
  Route::get('store', 'ReviewsController@store');
});

Route::get('/users/{id}', 'UsersController@show');