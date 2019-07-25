<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('tweet/save', 'PostController@store');

Route::get('api/user/','UserController@currentUser');

Route::get('users/{user}', 'UserController@show')->name('user.show');

Route::get('users/{user}/follow', 'UserController@follow')->name('user.follow');

Route::get('users/{user}/unfollow', 'UserController@unfollow')->name('user.unfollow');

Route::get('users/{user}/following', function($user){
	return $user;
});


Route::get('users/like/post/{post_id}', 'UserController@isUserLikedPost')->name('user.likes.post');

Route::get('posts', 'PostController@index')->name('posts.index');

Route::get('posts/user/{username}', 'PostController@byUser')->name('posts.user');

Route::post('posts/{post}/like', 'PostController@likePost')->name('posts.like');

Route::get('posts/{post_id}/replies', function($post_id){
	return json_encode(App\Post::find($post_id)->replies()->with(['user'])->orderBy('created_at','desc')->get());
});
Route::post('posts/reply/save', 'PostController@replyPost');

Route::get('test', 'TestController@index')->name('test');
Route::post('test', 'TestController@store')->name('test.store');



