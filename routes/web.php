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

Route::get('/', 'web\HomeController@index');

//Post routes
Route::get('posts/following', 'web\PostController@followingPosts');
Route::resource('posts', 'web\PostController');

//Profile routes
Route::prefix('profiles')->group(function() {
    Route::get('me', 'web\ProfileController@myProfile');
    Route::put('password', 'web\ProfileController@updateAuthUserPassword');
    Route::post('{id}/update_photo', 'web\ProfileController@updatePhoto');
    Route::post('{id}/follow', 'web\ProfileController@followUser');
    Route::delete('{id}/follow', 'web\ProfileController@unfollowUser');
});
Route::resource('profiles', 'web\ProfileController');

//Comment routes
Route::resource('comments', 'web\CommentController');





Auth::routes();

Route::get('/home', 'web\HomeController@index')->name('home');
