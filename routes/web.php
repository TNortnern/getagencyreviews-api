<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  

    return view('welcome');
});

Route::get('/email', function () {
return view('reviews.email')->with([
 'agent' => App\User::where('id', 1)->with('profile')->first(),
 'client' => App\Client::where('id', 1)->first(),
 'email' => App\ReviewRequest::where('id', 1)->first()
]);
});