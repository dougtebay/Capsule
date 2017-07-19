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

Route::group(['middleware' => 'api'], function() {
	Route::get('/search', 'SearchController@index');
	Route::get('/users/{user}/collections', 'UserCollectionsController@index');
	Route::post('/users/{user}/collections', 'UserCollectionsController@store');
	Route::get('/users/{user}/collections/{collection}', 'UserCollectionsController@show');
	Route::patch('/users/{user}/collections/{collection}', 'UserCollectionsController@update');
    Route::delete('/users/{user}/collections/{collection}', 'UserCollectionsController@destroy');
	Route::post('/collections/{collection}/tweets', 'CollectionTweetsController@store');
	Route::delete('/collections/{collection}/tweets/{tweet}', 'CollectionTweetsController@destroy');
});
