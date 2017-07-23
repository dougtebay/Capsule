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

	Route::group(['middleware' => ['auth.user', 'auth.user.collection']], function() {
		Route::get('/users/{user}/collections', 'UserCollectionsController@index');
		Route::post('/users/{user}/collections', 'UserCollectionsController@store');
		Route::get('/users/{user}/collections/{collectionId}', 'UserCollectionsController@show');
		Route::patch('/users/{user}/collections/{collectionId}', 'UserCollectionsController@update');
	    Route::delete('/users/{user}/collections/{collectionId}', 'UserCollectionsController@destroy');
	});

	Route::group(['middleware' => 'auth.user.collection'], function() {
		Route::post('/collections/{collection}/tweets', 'CollectionTweetsController@store');
		Route::delete('/collections/{collection}/tweets/{tweet}', 'CollectionTweetsController@destroy');
	});
});
