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
    return view('welcome');
});

Route::get('profile', 'UserController@profile');
//Route::post('profile', 'UserController@update_avatar');

Route::get('profile', 'ProfileController@index')->name('profile');
Route::post('profile', 'ProfileController@updateProfile')->name('profile.update');
Route::post('profile/{profileId}/follow', 'ProfileController@followUser')->name('user.follow');
Route::post('/{profileId}/unfollow', 'ProfileController@unFollowUser')->name('user.unfollow');

Route::get('post/{id}',['as'=>'home.post','uses'=>'AdminPostsController@post']);

Route::group(['middleware'=>'admin:User'], function(){
    // user only

    
});


Route::group(['middleware'=>'admin:Admin,Talent'], function(){
//admin and talent
Route::get('/home', 'HomeController@index')->name('home');
Route::resource('/posts','PostsController');
Route::resource('/categories', 'CategoriesController');
Route::get('/post/category/{name}', 'CategoriesController@showAll')->name('category.showAll');

Route::get('/post/{id}', 'PostsController@show')->name('post.show');
Route::get('/post/{id}/edit', 'PostsController@edit')->name('post.edit');
Route::put('/post/{id}/edit', 'PostsController@update')->name('post.update');
Route::delete('/post/{id}/delete', 'PostsController@destroy')->name('post.delete');
Route::post('/like', 'LikesController@index');
Route::post('/comment', 'commentsController@index');

Route::get('/users', 'HomeController@listUser');
Route::get('/users/{id}', 'HomeController@showUser')->name('user.show');


Route::post('/friend', 'FriendController@index');
Route::get('/friend/{id}', 'FriendController@showFriends')->name('friend.show');
Route::post('/friend/remove', 'FriendController@remove');
Route::post('/request', 'FriendController@request');

});

//admin routes
Route::namespace('admin')->group(function(){
    Route::group(['middleware'=>'admin:Admin'], function(){
        //admin only
        Route::prefix('admin')->group(function(){
            Route::get('/', function(){
                return view('admin.index');
            });
            
            Route::resource('/users','AdminUsersController');
            Route::resource('/posts','AdminPostsController');
            Route::resource('/categories', 'AdminCategoriesController');
            Route::resource('/comments', 'PostCommentsController');
            Route::resource('/comments/replies', 'CommentRepliesController');
        });
    });
});


Route::group(['middleware'=>'auth'], function(){
    Route::Post('comment/reply', 'CommentConrollerReply@createreply');
});


Auth::routes();






