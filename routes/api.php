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


// the routes automatically add [api] prefix 
// add namespace becouse the controller inside app/http/controllers/api/
Route::namespace('api\auth')->group(function(){
	Route::post('login', 'ApiController@login');
	Route::post('register', 'ApiController@register');
});


Route::namespace('pi\auth')->middleware('auth.jwt')->group(function(){
	Route::get('logout', 'ApiController@logout');
	Route::get('user', 'ApiController@getAuthUser');
	Route::post('user/{user}/add_friend', 'userController@addFollower');
});

	Route::get('posts','PostsApiController@index');
	Route::get('posts/{id}','PostsApiController@show');
	Route::post('posts','PostsApiController@store');
	Route::post('posts/{id}','PostsApiController@update');
	Route::delete('posts/delete/{id}','PostsApiController@delete');
	Route::get('categories','CategoriesApiController@index');
	Route::get('categories/{id}', 'CategoriesApiController@showAll');
	Route::get('users','UserApiController@index');
	Route::get('user/{id}','UserApiController@showUser');
	Route::post('user/{id}','UserApiController@update');
	Route::get('liked','LikesApiController@index');
	Route::get('comments','PostsCommentsApiController@index');
	Route::get('comments/{id}','PostsCommentsApiController@show');
	Route::post('comments/{id}','PostsCommentsApiController@update');
	Route::post('comments','PostsCommentsApiController@store');
	Route::delete('comments/delete/{id}','PostsCommentsApiController@delete');



