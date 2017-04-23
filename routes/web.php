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
	return view('app');
});

Route::get('/login', 'LoginController@create');
Route::get('/login/callback', 'LoginController@callback');
Route::post('/logout', 'LoginController@destroy')->middleware('auth');

Route::group(['middleware' => ['auth', 'redirect']], function() {
    Route::get('/search');
	Route::get('/collections');
    Route::get('/collections/create');
    Route::get('/collections/{collection}');
    Route::get('/collections/{collection}/edit');
});
