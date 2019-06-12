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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// if the controllers in app/http/controllers/
// Route::post('login', 'ApiController@login');
// Route::post('register', 'ApiController@register');


// the routes automatically add [api] prefix 
// add namespace becouse the controller inside app/http/controllers/api/
Route::namespace('api\auth')->group(function(){
	Route::post('login', 'ApiController@login');
	Route::post('register', 'ApiController@register');
});

Route::namespace('api\auth')->middleware('auth.jwt')->group(function(){
	Route::get('logout', 'ApiController@logout');
 
	Route::get('user', 'ApiController@getAuthUser');
});



// Route::namespace('api')->prefix('api')->middleware('auth.jwt')->group(function(){
// 	Route::get('logout', 'ApiController@logout');
 
// 	Route::get('user', 'ApiController@getAuthUser');

// 	Route::get('products', 'ProductController@index');
// 	Route::get('products/{id}', 'ProductController@show');
// 	Route::post('products', 'ProductController@store');
// 	Route::put('products/{id}', 'ProductController@update');
// 	Route::delete('products/{id}', 'ProductController@destroy');
// });


// Route::namespace('api')->group(function(){
// 	Route::group(['middleware' => 'auth.jwt'], function () {
// 		Route::prefix('api')->group(function(){
// 			// place your routes here
// 		});
// 	});

// });

