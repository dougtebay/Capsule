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

Route::get('/', 'SessionController@show');
Route::get('login', 'SessionController@create');
Route::get('login/callback', 'SessionController@callback');
Route::post('logout', 'SessionController@destroy');
