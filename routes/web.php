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
    $data = ['user' => App\User::find(1)->first(), 'agent' => App\Agents::find(1)->first()];

    \Mail::send('reviews.email', $data, function ($message) {
    $message->subject('Email Subject');
    $message->from('acb@example.com');
    $message->to('xyz@example.com');
});

    return view('welcome');
});
