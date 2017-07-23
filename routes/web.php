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

Route::group(['middleware' => ['auth', 'redirect.api']], function() {
    Route::get('/search');
	Route::get('/users/{user}/collections');
    Route::get('/users/{user}/collections/create');
    Route::get('/users/{user}/collections/{collection}');
    Route::get('/users/{user}/collections/{collection}/edit');
});
