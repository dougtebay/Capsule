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

Route::group(['middleware' => 'auth'], function() {
    Route::post('/logout', 'LoginController@destroy');
    Route::get('/search', 'SearchController@index');

	Route::get('/collections', 'CollectionController@index');
    Route::get('/collections/create', 'CollectionController@create');
    Route::post('/collections', 'CollectionController@store');
    Route::get('/collections/{collection}', 'CollectionController@show');
    Route::get('/collections/{collection}/edit', 'CollectionController@edit');
    Route::patch('/collections/{collection}', 'CollectionController@update');
    Route::delete('/collections/{collection}', 'CollectionController@destroy');

    Route::post('/tweets', 'TweetController@store');
});
