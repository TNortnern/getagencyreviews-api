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


Route::group(['prefix' => 'agents'], function () {
    Route::get('{id}', 'AgentsController@show');
});



Route::group(['prefix' => 'reviews'], function () {
  Route::get('/', 'ReviewsController@index');
  Route::post('/', 'ReviewsController@store');
});


Route::group(['prefix' => 'emails'], function () {
  Route::post('/', 'EmailsController@store');
  Route::get('/{id}', 'EmailsController@show');
});
Route::group(['prefix' => 'users'], function () {
  Route::get('/', 'UsersController@index');
  Route::post('/', 'UsersController@store');
  Route::get('/{id}', 'UsersController@show');
});
Route::group(['prefix' => 'profile'], function () {
  // post for images
  Route::post('/{id}', 'UserProfileController@update');
});