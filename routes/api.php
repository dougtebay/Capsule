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

Route::group(['middleware' => 'auth:api'], function() {
	Route::get('/search', 'SearchController@index');
	Route::get('/collections', 'CollectionController@index');
	Route::post('/collections', 'CollectionController@store');
	Route::get('/collections/{collection}', 'CollectionController@show');
	Route::patch('/collections/{collection}', 'CollectionController@update');
    Route::delete('/collections/{collection}', 'CollectionController@destroy');
	Route::post('/tweets', 'TweetController@store');
	Route::delete('/tweets/{tweet}', 'TweetController@destroy');
});
