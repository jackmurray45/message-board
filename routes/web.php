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

Route::get('/', 'web\HomeController@index')->name('home.index');
Route::get('posts/following', 'web\PostController@followingPosts')->name('posts.following');
Route::resource('posts', 'web\PostController');
Route::get('profiles/following', 'web\ProfileController@followingProfiles')->name('profiles.following');
Route::get('profiles/me', 'web\ProfileController@myProfile')->name('profiles.me');
Route::put('profiles/password', 'web\ProfileController@updateAuthUserPassword')->name('profiles.password');
Route::resource('profiles', 'web\ProfileController');
Route::resource('comments', 'web\CommentController');





Auth::routes();

Route::get('/home', 'web\HomeController@index')->name('home');
