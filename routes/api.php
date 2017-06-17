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
	Route::get('/collections', 'CollectionsController@index');
	Route::post('/collections', 'CollectionsController@store');
	Route::get('/collections/{collection}', 'CollectionsController@show');
	Route::patch('/collections/{collection}', 'CollectionsController@update');
    Route::delete('/collections/{collection}', 'CollectionsController@destroy');
	Route::post('/collections/{collection}/tweets', 'CollectionTweetsController@store');
	Route::delete('/collections/{collection}/tweets/{tweet}', 'CollectionTweetsController@destroy');
});
