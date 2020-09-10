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
Route::resource('posts', 'web\PostController');

//Profile routes
Route::prefix('profiles')->group(function() {
    Route::get('me', 'web\UserController@myProfile');
    Route::put('password', 'web\UserController@updateAuthUserPassword');
    Route::post('{id}/update_photo', 'web\UserController@updatePhoto');
    Route::post('{id}/follow', 'web\UserController@followUser');
    Route::delete('{id}/follow', 'web\UserController@unfollowUser');
});
Route::resource('profiles', 'web\UserController');

//Comment routes
Route::resource('comments', 'web\CommentController');





Auth::routes();

Route::get('/home', 'web\HomeController@index')->name('home');
